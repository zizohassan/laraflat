<?php

namespace App\Application\DataTables;

use App\Application\Model\Permission;
use Yajra\Datatables\Services\DataTable;

class PermissionsDataTable extends DataTable
{
    /**
     * Display ajax response.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajax()
    {
        return $this->datatables
            ->eloquent($this->query())
            ->addColumn('id', 'admin.permission.buttons.id')
            ->addColumn('edit', 'admin.permission.buttons.edit')
            ->addColumn('delete', 'admin.permission.buttons.delete')
            ->addColumn('view', 'admin.permission.buttons.view')
            ->addColumn('permission', 'admin.permission.buttons.permission')
            ->make(true);
    }

    /**
     * Get the query object to be processed by dataTables.
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder|\Illuminate\Support\Collection
     */
    public function query()
    {
        $query = Permission::query();


        if(request()->has('from') && request()->get('from') != ''){
            $query = $query->whereDate('created_at' , '>=' , request()->get('from'));
        }

        if(request()->has('to') && request()->get('to') != ''){
            $query = $query->whereDate('created_at' , '<=' , request()->get('to'));
        }

        if(request()->has('controller_name') && request()->get('controller_name') != ''){
            $query = $query->where('controller_name' , request()->get('controller_name'));
        }

        if(request()->has('method_name') && request()->get('method_name') != ''){
            $query = $query->where('method_name' , request()->get('method_name'));
        }

        return $this->applyScopes($query);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\Datatables\Html\Builder
     */
    public function html()
    {
        $html = $this->builder()
            ->columns($this->getColumns())
            ->parameters(dataTableConfig());
        if (getCurrentLang() == 'ar') {
            $html = $html->parameters([
                'language' => [
                    'url' => url('/vendor/datatables/arabic.json')
                ]
            ]);
        }
        return $html;
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            [
                'name' => "id",
                'data' => 'id',
                'title' => trans('curd.id'),
            ],
            [
                'name' => "controller_name",
                'data' => 'controller_name',
                'title' => trans('permission.Controller Name'),
            ],
            [
                'name' => "method_name",
                'data' => 'method_name',
                'title' => trans('permission.Method Name'),
            ],
            [
                'name' => "controller_type",
                'data' => 'controller_type',
                'title' => trans('permission.Controller Type'),
            ],
            [
                'name' => "permission",
                'data' => 'permission',
                'title' => trans('permission.action_view'),
            ],
            [
                'name' => "view",
                'data' => 'view',
                'title' => trans('curd.view'),
                'exportable' => false,
                'printable' => false,
                'searchable' => false,
                'orderable' => false,
            ],
            [
                'name' => 'edit',
                'data' => 'edit',
                'title' => trans('curd.edit'),
                'exportable' => false,
                'printable' => false,
                'searchable' => false,
                'orderable' => false,
            ],
            [
                'name' => 'delete',
                'data' => 'delete',
                'title' => trans('curd.delete'),
                'exportable' => false,
                'printable' => false,
                'searchable' => false,
                'orderable' => false,
            ],


        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Permissiondatatables_' . time();
    }
}