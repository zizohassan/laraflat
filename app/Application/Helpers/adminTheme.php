<?php


function layoutPath($file , $type = 'admin'){
    return $type == 'admin' ? "admin.theme.".env('THEME').".".$file  : "website.theme.".env('WEBSITE_THEME').".".$file;

}

function layoutMessage($type = 'admin'){
    return layoutPath("layout.messages" , $type);
}

function layoutExtend($type = 'admin'){
    return layoutPath("layout.app" , $type );
}

function layoutMenu($type = 'admin'){
    return layoutPath("layout.menu" , $type);
}
function layoutHomePage($type = 'admin'){
    return layoutPath("home" , $type);
}

/*
 * admin functions
 */



function layoutForm(){
    return layoutPath("layout.form");
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

/*
 * website functions
 */


function is_json($string,$return_data = false) {
    $data = json_decode($string);
    return (json_last_error() == JSON_ERROR_NONE) ? ($return_data ? $data : TRUE) : FALSE;
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
                            var width = 50;
                            this.api().columns().every(function (index) {
                                var column = this;
                                if(index  <=  allColumns){
                                if(index != 0){
                                    width=100;
                                }
                                    var title = $('#dataTableBuilder thead th').eq(index).text()
                                    var input = '<input type=\"text\" class=\"form-control\" style=\"width: '+width+'px;\" placeholder=\"'+title+'\" />';
                                    $(input).appendTo($(column.footer()).empty())
                                    .on('change', function () {
                                        column.search($(this).val(), false, false, true).draw();
                                    });
                                }
                            });
                }"
    ];
}