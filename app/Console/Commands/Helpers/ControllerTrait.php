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
            $out .= "\t\t\t\t\t\t" . '@if((isset($item->'.$keyWithOutBrakets.') && json_decode($item->' . $keyWithOutBrakets . ') ) || old("' . $keyWithOutBrakets . '"))' . "\n";
            $out .= "\t\t\t\t\t\t" . '@php $items = isset($item->'.$keyWithOutBrakets.') && json_decode($item->' . $keyWithOutBrakets . ') ? json_decode($item->' . $keyWithOutBrakets . ')  : old("' . $keyWithOutBrakets . '") @endphp' . "\n";
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
            $out .= "\t\t\t\t\t\t\t\t" . '<div class="col-lg-2 text-center"><img src="{{ small($jsonimage) }}" class="img-responsive" /><br>' . "\n";
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

    protected function renderShow($name)
    {
        $out = '';
        if (count($this->cols) > 0) {
            $tableClass = env('THEME') == 'themeone' ? '' : 'table-responsive';
            $out .= "\t\t" . ' <table class="table table-bordered '.$tableClass.' table-striped" > ' . "\n";
            foreach ($this->cols as $key => $value) {
                $isMultiLang = isset($value[2]) && $value[2] == 'true' ? true : false;
                $k = $key;
                $key = str_contains($key , '[]') ? str_replace('[]' , '' , $key) : $key;
                $out .= "\t\t\t\t" . '<tr>' . "\n\t\t\t\t" . '<th width="200">{{ trans("' . strtolower($this->getNameInput()) . '.' . $key . '") }}</th>' . "\n";
                if ($k == 'youtube') {
                    $out .= "\t\t\t\t" . '@if(isset($item) && $item->' . $key . ' != "")' . "\n";
                    $out .= "\t\t\t\t\t" . '<td>' . "\n";
                    $out .= "\t\t\t\t" . '<iframe width="420" height="315" src="https://www.youtube.com/embed/{{ isset($item->' . $key . ') ? getYouTubeId($item->' . $key . ') : old("' . $key . '")  }}"></iframe>' . "\n";
                    $out .= "\t\t\t\t\t" . '</td>' . "\n";
                    $out .= "\t\t\t\t" . "@endif" . "\n";
                } else if ($value[0] == 'boolean') {
                    $out .= "\t\t\t\t\t" . '<td>' . "\n";
                    $out .= "\t\t\t\t" . '{{ $item->' . $key . ' == 1 ? trans("' . strtolower($this->getNameInput()) . '.Yes") : trans("' . strtolower($this->getNameInput()) . '.No")  }}' . "\n";
                    $out .= "\t\t\t\t\t" . '</td>' . "\n";
                } else if ($k == 'url') {
                    $out .= "\t\t\t\t\t" . '<td>' . "\n";
                    $out .= "\t\t\t\t" . '<a href="{{  $item->' . $key . ' }}"><i class="fa fa-link"></i></a>' . "\n";
                    $out .= "\t\t\t\t\t" . '</td>' . "\n";
                }  else if ($k == 'icon') {
                    $out .= "\t\t\t\t\t" . '<td>' . "\n";
                    $out .= "\t\t\t\t" . '<i class="fa {{ $item->' . $key . '}}"></i>' . "\n";
                    $out .= "\t\t\t\t\t" . '</td>' . "\n";
                }else if(str_contains($k , '[]')){
                    if (in_array($k, getFileFieldsName())) {
                        $out .= "\t\t\t\t\t" . '<td>' . "\n";
                        $out .= "\t\t\t\t\t" . '@isset($item)' . "\n";
                        $out .= "\t\t\t\t\t\t" . '@if(json_decode($item->' . $key . '))' . "\n";
                        $out .= "\t\t\t\t\t\t\t" . '<input type="hidden" name="oldFiles_' . $key . '" value="{{ $item->' . $key . ' }}">' . "\n";
                        $out .= "\t\t\t\t\t\t\t" . '@php $files = returnFilesImages($item , "' . $key . '"); @endphp' . "\n";
                        $out .= "\t\t\t\t\t\t\t" . '<div class="row text-center">' . "\n";
                        $out .= "\t\t\t\t\t\t\t" . '@foreach($files["image"] as $jsonimage )' . "\n";
                        $out .= "\t\t\t\t\t\t\t\t" . '<div class="col-lg-2 text-center"><img src="{{ small($jsonimage) }}" width="100"  /><br>' . "\n";
                        $out .= "\t\t\t\t\t\t\t\t" . '<span class="btn btn-danger" onclick="deleteThisItem(this)" data-link="{{ url("deleteFile/' . strtolower($this->getNameInput()) . '/".$item->id."?name=".$jsonimage."&filed_name=' . $key . '") }}"><i class="fa fa-trash"></i></span></div>' . "\n";
                        $out .= "\t\t\t\t\t\t\t" . '@endforeach' . "\n";
                        $out .= "\t\t\t\t\t\t\t" . '</div>' . "\n";
                        $out .= "\t\t\t\t\t\t\t" . '<div class="row text-center">' . "\n";
                        $out .= "\t\t\t\t\t\t\t" . '@foreach($files["file"] as $jsonimage )' . "\n";
                        $out .= "\t\t\t\t\t\t\t\t" . '<div class="col-lg-2 text-center"><a href="{{ url(env("UPLOAD_PATH")."/".$jsonimage) }}" ><i class="fa fa-file"></i></a>' . "\n";
                        $out .= "\t\t\t\t\t\t\t\t" . '<span  onclick="deleteThisItem(this)" data-link="{{ url("deleteFile/' . strtolower($this->getNameInput()) . '/".$item->id."?name=".$jsonimage."&filed_name=' . $key . '") }}"><i class="fa fa-trash"></i> {{ $jsonimage }} </span></div>' . "\n";
                        $out .= "\t\t\t\t\t\t\t" . '@endforeach' . "\n";
                        $out .= "\t\t\t\t\t" . '</div>' . "\n";
                        $out .= "\t\t\t\t\t\t" . '@endif' . "\n";
                        $out .= "\t\t\t\t\t" . '@endisset' . "\n";
                        $out .= "\t\t\t\t\t" . '</td>' . "\n";
                    }else{
                        $out .= "\t\t\t\t\t". '<td><span class="label label-default">{!! json_decode($item->' . $key . ') ? implode("</span> <br> <span class=';
                        $out .= "'label label-default'";
                        $out .= '>" , json_decode($item->' . $key . ')) : "" !!}</span></td> ' . "\n\t\t\t\t";
                    }
                }else if (!str_contains($k , '[]') && in_array($k , getImageFields()) ) {
                    $out .= "\t\t\t\t\t" . '<td>' . "\n";
                    $out .= "\t\t\t\t\t" . '<img src="{{ small($item->' . $key . ') }}" width="100" />' . "\n";
                    $out .= "\t\t\t\t\t" . '</td>' . "\n";
                }else if (!str_contains($k , '[]') && in_array($k , fileFields()) ) {
                    $out .= "\t\t\t\t\t" . '<td>' . "\n";
                    $out .= "\t\t\t\t\t" . '<a href="{{ url(env("UPLOAD_PATH")."/".$item->' . $key . ') }}">{{ $item->' . $key . ' }}</a>' . "\n";
                    $out .= "\t\t\t\t\t" . '</td>' . "\n";
                }else if ($k == 'lat') {
                    $out .= "\t\t\t\t\t" . '<td>' . "\n";
                    $out .= "\t\t\t\t" . '{{nl2br($item->' . $key . ') }}' . "\n";
                    $out .= "\t\t\t\t\t" . '</td></tr><tr><th>{{ trans("admin.location") }}</th>' . "\n";
                    $out .= "\t\t\t\t\t" . '<td>' . "\n";
                    $out .= "\t\t\t\t" . '<div id="showMap" style="width:100%;height: 500px;" data-lat="{{ $item->lat }}"  data-lng="{{ $item->lng }}"></div>' . "\n";
                    $out .= "\t\t\t\t\t" . '</td>' . "\n";
                } else {
                    if ($isMultiLang) {
                        $out .= "\t\t\t\t\t" . '<td>{{ nl2br($item->' . $key . '_lang) }}</td>' . "\n";
                    } else {
                        $out .= "\t\t\t\t\t" . '<td>{{ nl2br($item->' . $key . ') }}</td>' . "\n";
                    }
                }
                $out .= "\t\t\t\t" . '</tr>' . "\n";
            }
            $out .= "\t\t" . '</table>' . "\n";
        } else {
            $out .= "\t\t" . '<table class="table table-bordered table-responsive table-striped">' . "\n";
            $out .= "\t\t" . '@php' . "\n";
            $out .= "\t\t" . '$fields = rename_keys(' . "\n";
            $out .= "\t\t" . 'removeFromArray($item["fields"] , ["updated_at"]) ,' . "\n";
            $out .= "\t\t" . '["UserName"]' . "\n";
            $out .= "\t\t" . ');' . "\n";
            $out .= "\t\t" . '@endphp' . "\n";
            $out .= "\t\t" . '@foreach($fields as $key =>  $field)' . "\n";
            $out .= "\t\t\t" . '<tr>' . "\n";
            $out .= "\t\t\t\t" . '<th>{{ $key }}</th>' . "\n";
            $out .= "\t\t\t\t" . '@php $type =  getFileType($field , $item[$field]) @endphp' . "\n";
            $out .= "\t\t\t\t" . '@if($type == "File")' . "\n";
            $out .= "\t\t\t\t\t" . '<td> <a href="{{ url(env("UPLOAD_PATH")."/".$item[$field]) }}">{{ $item[$field] }}</a></td>' . "\n";
            $out .= "\t\t\t\t" . '@elseif($type == "Image")' . "\n";
            $out .= "\t\t\t\t\t" . '<td> <img src="{{ small($item[$field]) }}" /></td>' . "\n";
            $out .= "\t\t\t\t" . '@else' . "\n";
            $out .= "\t\t\t\t\t" . ' <td>{!!  nl2br($item[$field])  !!}</td>' . "\n";
            $out .= "\t\t\t\t" . '@endif' . "\n";
            $out .= "\t\t\t" . '</tr>' . "\n";
            $out .= "\t\t" . '@endforeach' . "\n";
            $out .= "\t\t" . '</table>' . "\n";
        }
        return $out;

    }

    protected function renderForm($name)
    {
        $out = ' ';
        if (count($this->cols) > 0) {
            foreach ($this->cols as $key => $value) {
                $isMultiLang = isset($value[2]) && $value[2] == 'true' ? true : false;
                if(!$isMultiLang){
                    $out .= "\t\t" . ' <div class="form-group {{ $errors->has("'.$key.'") ? "has-error" : "" }}" > ' . "\n";
                }else{
                    $out .= "\t\t" . ' <div class="form-group  ';
                    $ilang=1;
                    $condetion = '{{ ';
                    foreach (getAvLang() as $keyLang => $langValue){
                        $condetion .=  ' $errors->has("'.$key.'.'.$keyLang.'") ';
                        $condetion .= ($ilang != count(getAvLang()) ? " && " : '');
                        $ilang++;
                    }
                    $condetion .= ' ? "has-error" : "" }}';
                    $out .= $condetion;
                    $out .= '" >' . "\n";
                }
                $k = str_contains( $key , '[]') ? str_replace('[]' ,'', $key) : $key;
                $out .= "\t\t\t" . '<label for="' . $k . '">{{ trans("' . strtolower($this->getNameInput()) . '.' . $k . '")}}</label>' . "\n";
                if (in_array($key, getFileFieldsName())) {
                    if(str_contains($key , '[]')){
                        $out .= $this->inputAsArray($key , 'file');
                    }else{
                        $out .= "\t\t\t\t" . '@if(isset($item) && $item->' . $key . ' != "")' . "\n";
                        $out .= "\t\t\t\t" . '<br>' . "\n";
                        $out .= "\t\t\t\t" . '<img src="{{ small($item->' . $key . ') }}" class="thumbnail" alt="" width="200">' . "\n";
                        $out .= "\t\t\t\t" . '<br>' . "\n";
                        $out .= "\t\t\t\t" . "@endif" . "\n";
                        $out .= "\t\t\t\t" . '<input type="file" name="' . $key . '" >' . "\n";
                    }
                } elseif ($key == 'youtube') {
                    $out .= "\t\t\t\t" . '@if(isset($item) && $item->' . $key . ' != "")' . "\n";
                    $out .= "\t\t\t\t" . ' <br>' . "\n";
                    $out .= "\t\t\t\t" . ' <iframe width = "420" height = "315" src="https://www.youtube.com/embed/{{ isset($item->' . $key . ') ? getYouTubeId($item->' . $key . ') : old("' . $key . '")  }}" ></iframe > ' . "\n";
                    $out .= "\t\t\t\t" . '<br > ' . "\n";
                    $out .= "\t\t\t\t" . "@endif" . "\n";
                    $out .= "\t\t\t\t" . '<input type="url" name="' . $key . '" class="form-control" id="' . $key . '" value="{{ isset($item->' . $key . ') ? $item->' . $key . ' : old("' . $key . '")  }}"  placeholder="{{ trans("' . strtolower($this->getNameInput()) . '.' . $key . '")}}">' . "\n";
                } elseif ($key == 'icon') {
                    $out .= "\t\t\t\t" . '<input type="text" name="' . $key . '" class="form-control icon-field" id="' . $key . '" value="{{ isset($item->' . $key . ') ? $item->' . $key . ' : old("' . $key . '") }}"  placeholder="{{ trans("' . strtolower($this->getNameInput()) . '.' . $key . '")}}" > ' . "\n";
                } elseif ($key == 'url') {
                    $out .= "\t\t\t\t" . '<input type="url" name="' . $key . '" class="form-control" id="' . $key . '" value="{{ isset($item->' . $key . ') ? $item->' . $key . ' : old("' . $key . '") }}"  placeholder="{{ trans("' . strtolower($this->getNameInput()) . '.' . $key . '")}}" > ' . "\n";
                } elseif ($key == 'date') {
                    $out .= "\t\t\t\t" . ' <input type="text" name="' . $key . '" class="form-control datepicker2" id="' . $key . '" value="{{ isset($item->' . $key . ') ? $item->' . $key . ' : old("' . $key . '") }}"  placeholder="{{ trans("' . strtolower($this->getNameInput()) . '.' . $key . '")}}" > ' . "\n";
                }elseif ($key == 'time') {
                    $out .= "\t\t\t\t" . ' <input type="text" name="' . $key . '" class="form-control time" id="' . $key . '" value="{{ isset($item->' . $key . ') ? $item->' . $key . ' : old("' . $key . '") }}"  placeholder="{{ trans("' . strtolower($this->getNameInput()) . '.' . $key . '")}}" > ' . "\n";
                }elseif ($key == 'lat') {
                    $out .= "\t\t\t\t" . ' <input type="text" name="' . $key . '" class="form-control lat" style="display:none" id="' . $key . '" value="{{ isset($item->' . $key . ') ? $item->' . $key . ' : old("' . $key . '") }}"  placeholder="{{ trans("' . strtolower($this->getNameInput()) . '.' . $key . '")}}" > ' . "\n";
                    $out .= $this->map();
                }elseif ($key == 'lng') {
                    $out .= "\t\t\t\t" . ' <input type="text" name="' . $key . '" class="form-control lng" style="display:none" id="' . $key . '" value="{{ isset($item->' . $key . ') ? $item->' . $key . ' : old("' . $key . '") }}"  placeholder="{{ trans("' . strtolower($this->getNameInput()) . '.' . $key . '")}}" > ' . "\n";
                }elseif (str_contains($key , '[]')) {
                    $out .= $this->inputAsArray($key);
                } else {
                    if ($value[0] == 'string' && $isMultiLang) {
                        $out .= "\t\t\t\t" . '{!! extractFiled(isset($item) ? $item : null , "' . $key . '", isset($item->' . $key . ') ? $item->' . $key . ' : old("' . $key . '") , "text" , "' . strtolower($this->getNameInput()) . '") !!}' . "\n";
                    } elseif ($value[0] == 'email' && $isMultiLang) {
                        $out .= "\t\t\t\t" . '{!! extractFiled(isset($item) ? $item : null , "' . $key . '", isset($item->' . $key . ') ? $item->' . $key . ' : old("' . $key . '") , "email" , "' . strtolower($this->getNameInput()) . '") !!}' . "\n";
                    } elseif ($value[0] == 'date' && $isMultiLang) {
                        $out .= "\t\t\t\t" . '{!! extractFiled(isset($item) ? $item : null , "' . $key . '", isset($item->' . $key . ') ? $item->' . $key . ' : old("' . $key . '") , "date" , "' . strtolower($this->getNameInput()) . '" , "datepicker") !!}' . "\n";
                    } elseif ($value[0] == 'text' && $isMultiLang) {
                        $out .= "\t\t\t\t" . '{!! extractFiled(isset($item) ? $item : null , "' . $key . '", isset($item->' . $key . ') ? $item->' . $key . ' : old("' . $key . '") , "textarea" , "' . strtolower($this->getNameInput()) . '" ) !!}' . "\n";
                    } elseif ($value[0] == 'boolean') {
                        $out .= "\t\t\t\t" . ' <div class="form-check">' . "\n";
                        $out .= "\t\t\t\t\t" . '<label class="form-check-label">' . "\n";
                        $out .= "\t\t\t\t\t" . '<input class="form-check-input" name="' . $key . '" {{ isset($item->' . $key . ') && $item->' . $key . ' == 0 ? "checked" : "" }} type="radio" value="0" > ' . "\n";
                        $out .= "\t\t\t\t\t" . '{{ trans("' . strtolower($this->getNameInput()) . '.No")}}' . "\n";
                        $out .= "\t\t\t\t" . ' </label > ' . "\n";
                        $out .= "\t\t\t\t" . '<label class="form-check-label">' . "\n";
                        $out .= "\t\t\t\t" . '<input class="form-check-input" name="' . $key . '" {{ isset($item->' . $key . ') && $item->' . $key . ' == 1 ? "checked" : "" }} type="radio" value="1" > ' . "\n\t\t\t\t";
                        $out .= "\t\t\t\t\t" . '{{ trans("' . strtolower($this->getNameInput()) . '.Yes")}}' . "\n";
                        $out .= "\t\t\t\t" . ' </label> ' . "\n";
                        $out .= "\t\t\t\t" . '</div> ';
                    } else {
                        if ($value[0] == 'string') {
                            $out .= "\t\t\t\t" . '<input type="text" name="' . $key . '" class="form-control" id="' . $key . '" value="{{ isset($item->' . $key . ') ? $item->' . $key . ' : old("' . $key . '") }}"  placeholder="{{ trans("' . strtolower($this->getNameInput()) . '.' . $key . '")}}">' . "\n";
                        } elseif ($value[0] == 'email') {
                            $out .= "\t\t\t\t" . '<input type="email" name="' . $key . '" class="form-control" id="' . $key . '" value="{{ isset($item->' . $key . ') ? $item->' . $key . ' : old("' . $key . '") }}"  placeholder="{{ trans("' . strtolower($this->getNameInput()) . '.' . $key . '")}}">' . "\n";
                        } elseif ($value[0] == 'youtube') {
                            $out .= "\t\t\t\t" . '<input type="url" name="' . $key . '" class="form-control" id="' . $key . '" value="{{ isset($item->' . $key . ') ? $item->' . $key . ' : old("' . $key . '") }}"  placeholder="{{ trans("' . strtolower($this->getNameInput()) . '.' . $key . '")}}">' . "\n";
                        } elseif ($value[0] == 'date') {
                            $out .= "\t\t\t\t" . '<input type="date" name="' . $key . '" class="form-control datepicker" id="' . $key . '" value="{{ isset($item->' . $key . ') ? $item->' . $key . ' : old("' . $key . '") }}"  placeholder="{{ trans("' . strtolower($this->getNameInput()) . '.' . $key . '")}}">' . "\n";
                        } elseif ($value[0] == 'text') {
                            $out .= "\t\t\t\t" . '<textarea name="' . $key . '" class="form-control" id="' . $key . '"   placeholder="{{ trans("' . strtolower($this->getNameInput()) . '.' . $key . '")}}" >{{isset($item->' . $key . ') ? $item->' . $key . ' : old("' . $key . '") }}</textarea >'."\n";
                        } else {
                            $out .= "\t\t\t\t" . '<input type="text" name="' . $key . '" class="form-control" id="' . $key . '" value="{{ isset($item->' . $key . ') ? $item->' . $key . ' : old("' . $key . '") }}"  placeholder="{{ trans("' . strtolower($this->getNameInput()) . '.' . $key . '")}}">'."\n";
                        }
                    }
                }
                $out .= "\t\t" . '</div>' . "\n";
                if(!$isMultiLang){
                    $out .=  $this->returnErrorLoop($key);
                }else{
                    foreach (getAvLang() as $keyLang => $value){
                        $out .=  $this->returnErrorLoop($key.'.'.$keyLang);
                    }
                }
            }
        }
        return $out;
    }

    protected function returnErrorLoop($key){
        $out = "\t\t\t".'@if ($errors->has("'.$key.'"))'."\n";
        $out .= "\t\t\t\t".'<div class="alert alert-danger">'."\n";
        $out .= "\t\t\t\t\t"."<span class='help-block'>"."\n";
        $out .= "\t\t\t\t\t\t".'<strong>{{ $errors->first("'.$key.'") }}</strong>'."\n";
        $out .= "\t\t\t\t\t"."</span>"."\n";
        $out .= "\t\t\t\t".'</div>'."\n";
        $out .= "\t\t\t"."@endif"."\n";
        return $out;
    }

}