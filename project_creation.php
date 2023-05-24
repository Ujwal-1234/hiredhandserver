<?php 
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=utf-8');
require_once '_db.php';
require_once '_common.php';

if(isset($_GET['req_skills']) &&isset($_GET['sessionid']) && isset($_GET['project_title']) && isset($_GET['project_desc']) && isset($_GET['project_cat']) && !empty($_GET['sessionid']) && !empty($_GET['project_title']) && !empty($_GET['req_skills']) && !empty($_GET['project_desc']) && !empty($_GET['project_cat']))
{
    $_sessionid = $_GET['sessionid'];
    $_project_title = $_GET['project_title'];
    $_project_desc = $_GET['project_desc'];
    $_project_cat = $_GET['project_cat'];
    $_req_skills = $_GET['req_skills'];
    
    $_session_verification = session_verify($_sessionid, $conn);
    if($_session_verification['result']=='success')
    {
        $_initiated_by = $_session_verification['session_data'][0]['email'];
        $_user_data = get_user($_initiated_by, $conn);
        $_stmt = $conn->prepare('INSERT INTO `projects` (`initiated_by`, `project_title`, `project_description`, `project_category`, `initiated_by_email`, `required_skills`) VALUES (:initiated_by, :project_title, :project_desc, :project_cat, :initiated_by_email, :req_skills)');
        if($_stmt -> execute([':initiated_by'=>$_user_data['user_data'][0]['full_name'], ':project_title'=>$_project_title, ':project_desc'=>$_project_desc, ':project_cat'=>$_project_cat, ':initiated_by_email'=>$_initiated_by, ':req_skills'=>$_req_skills]))
        {
            echo json_encode(['result'=>'success', 'verified'=>TRUE, 'message'=>'project created']);exit();
        }

    }
    echo json_encode(['result'=>'error', 'verified'=>FALSE, 'message'=>'invalid session. logging out...']);exit();
}
?>