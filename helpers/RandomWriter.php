<?php
namespace contact\helpers;

use contact\models\ContactsModel;

if(!defined("PROJECT_ACCESS"))exit("ACCESS DENIED");

class RandomWriter extends ContactsModel
{
    public $element;
    public $db_types;

    public function __construct($amount_of_records)
    {
        parent::__construct();
        $this->db_types = $this->getDBTableTypes();
        $this->writeRandomData($amount_of_records);
    }


    public function writeRandomData($amount){
        for($i=0; $i<$amount; $i++){
            $element = $this->create($this->db_types);
            $element['user_id'] = $this->user_id;
            $this->runQuery($this->insert($this->table, $element)
                ->createQuery());
        }
    }

    function create($db_types){
        foreach ($db_types as $key => $value){
            if($value == "int"){
                $array[$key] = $this->zip();
            }
            if($value == "varchar"){
                if($key == "email"){
                    $array[$key] = $this->email();
                }
                elseif($key == "home_phone" || $key == "cell_phone" || $key == "work_phone" || $key == "best_phone") {
                    $array[$key] = $this->phone();
                }
                elseif($key == "address1" || $key == "address2"){
                    $array[$key] = $this->address();
                }
                elseif($key == "zip"){
                    $array[$key] = $this->zip();
                }
                elseif($key == "country"){
                    $array[$key] = $this->country();
                }
                else{
                    $array[$key] = $this->fullName();
                }

            }
            if(is_array($value)){
                $array[$key] = $this->enum($db_types);
            }
            if($value == "float"){
                $array[$key] = $this->price();
            }
            if($value == "date"){
                $array[$key] = $this->date(1980-01-01, 2000-02-01);
            }
        }
        return $array;
    }

    function getDBTableTypes(){
        $check = "SELECT COLUMN_NAME, DATA_TYPE FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = '$this->table';";
        $type = $this->runQuery($check);
        $type = $type->fetchAll(\PDO::FETCH_ASSOC);
        foreach ($type as $value_arr){
            foreach ($value_arr as $value_type){
                $db_types[] = $value_type;
            }
        }
        //echo "<pre>";  var_dump($type_array);  var_dump($db_types);  echo "</pre>";

        $i = 0;
        do{
            $final_array[$db_types[$i]] = $db_types[$i+1];
            $i +=2;

        }while($i < count($db_types));

        foreach ($final_array as $key => $value){
            if($value == "enum"){
                $check_enum = "SELECT COLUMN_TYPE FROM INFORMATION_SCHEMA.COLUMNS WHERE table_name = '$table' AND column_name = '$key';";
                $enum = $this->runQuery($check_enum);
                $enum_array = $enum->fetchAll(\PDO::FETCH_ASSOC);

                $enum_array_value = $enum_array[0];
                //echo "<pre>"; var_dump($enum_array_value); echo "</pre>";
                foreach ($enum_array_value as $value){
                    $value = ltrim($value, "enum('");
                    $value = trim($value, "')'");
                    $enum_res = explode("','", $value);
                }

                $final_array[$key] = $enum_res;
            }
        }
        //echo "<pre>";  var_dump($final_array);  echo "</pre>";

        return $final_array;
    }

    public function date($min, $max, $format = 'Y-m-d')
    {
        $start = strtotime($min);
        $end = strtotime($max);

        $date = mt_rand($start, $end);

        return date($format, $date);
    }

    public function enum($db_types)
    {
        $number = rand(0, 5);
        foreach ($db_types as $key => $value){
            if(is_array($value)){
                $choice = $value;
            }
        }
        $skill = $choice[$number];
        return $skill;
    }


    public function price()
    {
        $price = mt_rand(100, 10000) / 100;
        return $price;
    }

    public function fullName()
    {
        $a = rand(0,11);
        $name = array("Віктор", "Костя", "Оля", "Марина", "Іван", "Петро", "Петрук", "Комар", "Мотиль", "Груша", "Коваль", "Сівач");
        $rand = $name[$a];
        return $rand;
    }

    public function email()
    {
        $a = rand(0, 7);
        $name = array("fendeka@mail.ru", "papi@gmail.com", "olala@gmaiil.ru", "random@mail.ua", "qwerty@mail.exp", "petya@q.com", "java@gmail.com", "scala@google.com");
        $rand = $name[$a];
        return $rand;
    }

    public function phone()
    {
        $a = rand(0, 5);
        $name = array("123 333 4474", "000-000-0000", "123 000 4044", "423 313 4344",  "1233334404", "123 3334447", );
        $rand = $name[$a];
        return $rand;
    }

    public function address()
    {
        $a = rand(0, 6);
        $name = array("m. Ternopil", "m. Lviv", "m. Melburn", "m. Monreal", "m. Ottava", "m. Praha", "m. Toronto");
        $rand = $name[$a];
        return $rand;
    }

    public function country()
    {
        $a = rand(0, 7);
        $name = array("Ukraine", "Canada", "Australia", "Austria", "Belgium", "Poland", "Italy", "USA");
        $rand = $name[$a];
        return $rand;
    }

    public function zip(){
        return $age = rand(1, 999);
    }

    public function write(){
        $str = $this->zip() . " " . $this->date(1980-01-01, 2000-02-01) . " " . $this->enum() . " " . $this->fullName() . " " . $this->price();
        print $str;
    }
}

?>