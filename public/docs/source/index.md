---
title: LaraFlat



includes:


search: true

toc_footers:
- <a href='http://github.com/mpociot/documentarian'>LaralFalt made by love with  By 5damt-web</a>
---
<!-- install -->
# Download The Files 

download all files


# Requirements

PHP >= 5.6.4 , 
PHP Curl extension 


# Install  The Dependencies

now type this line on your console

```
composer install
```
```
php artisan key:generate
```

# Migrate

```
  php artisan migrate
```

# Seed Database 

```
  php artisan db:seed
```

# Start Server


```
  php artisan serve
```

# Login

```
  email : admin@gmail.com
  pass : admin
```

# Go To Admin Path

```
  http://127.0.0.1:8000/admin/home
```
<!-- install -->

<!-- generate new module -->
# Generate New Admin Module

```
  php artisan make:admin_model Nameofmodel
```

this command will genrate the following files

<ol>
    <li>app/Application/Model/Nameofmodel.php</li>
    <li>app/Application/Datatables/NameofmodelDatatable.php</li>
    <li>app/Application/Controllers/NameofmodelControllers.php</li>
    <li>app/Application/views/admin/nameofmodel</li>
    <li>app/Application/routes/admin/admin.php</li>
    <li>Insert item in admin menu</li>
    <li>database/migrations/Nameofmodel</li>
    <li>recources/lang/ar/nameofmodel</li>
</ol>
<!-- generate new module -->

<!-- model -->
# Model
```app/Application/Model/Nameofmodel.php```
    
this will be the model of the module
it will contain the following
    
## Table name make sure this is the table name    
```
  public $table = "Nameofmodel";
```

## Fillable column make sure you add all column on your table
```
    protected $fillable = [
           'name'
    ]; 
```    

## Validation method on store action make sure to add your only validation store action here
```     
    public function validation($id){
            return [
                'name.*' => 'required|max:90'
            ];
       }
```

## Validation method on update action make sure to add only your update  validation here in this method
```
   public function updateValidation($id){
        return [
            'name.*' => 'required|max:90'
        ];
   }
```   

<!-- model -->

<!-- Datatable -->
# Datatable
```app/Application/Datatables/NameofmodelDatatable.php```
 
## this is class to handel datatable .... every table in laraflat have his own class on this path so you must <br>
configure this class to show your data <br>
 
    this method will handel the add,view,update action 
     ```php
        public function ajax()
             {
                 return $this->datatables
                      ->eloquent($this->query())
                      ->addColumn('edit', 'admin.nameofmodel.buttons.edit')
                      ->addColumn('delete', 'admin.nameofmodel.buttons.delete')
                      ->addColumn('view', 'admin.nameofmodel.buttons.view')
                     ->addColumn('name', 'admin.nameofmodel.buttons.langcol')
                      ->make(true);
             }
     ```
 you can add or delete or  customize any of this feilds <br>
 
## this method you can show or delete the tds from the table 
 
     ```php
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
    ```
you can see more about this from datatable <a href="https://yajrabox.com/docs/laravel-datatables/master">documentation</a> 

<!-- Datatable --> 


<!-- controller -->
# Controller
```app/Application/Controllers/NameofmodelControllers.php```

all controller extends this class AbstractController this where the magic happen <br>
this class have all logic to get store update add methods on Laraflat <br>

## constructor function 

```
  public function __construct(Nameofmodel $model)
    {
        parent::__construct($model);
    }
```

here we add the model that we add ,  edit , update , store , delete Don not worry laralflat  write this to you <br>
to make ot easy to make this action

## index Method 

here we  build the datatable and render it do not worry about this all this work don by laraflat
```
 public function index(NameofmodelDataTable $dataTable){
        return $dataTable->render('admin.nameofmodel.index');
    }
```
    
## show Method 
this function call when you show add , edit
```
         public function show($id = null){
                return $this->createOrEdit('admin.nameofmodel.edit' , $id);
            }
```
you can pass any data to view as array as third arg in ```createOrEdit```


## Store Method

this method will call on store , update action
```
  public function store($id = null , \Illuminate\Http\Request $request){
         return $this->storeOrUpdate($request , $id , 'admin/nameofmodel');
    }
```
you can here customize your request and can check if request store by  ``` if($id == null)```

## GetById Method

this method control the view action in datatable 
```
   public function getById($id){
        $fields = $this->model->getConnection()->getSchemaBuilder()->getColumnListing($this->model->getTable());
        return $this->createOrEdit('admin.nameofmodel.show' , $id , ['fields' =>  $fields]);
    }
```
this Method get all table column and send it with the item to the view to show details

