<?php

namespace App\Application\Controllers\Admin\Themes;

use App\Application\Controllers\AbstractController;
use App\Application\Model\User;
use Alert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ThemeController extends AbstractController
{

    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    public function adminPanel($theme){
        $files = $theme == 'admin' ? $this->adminFiles() : $this->websiteFiles();
        return view('admin.theme.control.index' , compact('files' , 'theme'));
    }

    public function openFile(Request $request){
        $file = $this->readFile($this->getPath($request->file , $request->type));
        $fileName = $request->file;
        $files = $request->type == 'admin' ? $this->adminFiles() : $this->websiteFiles();
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
       return app_path('Application/views/'.str_replace('.' ,DIRECTORY_SEPARATOR , layoutPath('layout'.DIRECTORY_SEPARATOR.$file , $type)).'.blade.php');
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
        return redirect()->back()->withInput();
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
