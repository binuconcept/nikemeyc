<?php
/*
 * Written by binu
 */
date_default_timezone_set('Asia/Kolkata');
define('SERVER', 'localhost');
define('USERNAME', 'root');
define('PASSWORD', '');
define('DATABASE', 'nike_meyc');

class meyc_dao {
    /*
     * basic database connection
     */

    function __construct() {
        $connection = @mysql_connect(SERVER, USERNAME, PASSWORD) or die('Connection error -> ' . mysql_error());
        mysql_select_db(DATABASE, $connection) or die('Database error -> ' . mysql_error());
    }

    /*
     * checking the user is exist or not
     */

    function checkUserExist($params) {
        try {
            $q = sprintf("SELECT id FROM `nike_meyc`.`nike_meyc_users` WHERE `email` = '%s'AND `user_status` = 1;", mysql_real_escape_string($params));
            $r = mysql_query($q) or die(mysql_error());
            if (mysql_num_rows($r) > 0) {
                $sql_result = mysql_fetch_assoc($r);
                $retvar = $sql_result["id"];
            } else {
                $retvar = "non_existing";
            }
        } catch (Exception $ex) {
            $retvar = "failure";
        }
        return $retvar;
    }

    /*
     * Inserting the user data to the database
     */

    function insertUsers($params) {
        $retvar = "success";
        try {
            $current_timestamp = date('Y-m-d H:i:s');
            $q = sprintf("INSERT INTO `nike_meyc`.`nike_meyc_users`(`user_source`,`fullname`,`email`,`city`,`phone_no`,`user_status`,`ip_address`,`ip_source`,`created_date`)VALUES('%d','%s','%s','%s','%s','%d','%s','%s','%s');", mysql_real_escape_string($params['user_source']), mysql_real_escape_string($params['fullname']), mysql_real_escape_string($params['email']), mysql_real_escape_string($params['city']), mysql_real_escape_string($params['phone_no']), mysql_real_escape_string($params['user_status']), mysql_real_escape_string($params['ip_address']), mysql_real_escape_string($params['ip_source']), $current_timestamp);
            $r = mysql_query($q) or die(mysql_error());
            $inserted_id = mysql_insert_id();
            $retvar = $inserted_id;
        } catch (Exception $ex) {
            $retvar = "failure";
        }
        return $retvar;
    }

    /*
     * Inserting the video data to the database
     */

    function insertVideo($params) {
        $retvar = "success";
        try {
            $current_timestamp = date('Y-m-d H:i:s');
            $q = sprintf("INSERT INTO `nike_meyc`.`nike_video_logs`(`user_id`,`video_content`,`video_status`,`played_date`)VALUES('%u','%s','%d','%s');", mysql_real_escape_string($params['user_id']), mysql_real_escape_string($params['video_content']), mysql_real_escape_string($params['video_status']), $current_timestamp);
            $r = mysql_query($q) or die(mysql_error());
            $inserted_id = mysql_insert_id();
            $retvar = $inserted_id;
        } catch (Exception $ex) {
            $retvar = "failure";
        }
        return $retvar;
    }    
}

?>
