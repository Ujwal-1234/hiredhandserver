<?php 
    function _generate_session_token($_userid){
        return password_hash($_userid, PASSWORD_BCRYPT);
    }
    function _verify_password($client_p, $server_p){
        if($client_p == $server_p)return True;
    }
    function session_verify($_sessionid, $conn){
        $_stmt = $conn->prepare("SELECT * FROM `sessionids` WHERE `sessionid`=:SESSIONID");
        $_stmt->execute([':SESSIONID'=>$_sessionid]);
        if($_stmt->rowCount()>0){
            $_session_data = $_stmt->fetchAll();
            return ['result'=>'success', 'session_data'=>$_session_data, 'verified'=>TRUE];
        }
        return ['result'=>'error', 'verified'=>FALSE];
    }
    function get_user($_email, $conn){
        $_stmt = $conn->prepare("SELECT `full_name` FROM `users` WHERE `email`=:EMAIL");
        $_stmt->execute([':EMAIL'=>$_email]);
        if($_stmt->rowCount()>0){
            $_user_data = $_stmt->fetchAll();
            return ['result'=>'success', 'user_data'=>$_user_data, 'verified'=>TRUE];
        }
        return ['result'=>'error', 'verified'=>FALSE];
    }
    function _check_user($_user, $_user_list)
    {
        for( $i=0; $i<sizeof($_user_list);$i++)
        {
            if($_user == $_user_list[$i])
            {
                return TRUE;
            }
        }
        return FALSE;
    }
    function _remove_element_from_arr($_element, $_array)
    {
        $_new_array = array();
        for($i=0; $i<sizeof($_array); $i++)
        {
            if($_element!=$_array[$i])
            {
                $_new_array[$i] = $_array[$i];
            }
        }
        return $_new_array;
    }
    function _add_element_to_arr($_element, $_array)
    {
        array_push($_array, $_element);
        return $_array;
    }
?>
