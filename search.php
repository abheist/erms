<?php
function search($search_term)
{
  $query= "select SHA(candid_id) as cid,name,added_by,contactno,ca_email,user_name from candidate_details inner join user_details on candidate_details.added_by=user_details.user_id";
  $clean_search=str_replace(',',' ',$search_term);
  $search_words=explode(' ',$clean_search);
  $final_search_words=array();
  if(count($search_words)>0){
    foreach($search_words as $words)
    {
      if(!empty($words))
      $final_search_words[]=$words;
    }
  }
  $where_list=array();
    if(count($final_search_words)>0)
    {
        foreach($final_search_words as $search_words){
            $where_list[]="name like '%$search_words%' or user_name like '%$search_words%' or contactno like '%$search_words%'";
        }
    }
    $where_clause=implode(' OR ',$where_list);
    if(!empty($where_clause))
    $query .=" where $where_clause";
    return $query;
}
function getright($right)
{
  switch ($right) 
      {
        case 0:
         return 'Superuser';
          break;
        case 1:
          return 'Manager';
          break;
        case 2:
          return 'User';
          break;
        default:
          return 'User';
          break;
      }
}
?>
