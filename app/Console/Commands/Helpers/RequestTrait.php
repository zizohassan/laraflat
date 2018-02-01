<?php

namespace App\Console\Commands\Helpers;

use Symfony\Component\Console\Input\InputArgument;
use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Facades\File;

trait RequestTrait
{

    protected function reFormatRequest()
    {
        if ($this->colsValidation) {
            $result = '';
            $images = [];

            foreach ($this->colsValidation as $key => $cols) {
                if (in_array($key, getImageFields())) {
                    $cols = str_replace(['|nullable', '|required'], '', $cols);
                    $getDimensions = explode(':', $cols);
                    if(isset($getDimensions[1])){
                        $images[$getDimensions[1]] = $key;
                    }else{
                        $images[env('SMALL_IAMGE_WIDTH').'X'.env('SMALL_IAMGE_HEIGHT')] = $key;
                    }
                    if (str_contains($key, '[]')) {
                        $key = str_replace('[]', '', $key).'.*';
                    }
                    $result .= '"' . $key . '" => "' . $getDimensions[0] . '",' . "\n\t\t\t";
                } else {
                    if (str_contains($key, '[]')) {
                        $key = str_replace('[]', '', $key).'.*';
                    }
                    $result .= '"' . $key . '" => "' . $cols . '",' . "\n\t\t\t";
                }
            }
            $this->createConfigFile($images);
            return $result;
        }
        return ' ';
    }

    protected function replace(&$stub, $rep, $name)
    {
        $stub = str_replace(
            [$rep],
            $name,
            $stub
        );

        return $this;
    }

    protected function replaceView(&$stub, $rep, $name)
    {
        $stub = str_replace(
            [$rep],
            $name,
            $stub
        );
        return $stub;
    }


    protected function createConfigFile($images)
    {
        $path = base_path('config' . DS . '/' . strtolower($this->getNameInput()) . '.php');
        if (!file_exists($path)) {
            $out = '<?php' . "\n";
            $out .= "\t" . 'return [' . "\n";
            foreach ($images as $Dimensions => $key) {
                if (str_contains($key, '[]')) {
                    $key = str_replace('[]', '', $key);
                }
                $explode = explode('x', str_replace(['x', 'X'], 'x', $Dimensions));
                $width = $explode[0] ?: env('SMALL_IAMGE_WIDTH');
                $height = $explode[1] ?: env('SMALL_IAMGE_HEIGHT');
                $out .= "\t\t" . "'" . $key . "'=>[" . "\n";
                $out .= "\t\t\t" . "'height'=>'" . $height . "'," . "\n";
                $out .= "\t\t\t" . "'width'=>'" . $width . "'," . "\n";
                $out .= "\t\t" . '],' . "\n";
            }
            $out .= "\t" . '];' . "\n";
            $bytes_written = File::put($path, $out);
            if ($bytes_written === false) {

            }
        }
    }


}