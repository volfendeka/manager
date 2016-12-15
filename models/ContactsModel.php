<?php
namespace contact\models;

use contact\core\Model;
use contact\helpers\Session;
use contact\helpers\InputClear;

class ContactsModel extends Model{

    protected $table = "person";
    protected $user_id;
    public $clean_POST;

    function __construct()
    {
        parent::__construct();
        $this->user_id = Session::get("user_id");
        $this->clean_POST = $this->inputClear->clearPost($_POST);
    }

    
    public function showContactsModel($sort_last, $sort_first, $pagination){
        $params = new ContactsParamsModel($sort_last, $sort_first, $pagination);
        $pagin_params = $params->paginationParams($pagination);
        $sorting_params = $params->sortingParams($sort_last, $sort_first);

        $query = $this->select("*")
                        ->from($this->table)
                        ->where(array("user_id" => $this->user_id))
                        ->orderBy($sort_last, $sort_first)
                        ->limit($pagin_params['page1'], PER_PAGE)
                        ->createQuery();
        $response = $this->runQuery($query);
        $response = $response->fetchAll();
        $data_to_show = array('contacts_data' => $response,
                              'pagination_params' => $pagin_params,
                              'sorting_params' => $sorting_params,
            );
        return $data_to_show;
    }


    

    
    public function addContactModel(){
        $contact_to_add = $this->clean_POST;
        array_pop($contact_to_add);
        $contact_to_add['user_id'] = $this->user_id;
        $contact_to_add['best_phone'] = $this->setBestPhone();
        $error = $this->validate($contact_to_add);
        if(empty($error)) {
            $query = $this->insert($this->table, $contact_to_add)
                            ->createQuery();
            $response = $this->runQuery($query);
            $response->fetch();
            return false;
        }else{
            return $error;
        }
    }

    private function setBestPhone(){
        switch ($this->clean_POST['best_phone']) {
            case 'h':
                $best_phone = $this->clean_POST['home_phone'];
                break;
            case 'w':
                $best_phone = $this->clean_POST['work_phone'];
                break;
            case 'c':
                $best_phone = $this->clean_POST['cell_phone'];
                break;
        }
        return $best_phone;
    }


    public function deleteContactModel($contact_id){
        $query = $this->delete()
                        ->from($this->table)
                        ->where(array("id" => $contact_id))
                        ->createQuery();
        $this->runQuery($query);
        return true;
    }



    public function viewContactModel($contact_id){
        $query = $this->select("*")
                        ->from($this->table)
                        ->where(array("id" => $contact_id))
                        ->createQuery();
        $contact_to_show = $this->runQuery($query);
        $data = $contact_to_show->fetch();
        return $data;
    }

    public function editContactModel($contact_id){
        $contact_to_edit = $this->clean_POST;
        array_pop($contact_to_edit);
        $error = $this->validate($contact_to_edit);
        if(empty($error)) {
            $query = $this->update($this->table, $contact_to_edit)
                            ->where(array("id" => $contact_id))
                            ->createQuery();
            $this->runQuery($query);
            return false;
        }else{
            return $error;
        }
    }






    
    public function getCheckedEmails($id_array){
        foreach ($id_array as $key => $value){
            $param = array("id" => $value);
            $query = $this->select('email')
                            ->from($this->table)
                            ->where($param)
                            ->createQuery();
            $response = $this->runQuery($query);
            $emails_array[] = $response->fetch(\PDO::FETCH_ASSOC);
        }
        foreach ($emails_array as $i => $k){
            foreach ($k as $q => $w){
                $emails_array_final[] = $w;
            }
        }
        return $emails_array_final;
    }


    public function checkAllBoxes($variable){
        switch ($variable){
            case "all":
                $checked = array("box" => "checked",
                    "addr" => "no"
                );
                break;
            case "no":
                $checked = array("box" => "",
                    "addr" => "all"
                );
                break;
            default:
                $checked = array("box" => "",
                    "addr" => "all"
                );
        }
        return $checked;
    }

    public function checkIfNewEmailsPrinted(){
        $query = $this->select("email")
            ->from($this->table)
            ->where(array("user_id" => $this->user_id))
            ->createQuery();
        $response = $this->runQuery($query);
        if ($response->rowCount() > 0) {
            $data = $response->fetchAll(\PDO::FETCH_COLUMN);
            if(isset($this->clean_POST['submit_send']) && !empty($this->clean_POST['send'])) {
                $mailArray = explode(',', $this->clean_POST['send']);
                $result = array_diff($mailArray, $data);
                if (!empty($result)) {
                    return $result;
                }
            }
        }
        return false;
    }
    
    public function writeNewEmailsModel(){
        $this->clean_POST['add'] = $this->inputClear->clearPost($_POST['add']);
            foreach ($_POST['add'] as $key => $value) {
                $insert['user_id'] = $this->user_id;
                $insert['email'] = $value;
                $query = $this->insert($this->table, $insert)
                                ->createQuery();
                $this->runQuery($query);
            }
       
    }

}