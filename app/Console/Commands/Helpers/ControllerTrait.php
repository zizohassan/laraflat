<?php

namespace App\Console\Commands\Helpers;


trait ControllerTrait
{
    protected function inputAsArray($key, $type = 'text')
    {
        $keyWithOutBrakets = str_replace('[]', '', $key);
        $out = "\t\t\t\t" . '<div id="laraflat-' . $keyWithOutBrakets . '">' . "\n";
        if ($type == 'text') {
            $out .= "\t\t\t\t\t" . '@if(isset($item) || old("' . $keyWithOutBrakets . '"))' . "\n";
            $out .= "\t\t\t\t\t\t" . '@if((isset($item->title) && json_decode($item->' . $keyWithOutBrakets . ') ) || old("' . $keyWithOutBrakets . '"))' . "\n";
            $out .= "\t\t\t\t\t\t" . '@php $items = isset($item->title) && json_decode($item->' . $keyWithOutBrakets . ') ? json_decode($item->' . $keyWithOutBrakets . ')  : old("' . $keyWithOutBrakets . '") @endphp' . "\n";
            $out .= "\t\t\t\t\t\t\t" . '@foreach($items as $json' . $keyWithOutBrakets . ')' . "\n";
            $out .= "\t\t\t\t\t\t\t\t" . '<div class="title form-inline" style="margin-top:5px;margin-bottom:5px"><input class="form-control" name="' . $keyWithOutBrakets . '[]"  value="{{ $json' . $keyWithOutBrakets . '}}" type="text" placeholder="{{ trans("' . strtolower($this->getNameInput()) . '.' . $keyWithOutBrakets . '")}}" ><span class="btn btn-warning" onclick="removetitle(this)"> <i class="fa fa-minus"></i></span></div>' . "\n";
            $out .= "\t\t\t\t\t\t\t" . '@endforeach' . "\n";
            $out .= "\t\t\t\t\t\t" . '@endif' . "\n";
            $out .= "\t\t\t\t\t" . '@endif' . "\n";
            $out .= "\t\t\t\t" . '<span class="btn btn-success" onclick="AddNew' . $keyWithOutBrakets . '()"><i class="fa fa-plus"></i></span>' . "\n";
            $out .= "\t\t\t\t" . '<span class="btn btn-danger" onclick="clearAll' . $keyWithOutBrakets . '(this)"><i class="fa fa-minus"></i></span>' . "\n";
            $out .= "\t\t\t\t" . '@push("js")
                                        <script>
                                            function AddNew' . $keyWithOutBrakets . '() {
                                                $("#laraflat-' . $keyWithOutBrakets . '").append(';
                                                    $out .= "'" . '<div class="' . $keyWithOutBrakets . ' form-inline" style="margin-top:5px;margin-bottom:5px">' . "'+";
                                                    $out .= "'" . '<input class="form-control" name="' . $keyWithOutBrakets . '[]"  type="' . $type . '" placeholder="{{ trans("' . strtolower($this->getNameInput()) . '.' . $keyWithOutBrakets . '")}}" >' . "'+";
                                                    $out .= "'" . '<span class="btn btn-warning" onclick="remove' . $keyWithOutBrakets . '(this)">' . "'+";
                                                    $out .= "'" . ' <i class="fa fa-minus"></i></span>' . "'+";
                                                    $out .= "'" . '</div>' . "'";
                                                    $out .= ');
                                            }
                                            function remove' . $keyWithOutBrakets . '(e) {
                                                $(e).closest("div.' . $keyWithOutBrakets . '").remove();
                                            }
                                            function clearAll' . $keyWithOutBrakets . '(e) {
                                                $("#laraflat-' . $keyWithOutBrakets . '").html("");
                                            }
                                        </script>
            @endpush' . "\n";
        } elseif ($type == 'file') {
            $out .= "\t\t\t\t\t" . '@isset($item)' . "\n";
            $out .= "\t\t\t\t\t\t" . '@if(json_decode($item->' . $keyWithOutBrakets . '))' . "\n";
            $out .= "\t\t\t\t\t\t\t" . '<input type="hidden" name="oldFiles_' . $keyWithOutBrakets . '" value="{{ $item->' . $keyWithOutBrakets . ' }}">' . "\n";
            $out .= "\t\t\t\t\t\t\t" . '@php $files = returnFilesImages($item , "' . $keyWithOutBrakets . '"); @endphp' . "\n";
            $out .= "\t\t\t\t\t\t\t" . '<div class="row text-center">' . "\n";
            $out .= "\t\t\t\t\t\t\t" . '@foreach($files["image"] as $jsonimage )' . "\n";
            $out .= "\t\t\t\t\t\t\t\t" . '<div class="col-lg-2 text-center"><img src="{{ url(env("SMALL_IMAGE_PATH")."/".$jsonimage) }}" class="img-responsive" /><br>' . "\n";
            $out .= "\t\t\t\t\t\t\t\t" . '<a class="btn btn-danger" onclick="deleteThisItem(this)" data-link="{{ url("deleteFile/' . strtolower($this->getNameInput()) . '/".$item->id."?name=".$jsonimage."&filed_name=' . $keyWithOutBrakets . '") }}"><i class="fa fa-trash"></i></a></div>' . "\n";
            $out .= "\t\t\t\t\t\t\t" . '@endforeach' . "\n";
            $out .= "\t\t\t\t\t\t\t" . '</div>' . "\n";
             $out .= "\t\t\t\t\t\t\t" . '<div class="row text-center">' . "\n";
            $out .= "\t\t\t\t\t\t\t" . '@foreach($files["file"] as $jsonimage )' . "\n";
            $out .= "\t\t\t\t\t\t\t\t" . '<div class="col-lg-2 text-center"><a href="{{ url(env("UPLOAD_PATH")."/".$jsonimage) }}" ><i class="fa fa-file"></i></a>' . "\n";
            $out .= "\t\t\t\t\t\t\t\t" . '<span  onclick="deleteThisItem(this)" data-link="{{ url("deleteFile/' . strtolower($this->getNameInput()) . '/".$item->id."?name=".$jsonimage."&filed_name=' . $keyWithOutBrakets . '") }}"><i class="fa fa-trash"></i> {{ $jsonimage }} </span></div>' . "\n";
            $out .= "\t\t\t\t\t\t\t" . '@endforeach' . "\n";
            $out .= "\t\t\t\t\t" . '</div>' . "\n";
            $out .= "\t\t\t\t\t\t" . '@endif' . "\n";
            $out .= "\t\t\t\t\t" . '@endisset' . "\n";
            $out .= "\t\t\t\t\t\t" . '<input name="' . $keyWithOutBrakets . '[]"  type="' . $type . '" multiple >' . "\n";
        }
        $out .= "\t\t\t\t\t" . '</div>' . "\n";


        return $out;
    }



}