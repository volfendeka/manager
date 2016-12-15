<?php
namespace contact\models;

use contact\core\Model;
use contact\helpers\InputClear;

if(!defined("PROJECT_ACCESS"))exit("ACCESS DENIED");

use contact\helpers\Session;

class UsersModel extends Model{

    private $table = "user";
    private $login;
    private $password;
    private $repeat_password;
    private $hash;
    private $user_to_create;
    private $error;

    function __construct()
    {
        parent::__construct();
        $clean_POST = $this->inputClear->clearPost($_POST);
        $this->login = isset($clean_POST['login'])?$clean_POST['login']:"";
        $this->password = isset($clean_POST['password'])?$clean_POST['password']:"";
        $this->repeat_password = isset($clean_POST['repeat_password'])?$clean_POST['repeat_password']:"";
        $this->error =  $this->validate($clean_POST);
    }

    public function runLogin(){
        if(empty($this->error)) {
            $query = $this->select("*")
                            ->from($this->table)
                            ->where(array("login" => $this->login))
                            ->createQuery();
            $response = $this->runQuery($query);
            $response = $response->fetch();
            if (count($response) > 0) {
                if (password_verify($this->password, $response['hash'])) {
                    Session::set("user_id", $response['id']);
                } else {
                    return true;
                }
                if (isset($_SESSION['user_id'])) {
                    return false;
                }
            } else {
                return true;
            }
            return true;
        }else{
            return $this->error;
        }
    }

    public function runRegister(){
        if(empty($this->error)) {
            $query = $this->select("*")
                            ->from($this->table)
                            ->where(array("login" => $this->login))
                            ->createQuery();
            $response = $this->runQuery($query);
            $response = $response->fetchAll();
            if (!count($response) > 0) {
                if ($this->password == $this->repeat_password && $this->login != "") {
                    $this->hash = password_hash($this->password, PASSWORD_BCRYPT, array('cost' => 12));
                    $this->user_to_create = array("login" => $this->login,
                        "hash" => $this->hash);
                    $this->query = $this->insert($this->table, $this->user_to_create)
                                        ->createQuery();
                    $this->runQuery($this->query);
                    return false;
                }
                return true;
            }else{
                $this->error['login']  = "login already exists";
                return $this->error;
            }
        }else{
            return $this->error;
        }
    }


}