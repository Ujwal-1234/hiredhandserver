<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=utf-8');
require_once '_db.php';
require_once '_common.php';
if(isset($_GET['sessionid']) && !empty($_GET['sessionid']))
{
    $_sessionid = $_GET['sessionid'];
    $_verify_session = session_verify($_sessionid, $conn);
    if($_verify_session['verified']===TRUE)
    {
        echo json_encode(['result'=>'success', 'session_data'=>$_verify_session['session_data'], 'verified'=>TRUE]);
        exit();
    }
    echo json_encode(['result'=>'error', 'verified'=>FALSE,'message'=>'session not verified Relogin please !']);
    exit();
}
?>