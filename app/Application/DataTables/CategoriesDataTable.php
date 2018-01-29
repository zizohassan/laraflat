<?php

namespace App\Application\DataTables;

use App\Application\Model\Categorie;
use Yajra\Datatables\Services\DataTable;

class CategoriesDataTable extends DataTable
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
            ->addColumn('id', 'admin.categorie.buttons.id')
            ->addColumn('edit', 'admin.categorie.buttons.edit')
            ->addColumn('delete', 'admin.categorie.buttons.delete')
            ->addColumn('view', 'admin.categorie.buttons.view')
            ->addColumn('title', 'admin.categorie.buttons.langcol')
            ->make(true);
    }

    /**
     * Get the query object to be processed by dataTables.
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder|\Illuminate\Support\Collection
     */
    public function query()
    {
        $query = Categorie::query();

        if(request()->has('from') && request()->get('from') != ''){
            $query = $query->whereDate('created_at' , '>=' , request()->get('from'));
        }

        if(request()->has('to') && request()->get('to') != ''){
            $query = $query->whereDate('created_at' , '<=' , request()->get('to'));
        }

        if(request()->has('title') && request()->get('title') != ''){
            $query = $query->where("title", 'like' , "%".request()->get('title')."%");
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
        return $this->builder()
            ->columns($this->getColumns())
            ->parameters(dataTableConfig());
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
                'name' => 'title',
                'data' => 'title',
                'title' => trans('categorie.title'),

            ],
            [
                'name' => 'view',
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
        return 'Categoriedatatables_' . time();
    }
}