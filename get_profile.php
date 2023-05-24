<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=utf-8');
require_once '_db.php';
require_once '_common.php';
if(isset($_GET['email']) && !empty($_GET['email']))
{
    $_email = $_GET['email'];
    $_sql = "SELECT `full_name`, `phone`, `email`, `verified`, `project_id` FROM `users` WHERE `email`=:EMAIL";
    $_stmt = $conn->prepare($_sql);
    $_stmt->execute([':EMAIL'=>$_email]);
    if($_stmt->rowCount()>0)
    {
        $_p_data = $_stmt->fetch(PDO::FETCH_ASSOC);
        echo json_encode(['result'=>'success', 'data' => $_p_data, 'message'=>'data retrieved']);exit();
    }
}
echo json_encode(['result'=>'error', 'message'=>'Invalid entry']);exit();
?>