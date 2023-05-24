<?php
header('Access-Control-Allow-Origin: *');

// if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')   
// $url = "https://";   
// else  
// $url = "http://";   
// // Append the host(domain name, ip) to the URL.   
// $url.= $_SERVER['HTTP_HOST'];   

// // Append the requested resource location to the URL   
// $url.= $_SERVER['REQUEST_URI'];    
  
require_once '_db.php';
if (isset($_GET['full_name']) && isset($_GET['email_id']) && isset($_GET['phone']) && isset($_GET['password']) && !empty($_GET['full_name']) && !empty($_GET['email_id']) && !empty($_GET['phone']) && !empty($_GET['password']))
{
    $full_name = $_GET['full_name'];
    $email_id = $_GET['email_id'];
    $phone = $_GET['phone'];
    $password = $_GET['password'];

    $stmt = $conn->prepare("SELECT * FROM `users` WHERE `email` = :Email");
    $stmt->execute([':Email'=>$email_id]);
    if($stmt->rowCount()>0){
        // $_data_row = $stmt->fetchAll();
        // print_r($_data_row);
        echo json_encode(["result"=>"error",
        "message"=>"user already exist",
        "user_exist"=>True]);
        exit();
    }
    $_insert_stmt = $conn->prepare("INSERT INTO `users`(`full_name`, `phone`, `email`, `pass`) VALUES (:full_name,:phone,:email,:pass)");
    if($_insert_stmt->execute([':full_name'=>$full_name, ':phone'=>$phone, ':email'=>$email_id, ':pass'=>$password]))
    {
        echo json_encode(["result"=>"success", "message"=>"User Registered Successfully", "user_created"=>True]);
        exit();
    }
    echo json_encode(["result"=>"error", "message"=>"Failed to create user", "error"=>"Type unknown"]);exit();
}

echo json_encode(["result"=>"error", "message"=>"Didn't received meta data"]);
exit();
?> 

<!-- http://localhost/hiredhand/server/login.php?full_name=ujwal&email_id=kujwal147@gmail.com&phone=123242&password=asdfasf -->