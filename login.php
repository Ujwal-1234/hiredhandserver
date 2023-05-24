<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=utf-8');
require_once '_db.php';
require_once '_common.php';

if(isset($_GET['userid']) && isset($_GET['password']) && !empty($_GET['userid']) && !empty($_GET['password']))
{
    $_userid = $_GET['userid'];
    $_password = $_GET['password'];
    $stmt = $conn->prepare("SELECT * FROM `users` WHERE `email` = :Email");
    $stmt->execute([':Email'=>$_userid]);
    if($stmt->rowCount()<1){
        echo json_encode(["result"=>"error",
        "message"=>"user does not exist",
        "user_exist"=>False]);
        exit();
    }
    $_data_row = $stmt->fetchAll();
    if(_verify_password($_password, $_data_row[0]['pass']))
    {
        $_session_id = _generate_session_token($_userid);
        $_session_stmt = $conn->prepare("INSERT INTO `sessionids`(`sessionid`, `email`) VALUES (:sessionid,:email)");
        if($_session_stmt->execute([':sessionid'=>$_session_id, ':email'=>$_userid]))
        {
                echo json_encode(["result"=>"success",
                "email"=>$_userid,"session_id"=>$_session_id, "message"=>"The user is loggedin successfully"]);exit();
        }
        echo json_encode(['result'=>'error', 'message'=>'contact admin']);exit();
    }
    echo json_encode(['result'=>'error', 'message'=>'Invalid password']);exit();
}
echo json_encode(['result'=>'error', 'message'=>'Invalid entry']);exit();
?> 