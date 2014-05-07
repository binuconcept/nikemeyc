<?php

include_once 'meyc_dao.php';
$result = array();
/* &&&&&&&&&&&&&&&&&&&&&&&&& TO RECORD the IP STARTS &&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&& */
if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
    $ip = $_SERVER['HTTP_CLIENT_IP'];
    $ip_source = "shared";
} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    $ip_source = "forwarded";
} else {
    $ip = $_SERVER['REMOTE_ADDR'];
    $ip_source = "remote";
}
/* &&&&&&&&&&&&&&&&&&&&&&&&& TO RECORD the IP ENDS &&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&& */

/* &&&&&&&&&&&&&&&&&&&&&&&&& COLLECT THE POST DATA STARTS &&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&& */

$hasError = false;

if (!empty($_POST["user_source"])) {
    $user_source = filter_var($_POST["user_source"], FILTER_SANITIZE_STRING);
} else {
    $hasError = true;
}
if (!empty($_POST["fullname"])) {
    $fullname = filter_var($_POST["fullname"], FILTER_SANITIZE_STRING);
} else {
    $hasError = true;
}

if (!empty($_POST["email"])) {
    $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $hasError = true;
    } else {
        ;
    }
} else {
    $hasError = true;
}

if (!empty($_POST["city"])) {
    $city = filter_var($_POST["city"], FILTER_SANITIZE_STRING);
} else {
    $hasError = true;
}
if (!empty($_POST["phone_no"])) {
    $phone_no = filter_var($_POST["phone_no"], FILTER_SANITIZE_STRING);
} else {
    $hasError = true;
}
if (!empty($_POST["video_content"])) {
    $video_content = filter_var($_POST["video_content"], FILTER_SANITIZE_STRING);
} else {
    $hasError = true;
}
/* &&&&&&&&&&&&&&&&&&&&&&&&& COLLECT THE POST DATA ENDS &&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&& */

/* &&&&&&&&&&&&&&&&&&&&&&&&& CHECK THE VALIDATION STARTS &&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&& */
$meyc_dao_OBJ = new meyc_dao();
if ($hasError) {
    $result['status'] = "error";
    $result['error'] = "please pass all the required parameters";
} else {
    $is_record_already_exist = $meyc_dao_OBJ->checkUserExist($email);
    if ($is_record_already_exist == "non_existing") {
        // insert the new record for user
        $post_data['user_source'] = $user_source;
        $post_data['fullname'] = $fullname;
        $post_data['email'] = $email;
        $post_data['city'] = $city;
        $post_data['phone_no'] = $phone_no;
        $post_data['user_status'] = 1;
        $post_data['ip_address'] = $ip;
        $post_data['ip_source'] = $ip_source;
        $return_value = $meyc_dao_OBJ->insertUsers($post_data);
        if ($return_value != "failure") {
            //data inserted sucessfully
            $updated_userid = $return_value;
        }
    } else if ($is_record_already_exist != "failure") {
        $updated_userid = $is_record_already_exist;
    }
}
/* &&&&&&&&&&&&&&&&&&&&&&&&& CHECK THE VALIDATION ENDS &&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&& */

/* &&&&&&&&&&&&&&&&&&&&&&&&& INSERTING DATA TO THE VIDEO TABLE STARTS &&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&& */
if (!empty($video_content) && (!empty($updated_userid))) {
    $video_data['user_id'] = $updated_userid;
    $video_data['video_content'] = $video_content;
    $video_data['video_status'] = 1;
    $updated_video_value = $meyc_dao_OBJ->insertVideo($video_data);
    if ($updated_video_value != "failure") {
        //data inserted sucessfully
        $result['status'] = "success";
    }
} else {
    $result['status'] = "error";
    $result['errormsg'] = "userid or video content is missing";
}
echo json_encode($result);

/* &&&&&&&&&&&&&&&&&&&&&&&&&  INSERTING DATA TO THE VIDEO TABLE ENDS &&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&& */
?>
