<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=utf-8');
require_once '_db.php';
require_once '_common.php';

// if(isset($_GET{'sessionid'}) && !empty($_GET['sessionid']))
// {
    // $_sessionid =  $_GET['sessionid'];
    // $_session_verification = session_verify($_sessionid, $conn);
    // $_session_email = $_session_verification['session_data'][0]['email'];
    // if($_session_verification['result']=='success')
    // {
        $_stmt = $conn->prepare('SELECT * FROM `projects`');
        $_result = array();
        $_stmt->execute();
        if($_stmt->rowCount()>0)
        {
            while($row = $_stmt->fetch(PDO::FETCH_OBJ))
            {
                array_push($_result, $row);
            }
            echo json_encode(['result'=>'success', 'data'=>json_encode($_result), 'message'=>'Data retreived']);exit();
        }
        echo json_encode(['result'=>'error', 'data'=>'null', 'message'=>'Data not found']);exit();
    // }
    // echo json_encode(['result'=>'error', 'data'=>'null', 'message'=>'Invalid error']);exit();
// }
// echo json_encode(['result'=>'error', 'data'=>'null', 'message'=>'Invalid Entry']);exit();
?>