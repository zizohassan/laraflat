<?php

namespace App\Application\Controllers\Admin\Development;

use App\Application\Controllers\AbstractController;
use Alert;
use App\Application\Model\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class CustomPermissionsController extends AbstractController
{
    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    public function index(){
        return view('admin.development.custom-permissions.index');
    }

    public function readFile($file){
        $path = app_path('Http/Middleware/CustomPermissions/'.$file);
        if (file_exists($path)) {
            try {
                $content = File::getRequire($path);
                return view('admin.development.custom-permissions.edit', compact('content', 'file'));
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
        $path = app_path('Http/Middleware/CustomPermissions/'.$request->file);
        if (file_exists($path)) {
            $out = '<?php' . "\n";
            $out .= "\t" . 'return [' . "\n";
            if($request->namespace){
                foreach ($request->namespace as $index => $value) {
                    $out .= "\t\t\t"."'". $value . "'," . "\n";
                }
            }
            $out .= "\t" . '];' . "\n";
            $bytes_written = File::put($path, $out);
            if ($bytes_written === false) {
                alert()->error(trans('admin.Error'));
                return redirect()->back()->withInput();
            }
        }
        alert()->success(trans('admin.Done'));
        return redirect()->back()->withInput();
    }
}
