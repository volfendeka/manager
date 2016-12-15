<?php
namespace contact\helpers;

if(!defined("PROJECT_ACCESS"))exit("ACCESS DENIED");

class InputClear{

    public function clear($data)
    {
        $data = trim($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    public function clearPost($data){
        if(is_array($data)){
            foreach ($data as $key => $value){
                if(is_array($data[$key])){
                    return;
                }
                $cleanData[$key] = $this->clear($value);
            }
            $data = isset($cleanData)?$cleanData:"";
            return $data;
        }else {
            $data = $this->clear($data);
            return $data;
        }
    }
    public function clearGet($data){
        $data = $this->clear($data);
        $data = trim($data, "/");
        return $data;
    }

}