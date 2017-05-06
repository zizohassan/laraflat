<?php
function adminTrans($file , $word){
      return trans($file.'.'.$word);
}

function encodeJson($value){
      return json_encode($value , JSON_UNESCAPED_UNICODE);
}

function getCurrentLang(){
      return \Mcamara\LaravelLocalization\Facades\LaravelLocalization::getCurrentLocale();
}

function concatenateLangToUrl($url){
      return url(getCurrentLang().'/'.$url);
}

function getAvLang(){
      return \Mcamara\LaravelLocalization\Facades\LaravelLocalization::getSupportedLocales();
}

function extractFiled( $name = 'name' , $value = null , $type = 'text'   ,$class = '',  $rows = 8){
      $lang  = getAvLang();
      if($type == 'text'){
            return extractTextFiled($lang , $name , $class , $value );
      }elseif($type == 'textarea'){
            return extractTexArea($lang , $name , $rows , $class , $value);
      }
}

function getLangValue($value  , $key  ){
      return isset(json_decode($value)->$key) ? json_decode($value)->$key : null;
}
function getDefaultValueKey($value){
      $deflan = getCurrentLang();
      return isset(json_decode($value)->$deflan) ? json_decode($value)->$deflan  : null;
}

function extractTextFiled ($lang , $name ,  $class = '' , $value){
      $out = '';
      foreach($lang as $key => $ln){
            $out .= '<br>
            <div class="form-group">
                <div class="form-line">
                    <label for="name">'.$name.' '.$ln['native'].'</label>
                    <input type="text" data-key="'.$key.'" name="'.$name.'['.$key.']" placeholder="'.$name.' '.$ln['native'].'" id="'.$name.'_'.$key.'" class="form-control '. $class .'" value="'.getLangValue($value , $key).'" />
                </div>
            </div>';
      }
      return $out;
}

function extractTexArea($lang , $name , $rows=8 , $class = '' , $value){
      $out = '';
      foreach($lang as $key => $ln){
            $out .= '<br>
            <div class="form-group">
                <div class="form-line">
                <label for="name">'.$name.' '.$ln['native'].'</label>
                    <textarea  name="'.$name.'['.$key.']" data-key="'.$key.'" placeholder="'.$name.' '.$ln['native'].'"  id="'.$name.'_'.$key.'" rows="'.$rows.'" class="form-control '.$class.'">'.getLangValue($value , $key).'</textarea>
                </div>
            </div>';
      }
      return $out;
}

function transformArray($array){
      $newArray = [];
      foreach($array as $key => $ar){
            if(is_array($ar)){
                  $newArray[$key] = json_encode($ar , JSON_UNESCAPED_UNICODE);
            }else{
                  $newArray[$key] = $ar;
            }
      }
      return $newArray;
}