## Destroy Method

this methods call when you try to delete the item 
```
 public function destroy($id){
        return $this->deleteItem($id , 'admin/categorie')->with('sucess' , 'Done Delete categorie From system');
    }
```
<!-- controller -->


<!-- views -->
# Views
```app/Application/views/admin/nameofmodel```

we generate by default 7 view 3 the index , edit , show this is the common fiels <br>
the other 4 controll the btns in datatable 

<!-- views -->

<!-- routes -->
# Routes
```app/Application/routes/admin/admin.php```

laraflat append all routes for you when you excute the command ``` php artisan make:admin_model ``` <br>
laraflat append all reoutes that make this actions  ```add , edit , delete , store , update , view ```<br>
int this Path ``` app/Application/routes/admin/admin.php ```
this path the admin group only will have access on it
<!-- routes -->

<!-- menue -->
# Menu
```Insert item in admin menu```
laraflat insert item  for you when you excute the command ``` php artisan make:admin_model ``` <br>
so it will appear in admin menu 

<!-- menue -->

<!-- migration -->
# Migration
```database/migrations/Nameofmodel```
laraflat cearet migration file for you when excute the command ``` php artisan make:admin_model ``` <br>
<!-- migration -->

<!-- Lang Files -->
# Lang Files
```recources/lang/ar/nameofmodel```
laraflat cearet language files for you when excute the command ``` php artisan make:admin_model ``` <br>
it will check available language in ``` config\laravellocalization.php ```  and will generate language files for you
<!-- Lang Files -->


<!-- tinymce -->
#  Tinymce
```how to use tinymce on any texteara```

just put this id on any texteara ``` tinymce ```<br>
then at the end of the page put this code

```
 @section('script')
        @include('admin.layout.helpers.tynic')
 @endsection
```    
<!-- tinymce -->


<!-- translate filed -->
# Translade Fileds
```add filed accept mluti language```

laraflat loko to this file ``` config\laravellocalization.php ``` <br>
to check the  available language to use then you can un commnet any language form this file <br>
now use this function to create your fileds laraflat will generate fields for each language

```
 {!! extractFiled('name' , isset($item->name) ? $item->name : null , 'text' , 'categorie') !!}
```  
  <ul>
    <li>name => feild name</li>
    <li>isset($item->name) ? $item->name : null => check if this is store action or edit action </li>
    <li>text => type of feild</li>
    <li>categorie => translate file must have key name of feild</li>
  </ul>
<!-- translate filed -->

<!-- get value from multi language col -->
#  Show By Lang
```get value deppend on user language```

you can use this two function  ``` getDefaultValueKey($filed) ```<br>
this function will decet the user lang and show him value depend on this lang or use this <br>
``` getLangValue($filed , 'ar')``` this function you must pass the language you want to show <br>

<!-- get value from multi language col -->

<!-- save arrays-->
# save arrays
if you want to save arrays in database just make the filed name as array like the example
```
  <input type="text" name="title[]" />
```
laralflat will decet the array filed and contvert it as json 
<!-- save arrays-->

<!-- upload image-->
# upload image
laralflat fo this file ```app\Application\Helpers\uploadFiles.php```<br>
check this ```getFileFieldsName()``` if the file name in this array laralflat will upload this image<br>
```
  <input type="file" name="image" />
```
if you want to upload multi image just add array to name and laraflat will take care about this
```
  <input type="file" name="image[]" />
```
<!-- save arrays-->


<!-- trans words -->
# Trans Words
``` adminTrans('filename' , 'word')```
<!-- trans words -->

<!-- add lang to url-->
# Append lang to url
``` concatenateLangToUrl('admin/cat/item/1')```
<!-- trans words -->

<!-- get Av lan-->
# Get Languge
get all available language
``` getAvLang()```
<!-- get Av lan -->

<!-- transform select -->
# transform array
some times you will have array with multi language value so you want to get just the current language<br>
in this case use this function ```transformSelect()``` <br>
it will return with array this value will be from the current user language
<!-- transform select -->

<!-- Get Setting  -->
 # Get Setting
 laraflat have setting table so if you want to get setting just call this function ```getSetting('siteTitle')```
 <!-- Get Setting  -->


 <!-- menus -->
 # Menu
laraflat support menu system so if you want to show your menu use this function 
```menu('menuName')```
this will build ul with li with menu itmes 
 <!-- menus  -->








