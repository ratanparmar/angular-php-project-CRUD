<?php

require 'database.php';

$postdata = file_get_contents('php://input');

if(isset($postdata) && !empty($postdata)){
    
    $values = json_decode($postdata);
    if((int)$values->id<0 || trim($values->name) == '' 
    || trim($values->number == '' || (float)$values->amount <0)){
        return http_response_code(400);  
    }
    
    $id    = mysqli_real_escape_string($con, (int)$values->id);
    $number = mysqli_real_escape_string($con, trim($values->number));
    $name = mysqli_real_escape_string($con, trim($values->name));
    $amount = mysqli_real_escape_string($con,(float)$values->amount);

    $sql = "UPDATE `policies` SET `number`='$number',`name`='$name',`amount`='$amount' WHERE `id` = '{$id}' LIMIT 1";
    if(mysqli_query($con, $sql))
  {
    http_response_code(204);
  }
  else
  {
    return http_response_code(422);
  }  
}
?>