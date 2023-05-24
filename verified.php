<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=utf-8');
require_once '_db.php';

if(isset($_GET['email']) && !empty($_GET['email'])){
    $_email = $_GET['email'];
    $_stmt = $conn->prepare('SELECT `verified` FROM `users` WHERE `email` = :EMAIL');
    $_stmt->execute([':EMAIL'=>$_email]);
    $_result = $_stmt->fetchAll();
    print_r($_result);
    if($_result[0][0]==1){
        echo json_encode(['result'=>'success','verified'=>True, 'message'=>'user is verified']);exit();
    }
    echo json_encode(['result'=>'success', 'verified'=>False, 'message'=>'user not verified']);exit();
}
?>