<?php

namespace App\Application\Controllers\Admin\Themes;

use App\Application\Controllers\AbstractController;
use App\Application\Model\User;
use Alert;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ThemeController extends AbstractController
{

    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    public function adminPanel($theme){
        $files = $this->getFiles($theme);
        if($files){
            return view('admin.theme.control.index' , compact('files' , 'theme'));
        }
        alert()->error(trans('admin.We did not find files in this path yet') , trans('admin.Error'));
        return redirect()->back()->withInput();
    }

    protected function getFiles($theme){
        if($theme == 'admin'){
            return $this->adminFiles();
        }elseif($theme == 'website'){
            return $this->websiteFiles();
        }elseif($theme == 'homepage'){
           return $this->getHomepageWidget();
        }elseif($theme == 'sidebar'){
            return $this->getSideBarWidget();
        }
    }
    protected function getHomepageWidget(){
        return loadWidget(app_path('Application/views/website/homepage') , '');
    }

    protected function getSideBarWidget(){
        return loadWidget(app_path('Application/views/website/sidebar') , '');
    }

    public function openFile(Request $request){
        $file = $this->readFile($this->getPath($request->file , $request->type));
        if($file instanceof RedirectResponse){
            return $file;
        }
        $fileName = $request->file;
        $files = $this->getFiles($request->type);
        $theme = $request->type;
        return view('admin.theme.control.view-file' , compact('file' , 'fileName' , 'files' , 'theme'));

    }

    protected function adminFiles(){
        return [
            'menu',
            'breadcrumb',
            'form',
            'header',
            'messages',
            'notification',
            'table',
            'app'
        ];
    }

    protected function websiteFiles(){
        return [
            'menu',
            'app',
            'messages',
            'paginate',
            'footer',
            'side-bar',
            'before-footer',
            'after-menu'
        ];
    }

    protected function getPath($file , $type = 'admin'){
        if($file != ''){
            if($type == 'admin' || $type == 'website'){
                return app_path('Application/views/'.str_replace('.' ,DIRECTORY_SEPARATOR , layoutPath('layout'.DIRECTORY_SEPARATOR.$file , $type)).'.blade.php');
            }else{
                return app_path('Application/views/website/'.$type.'/'.$file.'.blade.php' , $type);
            }
        }
        return false;
    }

    protected function readFile($path)
    {
        if (file_exists($path)) {
            try {
                $content = File::get($path);
               return $content;
            } catch (Illuminate\Filesystem\FileNotFoundException $exception) {
                alert()->error(trans('admin.Error'));
                return redirect()->back()->withInput();
            }
        }
        alert()->error(trans('admin.Error'));
        return redirect('admin/home');
    }

    public function save(Request $request)
    {
        $path = $this->getPath($request->file , $request->type);
        if (file_exists($path)) {
            $bytes_written = File::put($path, $request->input('content'));
            if ($bytes_written === false) {
                alert()->error(trans('admin.Error'));
                return redirect()->back()->withInput();
            }
        }
        alert()->success(trans('admin.Done'));
        return redirect()->back()->withInput();
    }

}
