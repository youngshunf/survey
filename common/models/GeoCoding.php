<?php
namespace common\models;

class GeoCoding{
    public $ak;
    public function __construct($ak){
        $this->ak=$ak;
    }
    
    public function getLngLatFromAddress($address){
        $url="http://api.map.baidu.com/geocoder/v2/?address=$address&output=json&ak=".$this->ak;
        $res=$this->https_request($url);
        return json_decode($res,true);
    }
    
    
    public function https_request($url,$data = null){
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
        if (!empty($data)){
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        }
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($curl);
        curl_close($curl);
        return $output;
    }
}