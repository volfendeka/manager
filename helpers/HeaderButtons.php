<?php

namespace contact\helpers;


class HeaderButtons
{
    public function __construct()
    {
    }
    public function echoHeader($method_name){
        $home_button =          '<div class="home_button" ><img src = "/public/img/home.png" alt = "" width = "11px" height = "10px" ><a href = "'.URL.'Contacts/showContacts/'.SORTING_PARAM_LAST.'/'.SORTING_PARAM_FIRST.'/1/" > Home</a ></div >';
        $authorization_button = '<div class="authorization_button" ><img src = "/public/img/key.png" alt = "" width = "23px" height = "16px" ><a href = "'. URL.'Users/toLogout/" >Authorization</a ></div >';
        $register_button =      '<div class="register_button" ><img src = "/public/img/users.png" alt = "" width = "16px" height = "16px" ><a href = "'. URL.'Users/toRegister/" > Register</a ></div >';
        $add_button =           '<div class="add_button" ><img src = "/public/img/add_user.png" alt = "" width = "16px" height = "16px" ><a href = "'.URL.'Contacts/addContact//" > Add</a ></div >';
        $logout_button =        '<div class="logout_button" ><img src = "/public/img/key.png" alt = "" width = "23px" height = "16px" ><a href = "'.URL.'Users/toLogout/" >Logout</a ></div >';
        $event_button =         '<div class="action_buttons"><a href="'.URL.'Contacts/createEvent/'.SORTING_PARAM_LAST.'/'.SORTING_PARAM_FIRST.'/1/0/"> Event </a></div>';
        $add_to_list_button =   '<div class="action_buttons"><input type="submit" name="create" value="Add to list"></div>';
        $begin_form =           '<form action="" method="post">';


        switch ($method_name){
            case "authorize":
                return $this->addRowCols(array($home_button,$authorization_button, $register_button), 4);
                break;
            case "contacts":
                return $this->addRowCols(array($home_button,$logout_button,$add_button,$event_button), 3);
                break;
            case "select_emails" :
                return $begin_form. $this->addRowCols(array($home_button, $add_button, $add_to_list_button, $event_button), 3);
                break;
        }
    }

    public function addRowCols($buttons, $amount){
        $amount = "col-sm-".$amount;
        $button_block = "";
        foreach ($buttons as $value){
            $button_block .=  '<div class="'.$amount.'">'.$value.'</div>';
        }
        return $button_block;
    }

}