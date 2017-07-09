<?php

namespace App\Application\DataTables;

use App\Application\Model\Setting;
use Yajra\Datatables\Services\DataTable;

class SettingsDataTable extends DataTable
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
             ->addColumn('edit', 'admin.setting.buttons.edit')
             ->addColumn('delete', 'admin.setting.buttons.delete')
             ->addColumn('view', 'admin.setting.buttons.view')
             ->make(true);
    }
    /**
     * Get the query object to be processed by dataTables.
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder|\Illuminate\Support\Collection
     */
    public function query()
    {
        $query = Setting::query();

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
                'name' => "name",
                'data' => 'name',
                'title' => adminTrans('setting' , 'name'),
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
        return 'Settingdatatables_' . time();
    }
}