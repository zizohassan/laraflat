<?php

namespace App\Application\Controllers\Admin;

use App\Application\Controllers\AbstractController;
use App\Application\Model\Categorie;
use Alert;
use App\Application\Model\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;


class TranslationController extends AbstractController
{
    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    public function index()
    {
        $files = $this->getFiles();
        return view('admin.translation.index', compact('files'));
    }

    public function getFiles()
    {
        return $files = File::allFiles(resource_path('lang/'.getCurrentLang()));
    }

    public function readFile($path)
    {
        $path = explode('_', $path);
        $file = $path[1];
        $lang = $path[0];
        $path = resource_path('lang/' . $lang . '/' . $file);
        if (file_exists($path)) {
            try {
                $content = File::getRequire($path);
                return view('admin.translation.edit', compact('content', 'file', 'lang'));
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
        $path = resource_path('lang/' . $request->lang . '/' . $request->file);
        if (file_exists($path)) {
            $out = '<?php' . "\n";
            $out .= "\t" . 'return [' . "\n";
            foreach ($request->key as $index => $value) {
                $out .= "\t\t" . "'" . $value . "'=>'" . $request->value[$index] . "'," . "\n";
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

    public function getAllContent($file)
    {
        $filesArray = [];
        $keys = [];
        $lang = [];
        foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties) {
            $path = resource_path('lang/' . $localeCode . '/' . $file);
            if (file_exists($path)) {
                $content = File::getRequire($path);
                $filesArray[$localeCode] = $content;
                $lang[] = $localeCode;
                $keys = array_keys($content);
            }
        }
        return view('admin.translation.both', compact('filesArray', 'file', 'keys', 'lang'));
    }

    public function bothSave(Request $request)
    {
        foreach ($request->value as $key => $value) {
            $path = resource_path('lang/'.$key.'/'.$request->file);
             if(file_exists($path)){
                 $out = '<?php' . "\n";
                 $out .= "\t" . 'return [' . "\n";
                 foreach ($value as $k => $v) {
                     $k = !is_int($k) ? $k : $request->key[$k];
                     $out .= "\t\t" . "'" . $k . "'=>'" . $v . "'," . "\n";
                 }
                 $out .= "\t" . '];' . "\n";
                 $bytes_written = File::put($path, $out);
             }
        }
        if ($bytes_written === false) {
            alert()->error(trans('admin.Error'));
            return redirect()->back()->withInput();
        }
        alert()->success(trans('admin.Done'));
        return redirect()->back()->withInput();
    }


}
