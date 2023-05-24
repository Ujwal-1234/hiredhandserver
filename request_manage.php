<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=utf-8');
require_once '_db.php';
require_once '_common.php';

if(isset($_GET['type']) && isset($_GET['user']) && isset($_GET['sessionid']) && isset($_GET['pid']) && !empty($_GET['type']) && !empty($_GET['user']) && !empty($_GET['sessionid']) && !empty($_GET['pid']))
{

    $_session_id = $_GET['sessionid'];
    $_session_verification = session_verify($_session_id, $conn);
    $_user = $_GET['user'];
    $_type = $_GET['type'];
    $_pid = $_GET['pid'];
    if($_session_verification['result']=='success')
    {
        // print_r($_session_verification);
        // print_r($_session_verification['session_data'][0]['email']);
        $_admin_email = $_session_verification['session_data'][0]['email'];
        $_sql_stmt = "SELECT `requested_users`, `community_members` FROM `projects` WHERE `initiated_by_email`=:INEMAIL AND `project_id`=:PID";

        // $_sql_users = "SELECT `project_id` FROM `users` WHERE `email`"
        // $_stmt = $conn->prepare($_sql_stmt);
        $_stmt->execute([':INEMAIL'=>$_admin_email, ':PID'=>$_pid]);
        if($_stmt->rowCount()>0)
        {
            $_p_data = $_stmt->fetch(PDO::FETCH_ASSOC);
            $_existing_requests = $_p_data['requested_users'];
            $_existing_comm = $_p_data['community_members'];
            $_existing_commarr = explode(",", $_existing_comm);
            $_existing_arr = explode(",", $_existing_requests);

            if(_check_user($_user, $_existing_arr) && !_check_user($_user, $_existing_commarr))
            {
                switch (strval($_type)) {
                    case '1':
                        $_new_removed_arr = _remove_element_from_arr($_user, $_existing_arr);
                        $_new_append_arr = _add_element_to_arr($_user, $_existing_commarr);
                        $_updated_requests =  implode(",",$_new_removed_arr);
                        $_updated_community =  implode(",",$_new_append_arr);
                        $_update_sql = "UPDATE `projects` SET `community_members`= :COMEMBERS,`requested_users`=:REQUSERS WHERE `project_id`= :PID";
                        $_stmt = $conn->prepare($_update_sql);
                        if($_stmt->execute([':COMEMBERS'=>$_updated_community, ':PID'=>$_pid, ':REQUSERS'=>$_updated_requests]))
                        {
                            echo json_encode(['result'=>'success', 'message'=>'access provided']);exit();
                        }
                        echo json_encode(['result'=>'error', 'message'=>'failed to provide access']);exit();
                        break;
                    case '0':
                        $_new_removed_arr = _remove_element_from_arr($_user, $_existing_arr);
                        $_update_sql = "UPDATE `projects` SET `requested_users`=:REQUSERS WHERE `project_id`= :PID";
                        $_stmt = $conn->prepare($_update_sql);
                        if($_stmt->execute([':PID'=>$_pid, ':REQUSERS'=>$_updated_requests]))
                        {
                            echo json_encode(['result'=>'success', 'message'=>'request removed']);exit();
                        }
                        echo json_encode(['result'=>'error', 'message'=>'failed to provide access']);exit();
                        break;
                    
                    default:
                        echo json_encode(['result'=>'error', 'message'=>'Invalid requests, Parameters not found']);exit();
                        break;
                }                
                echo json_encode(['result'=>'error', 'message'=>'Invalid Request']);exit();
            }
            echo json_encode(['result'=>'error', 'message'=>'Invalid requests, Parameters not found']);exit();
        }
        echo json_encode(['result'=>'error', 'message'=>'project not found']);exit();
    }
    echo json_encode(['result'=>'error', 'message'=>'Invalid session relogin']);exit();
}
echo json_encode(['result'=>'error', 'message'=>'Invalid entry']);exit();
?>