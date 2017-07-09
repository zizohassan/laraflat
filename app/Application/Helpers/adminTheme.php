<?php

function layoutPath($file){
    return "admin.theme.".env('THEME').".".$file;
}

function layoutMessage(){
    return layoutPath("layout.messages");
}

function layoutForm(){
    return layoutPath("layout.form");
}
function layoutExtend(){
    return layoutPath("layout.app");
}

function layoutMenu(){
    return layoutPath("layout.menu");
}

function layoutHeader(){
    return layoutPath("layout.header");
}

function layoutBreadcrumb(){
    return layoutPath("layout.breadcrumb");
}

function layoutTable(){
    return layoutPath("layout.table");
}

function dataTableConfig(){
    return [
        'dom'          => 'Bfrtip',
        'buttons'      => ['excel', 'print', 'reset', 'reload'],
        'responsive' => true,
//        'autoWidth' =>  true,
        'stateSave' => 'saveState',
        'initComplete' => "function () {
                            var allColumns = this.api().column().columns()[0].length -4 ;
                            var width = 20;
                            this.api().columns().every(function (index) {
                                var column = this;
                                if(index  <=  allColumns){
                                if(index != 0){
                                    width=100;
                                }
                                    var input = '<input type=\"text\" class=\"form-control\" style=\"width: '+width+'px;\" />';
                                    $(input).appendTo($(column.footer()).empty())
                                    .on('change', function () {
                                        column.search($(this).val(), false, false, true).draw();
                                    });
                                }
                            });
                }"
    ];
}