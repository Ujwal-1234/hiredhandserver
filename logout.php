<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=utf-8');
require_once '_db.php';
if(isset($_GET['sessionid']) && !empty($_GET['sessionid'])){
    $_sessionid = $_GET['sessionid'];
    $stmt = $conn->prepare('SELECT * FROM `sessionids` WHERE `sessionid`=:sessionid');
    $stmt->execute([':sessionid'=>$_sessionid]);
    if($stmt->rowCount()>0){
        $_delete_stmt = $conn->prepare('DELETE FROM `sessionids` WHERE `sessionid`=:session_id');
        if($_delete_stmt->execute([':session_id'=>$_sessionid])){
            echo json_encode(['result'=>'success', 'message'=>'User Logged out']);
            exit();
        }
    }
}
?>