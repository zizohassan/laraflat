---
title: API Reference

language_tabs:
- bash
- javascript

includes:

search: true

toc_footers:
- <a href='http://github.com/mpociot/documentarian'>Documentation Powered by Documentarian</a>
---
<!-- START_INFO -->
# Start to use system

First thing we use datatable , collective html to create the table view , repository design pattern:<br>
You will use the order <br>
```php
php artisan serve make:admin_model
```

this order will make this effective ,

1-make controller in Application\Controller\admin <br>
2-make view at Application\Views\admin <br>
3-make migration database\migrations <br>
4-make datatable class at Application\DataTables <br>
5-make model Application\model <br>


<!-- END_INFO -->



<!-- How_I_Will_Work -->
# How I Will Work


first use this command

```php
php artisan serve make:admin_model
```

then you must edit migration after that you must edit the datatable class<br>
to show data from database<br>
then edit the model validation and fillable and table name<br>
edit the form on Application\View\<br>


<!--How_I_Will_Work -->


<!-- Use_Rich_texT -->
# Use Rich Text
open the view form file<br>
make new textarea filed add this id to the textarea<br>

```css
    tinymce
```

then add this code at the bottom of the page

```php
    @section('script')
        @include('admin.layout.helpers.tynic')
    @endsection
```

<!-- Use_Rich_texT -->


<!-- AbstractController -->
# AbstractController
All controller will extends this controller <br>
this controller has this functions to make it easy to add edit update show and delete items form database<br>
this controller will extends the laravel base controller so do not worry about that

```php
GetAll($view , $with = [] , $paginate = 30) //get all data
createOrEdit($view , $id = null) ///show the view of update of view of create
storeOrUpdate($array , $id = null , $callback = true)//save new date to data base or update
deleteItem($id)///delete item by id
```
<!-- AbstractController -->


<!-- Transformers -->
# Transformers
We have Abstract transformers we must extend this class and<br>
use method transform to transform data
<!-- Transformers -->


<!-- DataTable -->
# DataTable
DataTable integrate with this system so when you go to any module you can find we show data <br>
with data table<br>
you will find the date table class on this path Application\DataTable depend on model name<br>
you can customize the fields by edit this function <br>
 ```php
getColumns()
 ```
 in this case you must delete or add fields
<!-- DataTable -->

<!-- model -->
# Model

you must add three things in all model<br>
1-the fillable array<br>
2-the table name<br>
3-the validation array<br>

<!-- model -->

<!-- Views -->
# Views

each model you create you will find view folder on<br>
Application\Views\admin<br>
you will have edit view index view and show view<br>
and in button folder you will have the edit and delete button<br>

<!-- Views -->

<!-- InterFaces -->
# InterFaces

you must use interface to make your logic <br>
and make your controller more clear<br>
you will find interface in Application\Repository\Interfaces<br>
you must bind all interfaces and their eloquent file in the app\Providers\InterFaceBind.php<br>

```php
   $this->app->bind(
            'App\Application\Repository\InterFaces\UserInterface',
            'App\Application\Repository\Eloquent\UserEloquent'
   );
```

<!-- InterFaces -->





