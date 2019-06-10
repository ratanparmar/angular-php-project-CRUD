<?php

require 'database.php';

$id = $_GET['id'];
if($id !== "" && $id >0){
   $id =  mysqli_real_escape_string($con,$id);
  // echo $id;

}
if(!$id){
    return http_response_code(400);
}
$sql = "DELETE FROM `policies` where id = {$id} LIMIT 1";
//echo $sql;

if(mysqli_query($con,$sql)){
  
    http_response_code(204);
}else{
    http_response_code(422);
}




?>