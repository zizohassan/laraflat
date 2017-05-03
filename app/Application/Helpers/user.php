<?php
function getClientIps(){
   return \Request::ip();
}

function extractUserInfo($id){
    $info = geoip(getClientIps());
   return  $data = [
       'user_id' => $id,
        'ip' => $info->ip,
        'iso_code' => $info->iso_code,
        'country' => $info->country,
        'city' => $info->city,
        'state' => $info->state,
        'state_name' => $info->state_name,
        'postal_code' => $info->postal_code,
        'lat' => $info->lat,
        'lon' => $info->lon,
        'timezone' => $info->timezone,
        'continent' => $info->continent,
        'currency' => $info->currency,
    ];
}