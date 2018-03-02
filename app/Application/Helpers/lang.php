<?php

function adminTrans($file , $word)
{
      return trans($file.'.'.$word);
}

function encodeJson($value)
{
      return json_encode($value , JSON_UNESCAPED_UNICODE);
}

function getCurrentLang()
{
      return \Mcamara\LaravelLocalization\Facades\LaravelLocalization::getCurrentLocale();
}

function concatenateLangToUrl($url)
{
      return url(getCurrentLang().'/'.ltrim($url , '\\'));
}

function getAvLang()
{
      return \Mcamara\LaravelLocalization\Facades\LaravelLocalization::getSupportedLocales();
}

function extractFiled($item = null , $name = 'name', $value = null, $type = 'text', $transeFile = null, $class = '',  $rows = 8)
{
      $lang  = getAvLang();
      if($type == 'text')
      {
            return extractTextFiled($item , $lang, $name, $class, $value, $transeFile);
      } elseif($type == 'textarea') {
            return extractTexArea($item , $lang, $name, $rows, $class, $value, $transeFile);
      }
}

function getLangValue($value, $key)
{
    if($value != '' && $value != null){
        return isset(json_decode($value)->$key) ? json_decode($value)->$key : null;
    }
    return null;
}

function getDefaultValueKey($value)
{
    if($value != '' && $value != null){
        $deflan = getCurrentLang();
        return isset(json_decode($value)->$deflan) ? json_decode($value)->$deflan  : null;
    }
    return null;
}

function extractTextFiled ($item = null , $lang, $name,  $class = '', $value, $transeFile = null)
{

      $title  = $transeFile != null ? adminTrans($transeFile , $name)  : $name;
      $out = '<ul class="nav nav-tabs tab-nav-right" role="tablist">';
      $i = 0;
      foreach ($lang as $l)
      {
            $active = $i == 0 ? 'active' : '';
            $out .= ' <li role="presentation" class="nav-item '.$active.'" ><a href="#'
                  . $name 
                  . $l['regional']
                  . '" data-toggle="tab" aria-expanded="false" class="nav-link '.$active.'">'
                  . $title
                  . ' '
                  . $l['native']
                  . '</a></li>';
            $i++;
      }
      $i = 0;
      $out .= '</ul><div class="tab-content">';
      foreach($lang as $key => $ln)
      {
          $value = $item != null && $item->{$name.'_'.$key} ? $item->{$name.'_'.$key}  : '';
            $active = $i == 0 ? 'active' : '';
            $out .= '<div role="tabpanel" class="tab-pane fade '
                 . $active
                  . ' in" id="'
                  . $name 
                  . $ln['regional']
                  . '">';
            $out .= '<div class="form-group">';
            $out .= '<div class="form-line">';
            $out .= '<input type="text" data-key="'
                 . $key
                  . '" name="'
                  . $name
                  . '[' 
                  . $key 
                  . ']" placeholder="'
                  . $title
                  . ' '
                  . $ln['native']
                  . '" id="'
                  . $name
                  . '_'
                  . $key
                  . '" class="form-control '
                  . $class 
                  . '" value="'
//                  . checkValueBeforeSet($value, $key)
                .$value
                  . '" />';
            $out .= '</div>';
            $out .= '</div></div>';
            $i++;
      }
      $out .='</div>';
      return $out;
}

function checkValueBeforeSet($value , $key){
    if($value != null && $value != '' && is_string($value)){
      return  getLangValue($value, $key);
    } elseif(is_array($value)){
        return $value[$key];
    }else{
        return $value;
    }
}

function extractTexArea($item = null , $lang, $name, $rows=8, $class = '', $value,  $transeFile = null)
{
      $title  = $transeFile != null ? adminTrans($transeFile , $name)  : $name;
      $out = '<ul class="nav nav-tabs tab-nav-right" role="tablist">';
      $i = 0;
      foreach ($lang as $l)
      {
            $active = $i == 0 ? 'active' : '';
            $out .= ' <li role="presentation" class="nav-item '.$active.'"><a href="#'
                  . $name
                  . $l['regional']
                  . '" data-toggle="tab" aria-expanded="false" class="nav-link '.$active.'">'
                  . $title
                  . ' '
                  . $l['native']
                  . '</a></li>';
            $i++;
      }
      $i = 0;
      $out .= '</ul><div class="tab-content">';
      foreach($lang as $key => $ln)
      {
          $value = $item != null && $item->{$name.'_'.$key} ? $item->{$name.'_'.$key}  : '';
            $active = $i == 0 ? 'active' : '';
            $out .= '<div role="tabpanel" class="tab-pane fade '
                 . $active
                  . ' in" id="'
                  . $name
                  . $ln['regional']
                  . '">';
            $out .= '<div class="form-group">';
            $out .= '<div class="form-line">';
            $out .= '<textarea  name="'
                 . $name
                 . '['
                 . $key
                 . ']" data-key="'
                 . $key
                 . '" placeholder="'
                 . $title
                 . ' '
                 . $ln['native']
                 . '"  id="'
                 . $name
                 . '_'
                 . $key
                 . '" rows="'
                 . $rows
                 . '" class="form-control '
                 . $class
                 . '">'
//                . checkValueBeforeSet($value, $key)
                 .$value
                 . '</textarea>';
            $out .= '</div>';
            $out .= ' </div></div>';
            $i++;
      }
      $out .='</div>';
      return $out;
}

function transformArray($array)
{
      $newArray = [];
      foreach($array as $key => $ar)
      {
            if(is_array($ar))
            {
                  $newArray[$key] = json_encode($ar, JSON_UNESCAPED_UNICODE);
            } else {
                  $newArray[$key] = $ar;
            }
      }
      return $newArray;
}

function transformSelect($array)
{
      $newArray = [];
      if(count($array) > 0)
      {
            foreach($array as $key => $value)
            {
                  $newArray[$key] = getDefaultValueKey($value);
            }
      }
      return $newArray;
}

function getDir()
{
      return \Mcamara\LaravelLocalization\Facades\LaravelLocalization::getCurrentLocaleDirection();
}

function getDirection()
{
      $cD = getDir();
      return $cD == 'rtl' ? 'right' : 'left';
}

function getReverseDirection()
{
      $cD = getDir();
      return $cD == 'rtl' ? 'left' : 'right';
}

function lang($filed , $lang = null){
      $lang  = $lang != null ? $lang : getCurrentLang();
      return $filed.'_'.$lang;
}