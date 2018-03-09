<?php

namespace App\Application\DataTables;

use App\Application\Model\Log;
use Yajra\Datatables\Services\DataTable;

class LogsDataTable extends DataTable
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
            ->addColumn('id', 'admin.log.buttons.id')
            ->addColumn('delete', 'admin.log.buttons.delete')
            ->addColumn('view', 'admin.log.buttons.view')
            ->make(true);
    }

    /**
     * Get the query object to be processed by dataTables.
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder|\Illuminate\Support\Collection
     */
    public function query()
    {
        $query = Log::query();

        if(request()->has('from') && request()->get('from') != ''){
            $query = $query->whereDate('created_at' , '>=' , request()->get('from'));
        }

        if(request()->has('to') && request()->get('to') != ''){
            $query = $query->whereDate('created_at' , '<=' , request()->get('to'));
        }

        if(request()->has('action') && request()->get('action') != ''){
            $query = $query->where('action' , request()->get('action'));
        }

        if(request()->has('model') && request()->get('model') != ''){
            $query = $query->where('model' , request()->get('model'));
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
                'name' => "model",
                'data' => 'model',
                'title' => trans('log.model'),
            ],
            [
                'name' => "action",
                'data' => 'action',
                'title' => trans('log.action'),
            ],
            [
                'name' => "status",
                'data' => 'status',
                'title' => trans('log.status'),
            ],
            [
                'name' => "created_at",
                'data' => 'created_at',
                'title' => trans('log.created_at'),
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
        return 'Logdatatables_' . time();
    }
}