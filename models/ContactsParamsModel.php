<?php
namespace contact\models;

if(!defined("PROJECT_ACCESS"))exit("ACCESS DENIED");

class ContactsParamsModel extends ContactsModel{

 public function __construct($sort_last, $sort_first, $pagination)
 {
  parent::__construct();
 }

 public function sortingParams($sort_last, $sort_first){
  $sorting_params_no_changes = $sort_last."/".$sort_first;

  if($sort_last == 'ASC'){
   $sorting_params_last = 'DESC/'.$sort_first;
  }else{
   $sorting_params_last = 'ASC/'.$sort_first;
  }

  if($sort_first == 'ASC'){
   $sorting_params_first = $sort_last."/DESC";
  }else{
   $sorting_params_first = $sort_last."/ASC";
  }

  $sorting_params = array('sorting_params_last' => $sorting_params_last,
      'sorting_params_first' => $sorting_params_first,
      'sorting_params_no_changes' => $sorting_params_no_changes
  );

  return $sorting_params;
 }

 public function paginationParams($page){
  if(empty($page)){
   $page =1;
  }
  $page1 = ($page == "" || $page == "1")? 0 : ($page*PER_PAGE)-PER_PAGE ;
  $query = $this->select("*")
                ->from($this->table)
                ->where(array("user_id" => $this->user_id))
                ->createQuery();
  $response = $this->runQuery($query);
  $counter = $response->rowCount();
  $var = ceil($counter/PER_PAGE);
  $prev = $page <=1 ? 1 : $page-1;
  $next = $page >= $var ? $page : $page+1;
  $pagination_params = array("page" => $page,
      "prev_page" => $prev,
      "next_page" => $next,
      "page1" => $page1,
      "var" => $var
  );
  return $pagination_params;
 }
}

?>