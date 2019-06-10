<?php
require 'database.php';

// Get the posted data.
$postdata = file_get_contents("php://input");

if(isset($postdata) && !empty($postdata))
{
  // Extract the data.
  $request = json_decode($postdata);
  //print_r($request);


  // Validate.
  if(trim($request->number) === '' || (float)$request->amount < 0 || trim($request->name) === '')
  {
    return http_response_code(400);
  }

  // Sanitize.
  //$name = mysqli_real_escape_string($con, trim($request->name));
  $number = mysqli_real_escape_string($con, (int)$request->number);
  $name = mysqli_real_escape_string($con,$request->name);
  $amount = mysqli_real_escape_string($con, (int)$request->amount);


  // Create.
  $sql = "INSERT INTO `policies`(`id`,`number`,`name`,`amount`) VALUES (null,'{$number}','{$name}','{$amount}')";
  
  if(mysqli_query($con,$sql))
  {
    
    http_response_code(201);
    $policy = [
      'number' => $number,
      'name' => $name,
      'amount' => $amount,
      'id'    => mysqli_insert_id($con)
    ];
    echo json_encode($policy);
  }
  else
  {
    http_response_code(422);
  }
}