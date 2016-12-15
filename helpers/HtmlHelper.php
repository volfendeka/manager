<?php

namespace contact\helpers;


class HtmlHelper
{

    public static function beginForm($action='', $method="post", $className=''){
        $begin = "<div class='$className'><form action='$action' method='$method'>";
        return $begin;
    }

    public static function contentForm($paramsArray, $error="", $data="", $className=""){
        $inputErea = "";
        $contentStart = "<div class='$className'>";
        foreach ($paramsArray as $fieldName => $fieldValue){
            $nameLable = "<label>".$fieldName."</label>";

            if(is_array($fieldValue)){
                $type = $fieldValue[1];
                $name = $fieldValue[2];
                $value = $fieldValue[3];
                $checked = isset($fieldValue[4])?$fieldValue[4]:"";
                $fieldValue = $fieldValue[0];
                $otherinputField = "<input type='$type' name='$name' value='$value' $checked>";
            }else{
                $otherinputField = "";
            }

            $value = isset($_POST[$fieldValue])?$_POST[$fieldValue]:"";
            $errorMasseg = isset($error[$fieldValue])?$error[$fieldValue]:"";

            if (!empty($data)){
                if(isset($_POST[$fieldValue])){
                    $value =$_POST[$fieldValue];
                }else{
                    $value = $data[$fieldValue];
                }
            }


            $errorLable = "<span>".$errorMasseg."</span>";

            $inputField = "<input type='text' name='$fieldValue' value='$value' placeholder=''>";

            $inputErea .= "<br>".$nameLable." ".$otherinputField." ".$inputField." ".$errorLable;
        }

        $contentEnd = "</div>";
        $content = $contentStart.$inputErea.$contentEnd;
        return $content;
    }

    public static function endForm($submit){
        $submitInput = "<br><input type='submit' class='$submit' name='$submit' value='$submit' >";
        if ($submit == ""){
            $submitInput = "";
        }
        $end = $submitInput."</form></div>";
        return $end;
    }

    public static function img($src, $options=array()){
        if(!isset($options['alt'])){
            $options['alt'] = '';
        }
        $alt = $options['alt'];
        $start_tag = "<img src='$src' alt='$alt'";

        foreach ($options as $key => $value){
            $options_string = "";
            $options_string .= $key."='".$value."'";
        }
        
        $img = $start_tag.$options_string.">";
        return $img;
    }

}