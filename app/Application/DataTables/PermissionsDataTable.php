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
             ->addColumn('edit', 'admin.permission.buttons.edit')
             ->addColumn('delete', 'admin.permission.buttons.delete')
             ->addColumn('view', 'admin.permission.buttons.view')
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

        return $this->applyScopes($query);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\Datatables\Html\Builder
     */
    public function html()
    {
        $html =  $this->builder()
            ->columns($this->getColumns())
            ->parameters(dataTableConfig());
        if(getCurrentLang() == 'ar'){
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
                'title' => adminTrans('curd' , 'id'),
            ],
            [
                'name' => "slug",
                'data' => 'slug',
                'title' => adminTrans('permission' , 'slug'),
            ],
            [
                'name' => "action_add",
                'data' => 'action_add',
                'title' => adminTrans('permission' , 'action_add'),
            ],
            [
                'name' => "action_edit",
                'data' => 'action_edit',
                'title' => adminTrans('permission' , 'action_edit'),
            ],
            [
                'name' => "action_delete",
                'data' => 'action_delete',
                'title' => adminTrans('permission' , 'action_delete'),
            ],
            [
                'name' => "action_view",
                'data' => 'action_view',
                'title' => adminTrans('permission' , 'action_view'),
            ],
            [
                'name' => "model",
                'data' => 'model',
                'title' => adminTrans('permission' , 'model'),
            ],
            [
                'name' => "view",
                'data' => 'view',
                'title' => adminTrans('curd' , 'view'),
                'exportable' => false,
                'printable' => false,
                'searchable' => false,
                'orderable' => false,
            ],
            [
                'name' => 'edit',
                'data' => 'edit',
                'title' => adminTrans('curd' , 'edit'),
                'exportable' => false,
                'printable' => false,
                'searchable' => false,
                'orderable' => false,
            ],
            [
                'name' => 'delete',
                'data' => 'delete',
                'title' => adminTrans('curd' , 'delete'),
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