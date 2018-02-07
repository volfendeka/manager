<?php

namespace contact\controllers;

use contact\core\Controller;
use contact\core\View;
use contact\helpers\Cookies;
use contact\helpers\HeaderButtons;
use contact\helpers\RandomWriter;
use contact\models\ContactsModel;

if(!defined("PROJECT_ACCESS"))exit("ACCESS DENIED");

class ContactsController extends Controller{

    function __construct()
    {
        parent::__construct();
        if(isset($_SESSION['user_id'])) {
            $this->view = new View();
            $this->header = new HeaderButtons();
            $this->view->header_buttons = $this->header->echoHeader("contacts");
            $this->model = new ContactsModel();
        }else{
            header("location:".URL."Users/toLogin/");
        }
    }

    public function showContacts($sort_last = SORTING_PARAM_LAST , $sort_first = SORTING_PARAM_FIRST, $pagination = 1){
        $this->view->data = $this->model->showContactsModel($sort_last, $sort_first, $pagination);
        $this->view->render("show");
    }
    
    public function addContact(){
        if (isset($_POST['Done'])) {
            if($this->model->addContactModel()){
                $this->view->error = $this->model->addContactModel();
            }else{
                header("location:" . URL . "Contacts/showContacts/" . SORTING_PARAM_LAST . "/" . SORTING_PARAM_FIRST . "/1/");
            }
        }
        $this->view->render("add");
    }

    
    public function viewContact($params){
        $this->view->data = $this->model->viewContactModel($params);
        $this->view->render("view");
    }


    public function editContact($params){
        if(isset($_POST['Done'])) {
            if($this->model->editContactModel($params)){
                $this->view->error = $this->model->editContactModel($params);
            }else {
                header("location:".URL."Contacts/showContacts/".SORTING_PARAM_LAST."/".SORTING_PARAM_FIRST."/1/");
            }
        }
        $this->view->data = $this->model->viewContactModel($params);
        $this->view->render("edit");
    }


    public function deleteContact($params){
        if (isset($_POST['delete'])) {
            $this->model->deleteContactModel($params);
            header("location:".URL."Contacts/showContacts/".SORTING_PARAM_LAST."/".SORTING_PARAM_FIRST."/1/");
        }elseif (isset($_POST['cancel'])){
            header("location:".URL."Contacts/showContacts/".SORTING_PARAM_LAST."/".SORTING_PARAM_FIRST."/1/");
        }
        $this->view->render("delete");
    }


    public function set_cookies_checked(){
        $array_cookies_checked = array();
        if(isset($_COOKIE['send_addresses'])) {
            $array_cookies_checked = unserialize($_COOKIE['send_addresses']);
        }
        $difference = array_diff($array_cookies_checked, $_POST['address']);
        $array_cookies_checked = array_merge($difference, $_POST['address']);
        setcookie("send_addresses", serialize($array_cookies_checked), time()+3600, "/");return $array_cookies_checked;
    }

    public function get_cookies_checked(){
        $array_cookies_checked = array();
        if(isset($_COOKIE['send_addresses'])) {
            $array_cookies_checked = unserialize($_COOKIE['send_addresses']);
        }
       return $array_cookies_checked;
    }

    public function createEvent(){
        $this->view->data['checked_emails'] = isset($_COOKIE['id_to_send']) && ($_COOKIE['id_to_send']!="")?$this->model->getCheckedEmails(explode(",", $_COOKIE['id_to_send'])):array();
        $this->view->render('event');
        Cookies::destroy('new_email');
        Cookies::destroy('id_to_send');
        $result = $this->model->checkIfNewEmailsPrinted();
        if($result != false){
            Cookies::set('new_email', $result);
            header('location:' . URL . 'Contacts/saveNewEmails/no/');
        }
    }

    public function selectEmails($sort_last, $sort_first, $pagination){
        $this->view->data['contacts'] = $this->model->showContactsModel($sort_last, $sort_first, $pagination);
        $this->view->header_buttons = $this->header->echoHeader("select_emails");
        $this->view->render('check');
        if(isset($_POST['create'])){
            header("location:".URL."Contacts/createEvent/");
        }
    }

    public function saveNewEmails($check){
        if(Cookies::get('new_email')){
            $this->view->data = Cookies::get('new_email');
            $this->view->params['checked'] = $this->model->checkAllBoxes($check);
            $this->view->render('saveNewEmail');
            if(isset($_POST['insert_email']) && isset($_POST['add'])) {
                $this->view->data = $this->model->writeNewEmailsModel();
                header("location:" . URL . "Contacts/showContacts/ASC/ASC/1/");
            }
        }else{
            header('location:' . URL . 'Contacts/createEvent/');
        }
    }

    public function randomContacts($sort_last, $sort_first, $pagination){
        $this->showContacts($sort_last, $sort_first, $pagination);
        $this->view->render('random');
        if(isset($_POST['add_random']) && isset($_POST['amount_of_records'])){
            new RandomWriter($_POST['amount_of_records']);
            header("location:" . URL . "Contacts/showContacts/ASC/ASC/1/");
        }
    }

    public function jsonAjaxTableData($sort_last, $sort_first, $pagination){
        $this->view->data = $this->model->showContactsModel($sort_last, $sort_first, $pagination);
        echo json_encode($this->view->data);
    }
}

?>