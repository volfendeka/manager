<?php

namespace contact\core;

if(!defined("PROJECT_ACCESS"))exit("ACCESS DENIED");

class View{

    function __construct()
    {

    }

    public function render($titleView){
        ob_start();
        require_once ("views/header.php");
        $pathViewPerson = "views/contacts/".$titleView.".php";
        $pathViewUser = "views/users/".$titleView.".php";
        if (file_exists($pathViewPerson)) {
            require_once ($pathViewPerson);
        }elseif (file_exists($pathViewUser)){
            require_once ($pathViewUser);
        }
        require_once ("views/footer.php");

        $output = ob_get_contents();
        ob_end_clean();
        $output = $this->sanitize_output($output);
        echo $output;
    }

    function sanitize_output($buffer) {
        $search = array(
            '/\>[^\S ]+/s',  // strip whitespaces after tags, except space
            '/[^\S ]+\</s',  // strip whitespaces before tags, except space
            '/(\s)+/s'       // shorten multiple whitespace sequences
        );
        $replace = array('>', '<', '\\1');
        $buffer = preg_replace($search, $replace, $buffer);
        return $buffer;
    }



}