<?php

namespace contact\core;
use contact\helpers\InputClear;

if(!defined("PROJECT_ACCESS"))exit("ACCESS DENIED");

class Model extends Database{
    
    protected $database;
    protected $select;
    protected $insert;
    protected $delete;
    protected $update;
    protected $from;
    protected $orderBy;
    protected $where;
    protected $limit;
    protected $inputClear;

    function __construct()
    {
        $this->database = Database::initDatabase(Application::getConfig());
        $this->inputClear = new InputClear();
        $this->select = "";
        $this->insert = "";
        $this->delete = "";
        $this->update = "";
        $this->from = "";
        $this->orderBy = "";
        $this->where = "";
        $this->limit = "";

    }

    public function runQuery($statement){
        $query = $this->database->prepare($statement);
        $query->execute();
        return $query;
    }

    public function validate($post){
        $inputErr = array();
        if (is_array($post)) {
        foreach ($post as $key => $value) {
            if (empty($value)) {
                $inputErr[$key] = "$key is required";
            } elseif ($key == "email") {
                if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    $inputErr[$key] = "* invalid email format";
                }
            } elseif ($key == "home_phone" || $key == "work_phone" || $key == "cell_phone") {
                $regex = "/^(\d[\s-]?)?[\(\[\s-]{0,2}?\d{3}[\)\]\s-]{0,2}?\d{3}[\s-]?\d{4}$/i";
                if (!preg_match($regex, $value)) {
                    $inputErr[$key] = "* invalid phone format";
                }
            } elseif ($key == "birth_date") {
                if (date('Y-m-d', strtotime($value)) != $value) {
                    $inputErr[$key] = "* Invalid date";
                }
            } elseif ($key == "login") {
                if (!preg_match("/^[a-zA-Z ]*$/", $post['login'])) {
                    $inputErr[$key] = "correct $key is required";
                }
            } elseif ($key == "password") {
                if (!preg_match("/^[a-zA-Z]|[0-9]$/", $post['password'])) {
                    $inputErr[$key] = "invalid password format";
                }
            } elseif ($key == "repeat_password") {
                if ($post["password"] != $post["repeat_password"]) {
                    $inputErr['repeat_password'] = "Password doesn't mach";
                }
            }
        }
    }

        return $inputErr;
    }



    public function select($select){
        $this->select = "SELECT ".$select." ";
        return $this;
    }

    public function insert($table, $insert){
        $columns = "";
        $values = "";
        foreach ($insert as $key => $value){
            $columns .= $key.", ";
            $values .= "'".$value."', ";
        }
        $columns = rtrim($columns, ", ");
        $values = rtrim($values, ", ");
        $this->insert = "INSERT INTO $table ($columns)VALUES ($values) ";
        return $this;
    }

    public function delete(){
        $this->delete = "DELETE ";
        return $this;
    }

    public function update($table, $property){
        $property_string = "";
        foreach ($property as $key => $value){
            $property_string .= $key."='".$value."', ";
        }
        $property_string = rtrim($property_string, ", ");
        $this->update = "UPDATE $table SET $property_string ";
        return $this;
    }

    public function from($from){
        $this->from = "FROM ".$from." ";
        return $this;
    }


    public function where($param){
        $columns = "";
        $values = "";
        $property_string = "";
        foreach ($param as $key => $value){
            $columns .= $key."=";
            $values .= "'".$value."', ";
            $property_string .= $columns.$values;
        }
        $property_string = rtrim($property_string, ", ");
        $this->where = "WHERE ".$property_string;
        return $this;
    }

    public function orderBy($param1, $param2){
        $this->orderBy = "ORDER BY ".SORT_TABLE_LAST." ".$param1.", ".SORT_TABLE_FIRST." ".$param2." ";
        return $this;
    }

    public function limit($position, $count=""){
        $this->limit = "LIMIT ".$position;
        if($count != ""){
            $this->limit .= ", ".$count;
        }
        return $this;
    }

    public function createQuery(){
        $query = $this->select.$this->insert.$this->delete.$this->update.$this->from.$this->where.$this->orderBy.$this->limit;
        //echo $query . "<br>";
        $this->select = "";
        $this->insert = "";
        $this->delete = "";
        $this->update = "";
        $this->from = "";
        $this->where = "";
        $this->limit = "";
        return $query;
    }
}


?>