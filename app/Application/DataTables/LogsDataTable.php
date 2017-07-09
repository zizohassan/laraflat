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
                'name' => "model",
                'data' => 'model',
                'title' => adminTrans('log' , 'model'),
            ],
            [
                'name' => "action",
                'data' => 'action',
                'title' => adminTrans('log' , 'action'),
            ],
            [
                'name' => "status",
                'data' => 'status',
                'title' => adminTrans('log' , 'status'),
            ],
            [
                'name' => "created_at",
                'data' => 'created_at',
                'title' => adminTrans('log' , 'created_at'),
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
        return 'Logdatatables_' . time();
    }
}