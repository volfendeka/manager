<?php
namespace contact\controllers;

use contact\core\Controller;
use contact\core\View;
use contact\helpers\Session;
use contact\models\UsersModel;
use contact\helpers\HeaderButtons;

if(!defined("PROJECT_ACCESS"))exit("ACCESS DENIED");


class UsersController extends Controller{
    
    function __construct()
    {
        parent::__construct();
        $this->view = new View();
        $this->header = new HeaderButtons();
        $this->view->header_buttons = $this->header->echoHeader("authorize");
        $this->model = new UsersModel();
    }

    public function toLogin(){
        $response = $this->model->runLogin();
        $this->view->error = $response;
        if ($response) {
            $this->view->render("login");
        } else {
            header("location:" . URL . "Contacts/showContacts/" . SORTING_PARAM_LAST . "/" . SORTING_PARAM_FIRST . "/1/");
        }
        $this->view->render("login");
    }

    public function toRegister(){
        if(isset($_POST['Register'])){
            $response = $this->model->runRegister();
            $this->view->error = $response;
            if($response){
                $this->view->render("register");
            }else{
                header("location:".URL."Users/toLogin/");
            }
        }
        $this->view->render("register");
    }

    public function toLogout(){
        Session::destroy();
        header("location:".URL."Users/toLogin/");
    }
    
    public function authorizationStatus(){
        if($_POST['action'] == "login"){
            $error_status = $this->model->runLogin();
        }elseif ($_POST['action'] == "register"){
            $error_status = $this->model->runRegister();
        }else{
            $error_status = "";
        }
        echo json_encode($error_status);
    }
}

?>
