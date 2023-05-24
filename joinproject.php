<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=utf-8');
require_once '_db.php';
require_once '_common.php';

if(isset($_GET['pid']) && isset($_GET['email']) && !empty($_GET['pid']) && !empty($_GET['email']))
{
    $_pid = $_GET['pid'];
    $_emailid = $_GET['email'];
    
    $_stmt = $conn->prepare("SELECT `requested_users`, `community_members` FROM `projects` WHERE `project_id`=:PID");
    $_stmt->execute([':PID'=>$_pid]);
    if($_stmt->rowCount()>0){
        $_requested_data = $_stmt->fetchAll();
        $_existing_requests = $_requested_data[0]['requested_users'];
        $_community_members = $_requested_data[0]['community_members'];
        $_community_list = explode(",", $_community_members);
        $_request_list = explode(",", $_requested_data[0]['requested_users']);
        if(_check_user($_emailid, $_request_list)||_check_user($_emailid, $_community_list)){
            echo json_encode(['result'=>'error', 'message'=>'already requested']);exit();
        }
        if(empty($_existing_requests)){
            $_new_requests = $_emailid;
        }
        (empty($_existing_requests))?$_new_requests=$_emailid:$_new_requests=$_existing_requests.','.$_emailid;
        $_insert_stmt = $conn->prepare("UPDATE `projects` SET `requested_users`=:REQUEST WHERE `project_id`=:PID");
        if($_insert_stmt->execute([':REQUEST'=>$_new_requests, ':PID'=>$_pid]))
        {
            echo json_encode(['result'=>'success', 'message'=>'request raised']);exit();
        }
        echo json_encode(['result'=>'error', 'message'=>'Failed to raise request']);exit();
    }  
}
echo json_encode(['result'=>'error', 'message'=>'Invalid Entry']); exit();
?>