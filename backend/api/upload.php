<?php
if(isset($_SERVER["HTTP_ORIGIN"]))
{
    // You can decide if the origin in $_SERVER['HTTP_ORIGIN'] is something you want to allow, or as we do here, just allow all
    header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
}
else
{
    //No HTTP_ORIGIN set, so we allow any. You can disallow if needed here
    header("Access-Control-Allow-Origin: *");
}

header("Access-Control-Allow-Credentials: true");
header("Access-Control-Max-Age: 600");    // cache for 10 minutes

if($_SERVER["REQUEST_METHOD"] == "OPTIONS")
{
    if (isset($_SERVER["HTTP_ACCESS_CONTROL_REQUEST_METHOD"]))
        header("Access-Control-Allow-Methods: POST, GET, OPTIONS, DELETE, PUT"); //Make sure you remove those you do not want to support

    if (isset($_SERVER["HTTP_ACCESS_CONTROL_REQUEST_HEADERS"]))
        header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

    //Just exit with 200 OK with the above headers for OPTIONS method
    exit(0);
}






$response = array();
$upload_dir = 'uploads/';
$server_url = 'http://127.0.0.1:8000';

if($_FILES['myfile']){
$file_name = $_FILES['myfile']['name'];
$file_name_tmp = $_FILES['myfile']['tmp_name'];
$error = $_FILES['myfile']['error'];
    if($error>0){
        $response = array(
            'status'=>'error',
            'error'=> true,
            'message'=>'Error uploading file!!!'
        );
    }else{
        
        $randomname = rand(1000,100000)."-".$file_name;
        $upload_name = $upload_dir.strtolower($randomname);
        $upload_name_final = preg_replace('/\s+/','-',$upload_name);
        
        if(move_uploaded_file($file_name_tmp,$upload_name_final)){
            $response = array(
                'status'=>'success',
                'error'=>false,
                'message'=>'File uploaded successfully!!!',
                'url'=> $server_url."/".$upload_name_final
            );
        }else{
            $response = array(
                'status'=>'error',
                'error'=> true,
                'message'=>'No file was selected.'
            );
        }
    }

}else{
    $response = array(
        'status'=>'error',
        'error'=> true,
        'message'=>'No file was selected.'
    );
}
echo json_encode($response);




?>