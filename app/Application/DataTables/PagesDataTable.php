<?php

namespace App\Application\DataTables;

use App\Application\Model\Page;
use Yajra\Datatables\Services\DataTable;

class PagesDataTable extends DataTable
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
             ->addColumn('edit', 'admin.page.buttons.edit')
             ->addColumn('delete', 'admin.page.buttons.delete')
             ->addColumn('view', 'admin.page.buttons.view')
            ->addColumn('title', 'admin.page.buttons.langcol')
             ->make(true);
    }
    /**
     * Get the query object to be processed by dataTables.
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder|\Illuminate\Support\Collection
     */
    public function query()
    {
        $query = Page::query();

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
                'name' => "title",
                'data' => 'title',
                'title' => adminTrans('page' , 'title'),
            ],
            [
                'name' => "status",
                'data' => 'status',
                'title' => adminTrans('page' , 'status'),
            ],
            [
                'name' => "date",
                'data' => 'date',
                'title' => adminTrans('page' , 'date'),
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
        return 'Pagedatatables_' . time();
    }
}