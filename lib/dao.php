<?php
include_once 'dbconnect.php';
include_once  'interface1.php';

class dao implements interface1 
{    
    private $conn;
    function __construct() 
    {
        //include_once './config.php';
       
        $db=new DbConnect();
        $this->conn=$db->connect();
    }

    function dbCon() {
      $db=new dbconnect();
      return  $this->conn=$db->connect();
    }

    //data insert funtion
    function insert($table,$value)
    {
        $field="";
        $val="";
        $i=0;
        
        foreach ($value as $k => $v)
        {
            $v = $this->conn->real_escape_string($v);
            if($i == 0)
            {
                $field.=$k;
                $val.="'".$v."'";
            }
            
            else 
            {
                $field.=",".$k;
                $val.=",'".$v."'";
                
            }
            $i++;
            
        }
        mysqli_set_charset($this->conn,"utf8mb4");
        return mysqli_query($this->conn,"INSERT INTO $table($field) VALUES($val)") or die(mysqli_error($this->conn));
    }
    
    // insert log
    function insert_log($recident_user_id,$society_id,$user_id,$user_name,$log_name)
    {   
      $log_name = $this->conn->real_escape_string($log_name);
      $user_name = $this->conn->real_escape_string($user_name);
        $now=date("y-m-d H:i:s");
        $val="'$recident_user_id','$society_id','$user_id','$user_name','$log_name','$now'";
        mysqli_set_charset($this->conn,"utf8mb4");
        return mysqli_query($this->conn,"INSERT INTO log_master(recident_user_id,society_id,user_id,user_name,log_name,log_time) VALUES($val)") or die(mysqli_error($this->conn));
    }

    function insert_myactivity($recident_user_id,$society_id,$user_id,$user_name,$log_name,$log_img)
    {   
      $log_name = $this->conn->real_escape_string($log_name);
      $user_name = $this->conn->real_escape_string($user_name);
        $now=date("y-m-d H:i:s");
        $val="'$recident_user_id','$society_id','$user_id','$user_name','$log_name','$now','$log_img'";
        mysqli_set_charset($this->conn,"utf8mb4");
        return mysqli_query($this->conn,"INSERT INTO log_master(recident_user_id,society_id,user_id,user_name,log_name,log_time,log_img) VALUES($val)") or die(mysqli_error($this->conn));
    }

     function insertGuardNotification($notification_logo,$title,$description,$click_action,$society_id,$block_id)
    { 
        $select = mysqli_query($this->conn,"SELECT default_time_zone FROM `society_master` WHERE society_id=$society_id") or die(mysqli_error($this->conn));
        $row=mysqli_fetch_array($select);
        $default_time_zone=$row['default_time_zone'];
        
        date_default_timezone_set("$default_time_zone");

        $today=date('Y-m-d H:i');
          
        mysqli_set_charset($this->conn,"utf8mb4");
        return mysqli_query($this->conn,"INSERT INTO guard_notification_master(society_id,guard_notification_title,guard_notification_desc,employee_id,guard_notification_date,click_action,notification_logo) SELECT employee_master.society_id, '$title','$description',employee_master.emp_id,'$today','$click_action','$notification_logo' FROM employee_master,employee_block_master  WHERE employee_master.emp_id=employee_block_master.emp_id AND employee_master.emp_type_id='0' AND employee_master.society_id='$society_id' AND employee_block_master.block_id='$block_id'") or die(mysqli_error($this->conn));
    }


     function insertUserNotification($society_id,$title,$description,$notification_action,$notification_icon,$append_query)
    { 

        $select = mysqli_query($this->conn,"SELECT default_time_zone FROM `society_master` WHERE society_id=$society_id") or die(mysqli_error($this->conn));
        $row=mysqli_fetch_array($select);
        $default_time_zone=$row['default_time_zone'];
        
        date_default_timezone_set("$default_time_zone");

        $today=date('Y-m-d H:i');

        if ($append_query!="") {
            $append_query= "AND ".$append_query;
        }
          
        $title = $this->conn->real_escape_string($title);
        $description = $this->conn->real_escape_string($description);
        mysqli_set_charset($this->conn,"utf8mb4");
        return mysqli_query($this->conn,"INSERT INTO user_notification(society_id,user_id,notification_title,notification_desc,notification_date,notification_action,notification_logo) SELECT '$society_id', users_master.user_id,'$title','$description','$today','$notification_action','$notification_icon' FROM users_master,unit_master,block_master  WHERE block_master.block_id=unit_master.block_id AND users_master.unit_id=unit_master.unit_id AND users_master.user_status='1' AND users_master.user_token!='' AND users_master.society_id='$society_id' $append_query") or die(mysqli_error($this->conn));
    }

    function insertUserNotificationVendor($society_id,$title,$description,$notification_action,$notification_icon,$append_query,$service_provider_users_id)
    { 

        $select = mysqli_query($this->conn,"SELECT default_time_zone FROM `society_master` WHERE society_id=$society_id") or die(mysqli_error($this->conn));
        $row=mysqli_fetch_array($select);
        $default_time_zone=$row['default_time_zone'];
        
        date_default_timezone_set("$default_time_zone");

        $today=date('Y-m-d H:i');

        if ($append_query!="") {
            $append_query= "AND ".$append_query;
        }
          
        $title = $this->conn->real_escape_string($title);
        $description = $this->conn->real_escape_string($description);
        mysqli_set_charset($this->conn,"utf8mb4");
        return mysqli_query($this->conn,"INSERT INTO user_notification(society_id,user_id,notification_title,notification_desc,notification_date,notification_action,notification_logo,feed_id) SELECT '$society_id', users_master.user_id,'$title','$description','$today','$notification_action','$notification_icon','$service_provider_users_id' FROM users_master,unit_master,block_master  WHERE block_master.block_id=unit_master.block_id AND users_master.unit_id=unit_master.unit_id AND users_master.user_status='1' AND users_master.user_token!='' AND users_master.society_id='$society_id' $append_query") or die(mysqli_error($this->conn));
    }

    //using insert funtion for procedures 
    function insert1($table, $value)
    {
        $field="";
        $val="";
        $i = 0;
        
          foreach($value as $k => $v)
          {
            $v = $this->conn->real_escape_string($v);
              if($i==0)
             
               {
                  $field.=$k;
                  $val.="'" . $v . "'";
              }
              else 
              {
                  $field.="," . $k ;
                  $val.=", '" . $v . "'";
              }
              $i++;
          }
          mysqli_set_charset($this->conn,"utf8mb4");
          return mysqli_query($this->conn,"CALL $table($val)")or die(mysqli_error($this->conn));;
    }
    
      //select funtion display data
    function select($table, $where='', $other='')
    {
        if($where != '')
        {
            $where= 'where ' .$where;
        }
        mysqli_set_charset($this->conn,"utf8mb4");
        $select = mysqli_query($this->conn,"SELECT * FROM $table $where $other") or die(mysqli_error($this->conn));
        return $select;
    }

    function check_auth($auth_user_name,$auth_password)
    {
        mysqli_set_charset($this->conn,"utf8mb4");
        $select = mysqli_query($this->conn,"SELECT * FROM users_master WHERE user_id='$auth_user_name'") or die(mysqli_error($this->conn));
        $data=  mysqli_fetch_array($select);
        if ($data>0) {
            $last3Digit=  $newstring = substr($data['user_mobile'], -3);
            $myPassword= $data['user_id'].'@'.$last3Digit.'@'.$data['society_id'];
            if ($myPassword==$auth_password) {
                return 'true';
            } else {
                return 'false';
            }
        } else {
            return 'false';
        }
    }


    function getBlockid($user_id)
    {
        
        mysqli_set_charset($this->conn,"utf8mb4");
        $select = mysqli_query($this->conn,"SELECT block_id FROM `users_master` WHERE `user_id`='$user_id'") or die(mysqli_error($this->conn));
        $data=  mysqli_fetch_array($select);

        return $data['block_id'];
    } 

    function selectAdmin($where='')
    {
        if($where != '')
        {
            $where= 'where ' .$where;
        }
        mysqli_set_charset($this->conn,"utf8mb4");
        $select = mysqli_query($this->conn,"SELECT * FROM `bms_admin_master` WHERE admin_active_status=0 AND `admin_id` not in (SELECT admin_id FROM admin_block_master) UNION SELECT a.* FROM `bms_admin_master` as a inner JOIN admin_block_master as ab on a.`admin_id`=ab.admin_id $where") or die(mysqli_error($this->conn));
        return $select;
    }

    function getTimezone($society_id)
    {
        
        if ($society_id=='' || $society_id==0) {
            return 'Asia/Calcutta';
        } else{
        mysqli_set_charset($this->conn,"utf8mb4");
        $select = mysqli_query($this->conn,"SELECT default_time_zone FROM `society_master` WHERE society_id=$society_id") or die(mysqli_error($this->conn));
        $row=mysqli_fetch_array($select);
        $default_time_zone=$row['default_time_zone'];
            return $default_time_zone;
        }
    }

    function selectAdminBlockwise($admin_notification_id,$block_id,$device)
    {
         $fcmArray=array();
        mysqli_set_charset($this->conn,"utf8mb4");
        $select = mysqli_query($this->conn,"SELECT bms_admin_master.token,bms_admin_master.society_id,bms_admin_master.device FROM  bms_admin_master,bms_admin_notification_master WHERE admin_active_status=0 AND bms_admin_master.device='$device' AND  bms_admin_master.token!='' AND bms_admin_notification_master.admin_notification_id='$admin_notification_id' AND bms_admin_notification_master.admin_id=bms_admin_master.admin_id AND bms_admin_master.role_id!=1 AND bms_admin_master.`admin_id` not in (SELECT admin_id FROM admin_block_master) UNION SELECT bms_admin_master.token,bms_admin_master.society_id,bms_admin_master.device FROM bms_admin_master,bms_admin_notification_master,admin_block_master WHERE bms_admin_master.device='$device' AND  bms_admin_master.token!='' AND  bms_admin_notification_master.admin_notification_id='$admin_notification_id' AND bms_admin_notification_master.admin_id=bms_admin_master.admin_id AND bms_admin_master.role_id!=1 AND admin_block_master.admin_id=bms_admin_master.admin_id AND admin_block_master.block_id='$block_id' ") or die(mysqli_error($this->conn));
                while ($row=mysqli_fetch_array($select)) {
                    array_push($fcmArray, $row['token']);
                  }
        return $fcmArray;
    }

    function selectAdminWise($admin_notification_id,$device)
    {
         $fcmArray=array();
        mysqli_set_charset($this->conn,"utf8mb4");
        $select = mysqli_query($this->conn,"SELECT bms_admin_master.token,bms_admin_master.society_id,bms_admin_master.device FROM  bms_admin_master,bms_admin_notification_master WHERE admin_active_status=0 AND bms_admin_master.device='$device' AND  bms_admin_master.token!='' AND bms_admin_notification_master.admin_notification_id='$admin_notification_id' AND bms_admin_notification_master.admin_id=bms_admin_master.admin_id AND bms_admin_master.role_id!=1 AND bms_admin_master.`admin_id` not in (SELECT admin_id FROM admin_block_master) UNION SELECT bms_admin_master.token,bms_admin_master.society_id,bms_admin_master.device FROM bms_admin_master,bms_admin_notification_master,admin_block_master WHERE bms_admin_master.device='$device' AND  bms_admin_master.token!='' AND  bms_admin_notification_master.admin_notification_id='$admin_notification_id' AND bms_admin_notification_master.admin_id=bms_admin_master.admin_id AND bms_admin_master.role_id!=1 AND admin_block_master.admin_id=bms_admin_master.admin_id ") or die(mysqli_error($this->conn));
                while ($row=mysqli_fetch_array($select)) {
                    array_push($fcmArray, $row['token']);
                  }
        return $fcmArray;
    }

    function selectAdminInOut($emp_id,$device,$empType)
    {
        $fcmArray=array();
        mysqli_set_charset($this->conn,"utf8mb4");
        if ($device=='android') {
            $select = mysqli_query($this->conn,"SELECT * FROM bms_admin_master,employee_in_out_notification WHERE bms_admin_master.admin_id=employee_in_out_notification.admin_id AND employee_in_out_notification.emp_id='$emp_id' AND bms_admin_master.device='android' AND empType='$empType'") or die(mysqli_error($this->conn));
        } else {

            $select = mysqli_query($this->conn,"SELECT * FROM bms_admin_master,employee_in_out_notification WHERE bms_admin_master.admin_id=employee_in_out_notification.admin_id AND employee_in_out_notification.emp_id='$emp_id' AND bms_admin_master.device!='android' AND empType='$empType'") or die(mysqli_error($this->conn));
        }
        while ($row=mysqli_fetch_array($select)) {
            array_push($fcmArray, $row['token']);
          }
        return $fcmArray;
    }

    
    function getRecentChatMember($table, $user_id)
    {
        
        mysqli_set_charset($this->conn,"utf8mb4");
        $select = mysqli_query($this->conn,"SELECT msg_for, MAX(max_date) AS max_date FROM( (SELECT chat_id,msg_by, msg_for, MAX(msg_date) AS max_date FROM $table WHERE msg_by = $user_id AND sent_to=0 AND send_by=0 GROUP BY msg_by, msg_for ORDER BY `max_date` DESC) union all (SELECT chat_id, msg_for,msg_by, MAX(msg_date) AS max_date FROM $table WHERE msg_for = $user_id AND sent_to=0 AND send_by=0 GROUP BY msg_by, msg_for ORDER BY `max_date` DESC) ) as newdata group by msg_for ORDER BY `max_date` DESC ") or die(mysqli_error($this->conn));
        return $select;
    }

     function getRecentChatMemberNew($table, $user_id)
    {
        
        mysqli_set_charset($this->conn,"utf8mb4");
         $select = mysqli_query($this->conn,"SELECT cm.*,um.user_full_name,um.user_first_name,um.user_last_name, um.gender, um.user_type, um.user_status, um.user_mobile, um.country_code, um.public_mobile, um.member_date_of_birth, um.user_profile_pic, um.member_status, un.unit_name, un.company_name, un.unit_status, un.unit_id, un.floor_id, bm.block_name from(SELECT MAX(a.chat_id) as chat_id, a.msg_by as user_id , MAX(msg_date) as msg_date from( (SELECT MAX(chat_id) as chat_id, MAX(msg_date) as msg_date, msg_by from $table where msg_for = $user_id and send_by=0 and sent_to=0 GROUP by msg_by Order by chat_id desc) union all (SELECT MAX(chat_id) as chat_id, MAX(msg_date) as msg_date, msg_for from $table where msg_by= $user_id and send_by=0 and sent_to=0 GROUP by msg_for Order by chat_id desc)) as a GROUP by msg_by Order by chat_id desc) as f inner join $table as cm on cm.chat_id=f.chat_id inner join users_master as um on um.user_id=f.user_id inner join unit_master as un on un.unit_id=um.unit_id inner join block_master as bm on bm.block_id=um.block_id ") or die(mysqli_error($this->conn));
        return $select;
    }


     function getRecentChatMemberNewTenant($table, $user_id)
    {
        
        mysqli_set_charset($this->conn,"utf8mb4");
         $select = mysqli_query($this->conn,"SELECT cm.*,um.user_full_name,um.user_first_name,um.user_last_name, um.gender, um.user_type, um.user_status, um.user_mobile, um.public_mobile, um.member_date_of_birth, um.user_profile_pic, um.member_status, un.unit_name, un.unit_status, un.unit_id, un.floor_id, bm.block_name from(SELECT MAX(a.chat_id) as chat_id, a.msg_by as user_id , MAX(msg_date) as msg_date from( (SELECT MAX(chat_id) as chat_id, MAX(msg_date) as msg_date, msg_by from $table where msg_for = $user_id and send_by=0 and sent_to=0 GROUP by msg_by Order by chat_id desc) union all (SELECT MAX(chat_id) as chat_id, MAX(msg_date) as msg_date, msg_for from $table where msg_by= $user_id and send_by=0 and sent_to=0 GROUP by msg_for Order by chat_id desc)) as a GROUP by msg_by Order by chat_id desc) as f inner join $table as cm on cm.chat_id=f.chat_id inner join users_master as um on um.user_id=f.user_id AND um.tenant_view=0 inner join unit_master as un on un.unit_id=um.unit_id inner join block_master as bm on bm.block_id=um.block_id ") or die(mysqli_error($this->conn));
        return $select;
    }

    function getRecentChatGatekeeper($table, $user_id)
    {
        
        mysqli_set_charset($this->conn,"utf8mb4");
        $select = mysqli_query($this->conn,"SELECT msg_for, MAX(max_date) AS max_date FROM( (SELECT chat_id,msg_by, msg_for, MAX(msg_date) AS max_date FROM $table WHERE msg_by = $user_id AND sent_to=1 GROUP BY msg_by, msg_for ORDER BY `max_date` DESC) union all (SELECT chat_id, msg_for,msg_by, MAX(msg_date) AS max_date FROM $table WHERE msg_for = $user_id AND send_by=1 GROUP BY msg_by, msg_for ORDER BY `max_date` DESC) ) as newdata group by msg_for ORDER BY `max_date` DESC ") or die(mysqli_error($this->conn));
        return $select;
    }

    function getRecentChatGatekeeperToUser($table, $emp_id)
    {
        
        mysqli_set_charset($this->conn,"utf8mb4");
        $select = mysqli_query($this->conn,"SELECT cm.*,um.user_full_name,um.user_first_name,um.user_last_name, um.gender, um.user_type, um.user_status, um.user_mobile, um.mobile_for_gatekeeper, um.member_date_of_birth, um.user_profile_pic, um.member_status, un.unit_name, un.unit_status, un.unit_id, un.floor_id, bm.block_name from(SELECT MAX(a.chat_id) as chat_id, a.msg_by as user_id , MAX(msg_date) as msg_date from( (SELECT MAX(chat_id) as chat_id, MAX(msg_date) as msg_date, msg_by from $table where msg_for = $emp_id and send_by=0 and sent_to=1 GROUP by msg_by Order by chat_id desc) union all (SELECT MAX(chat_id) as chat_id, MAX(msg_date) as msg_date, msg_for from $table where msg_by= $emp_id and send_by=1 and sent_to=0 GROUP by msg_for Order by chat_id desc)) as a GROUP by msg_by Order by chat_id desc) as f inner join $table as cm on cm.chat_id=f.chat_id inner join users_master as um on um.user_id=f.user_id inner join unit_master as un on un.unit_id=um.unit_id inner join block_master as bm on bm.block_id=um.block_id ") or die(mysqli_error($this->conn));
        return $select;
    }
      //select funtion display data
    function selectRow($colum,$table, $where='', $other='')
    {
        if($where != '')
        {
            $where= 'where ' .$where;
        }
        mysqli_set_charset($this->conn,"utf8mb4");
        $select = mysqli_query($this->conn,"SELECT $colum FROM $table $where $other") or die(mysqli_error($this->conn));
        return $select;
    }
    function select_row($table, $where='', $other='')
    {
        if($where != '')
        {
            $where= 'where ' .$where;
        }
        mysqli_set_charset($this->conn,"utf8mb4");
        $select = mysqli_query($this->conn,"SELECT COUNT(*) as num_rows FROM $table $where $other") or die(mysqli_error($this->conn));
        return $select;
    }
     //select funtion display data with DISTINCT  (not show duplicate)
    function select1($table, $column, $where='',$other='')
    {
        if($where != '')
        {
            $where= 'where ' .$where;
        }
        mysqli_set_charset($this->conn,"utf8mb4");
        $select = mysqli_query($this->conn,"SELECT DISTINCT $column FROM $table $where $other") or die(mysqli_error($this->conn));
        return $select;
    }
    function select2($table, $where='',$other='')
    {
        if($where != '')
        {
            $where= 'where ' .$where;
        }
        mysqli_set_charset($this->conn,"utf8mb4");
        $select = mysqli_query($this->conn,"SELECT DISTINCT * FROM $table $where $other") or die(mysqli_error($this->conn));
        return $select;
    }
    function selectColumnWise($table,$columnName='',$where=''){
        if($where != '')
        {
           $where= 'where ' .$where;
        }
        mysqli_set_charset($this->conn,"utf8mb4");
         $select = mysqli_query($this->conn,"SELECT $columnName FROM $table $where") or die(mysqli_error($this->conn));
        return $select;
    }
  
    // using sp   
    function selectSp($spName) {

      mysqli_set_charset($this->conn, "utf8mb4");
      $result = mysqli_query($this->conn, "CALL $spName");
      return $result;
      // return mysqli_query($this->conn,"CALL $table")or die(mysqli_error($this->conn));;
    }
   
    function selectSpArray($spName) {

      $dataArray=array();
      mysqli_set_charset($this->conn, "utf8mb4");
      $result = mysqli_query($this->conn, "CALL $spName");
      while($data_countries_list=mysqli_fetch_array($result)) {
        array_push($dataArray, $data_countries_list);
      }
      mysqli_next_result($this->conn);
      return $dataArray;
      // return mysqli_query($this->conn,"CALL $table")or die(mysqli_error($this->conn));;
    }
      //delete using update query(active_flag)
     function delete1($table ,$var, $where)
    {
        if($where != '')
        {
            $where= 'where ' .$where;
        }
        if($var != '')
        {
            $var= 'active_flag= ' .$var;
        }
        mysqli_set_charset($this->conn,"utf8mb4");
        return mysqli_query($this->conn,"update $table set $var $where");
    }

    //Update Product View (view_status)
     function view_status($table ,$var, $where)
    {
        if($where != '')
        {
            $where= 'where ' .$where;
        }
        if($var != '')
        {
            $var= 'view_status= ' .$var;
        }
        mysqli_set_charset($this->conn,"utf8mb4");
        return mysqli_query($this->conn,"update $table set $var $where");
    }


     //Comment ()
     function comment($table ,$var, $where)
    {
        if($where != '')
        {
            $where= 'where ' .$where;
        }
        if($var != '')
        {
            $var= 'status= ' .$var;
        }
        mysqli_set_charset($this->conn,"utf8mb4");
        return mysqli_query($this->conn,"update $table set $var $where");
    }
     //delete permanataly  function
    function delete($table , $where='')
    {
        if($where != '')
        {
        $where= 'where ' .$where;
        }
        mysqli_set_charset($this->conn,"utf8mb4");
        return mysqli_query($this->conn,"delete FROM $table $where")or die(mysqli_error($this->conn));
    }

    //Upadate funtion
    function update($table ,$value, $where)
    {
        if($where != '')
        {
            $where= 'where ' .$where;
        }


        $val="";
        $i=0;
        foreach ($value as $k => $v)
        {
            $v = $this->conn->real_escape_string($v);
            if($i == 0)
            {
              $val.=$k."='".$v."'";    
            }
            
            else 
            {
              $val.=",".$k."='".$v."'";
            }
            $i++;
            
        }
        mysqli_set_charset($this->conn,"utf8mb4");
        return mysqli_query($this->conn,"update $table SET $val $where");
    }
     //select next auto_increment_id
    function last_auto_id($table)
    {
        mysqli_set_charset($this->conn,"utf8mb4");
        $select_id = mysqli_query($this->conn,"SHOW TABLE STATUS LIKE '$table'" ) or die(mysqli_error($this->conn));
        return $select_id;
    }

        //Count Data of Table
    function count_data($field='' ,$table ,$where='')
    {
        if($where != '')
        {
            $where= 'where ' .$where;
        }
        mysqli_set_charset($this->conn,"utf8mb4");
        $count_data = mysqli_query($this->conn,"SELECT $field,COUNT(*)  FROM $table $where" ) or die(mysqli_error($this->conn));
        return $count_data;

    }

    //Count Data of Table
    function count_data_direct($field='' ,$table ,$where='')
    {
        if($where != '')
        {
            $where= 'where ' .$where;
        }
        mysqli_set_charset($this->conn,"utf8mb4");
        // $temp = mysqli_query($this->conn,"SELECT $field,COUNT(*)  FROM $table $where" ) or die(mysqli_error($this->conn));
        // while($rowCount=mysqli_fetch_array($temp)) {
        // $totalCount=$rowCount['COUNT(*)'];
        
        $result=mysqli_query($this->conn,"SELECT count(*) as $field from $table $where") or die(mysqli_error($this->conn));
        $data=mysqli_fetch_assoc($result);
        $totalCount= $data[$field];
        return $totalCount;
        // }

    }
     //Count sum of  Table field
    function sum_data($field='' ,$table ,$where='')
    {
        if($where != '')
        {
            $where= 'where ' .$where;
        }
        mysqli_set_charset($this->conn,"utf8mb4");
        $sum_data = mysqli_query($this->conn,"SELECT SUM($field) from $table $where" ) or die(mysqli_error($this->conn));
        return $sum_data;

    }

// sms send 
   function send_sms($society_id,$mobile,$message) {
        // deprecated  dlt registration required in india
       $msg=urlencode($message);
       $temp = mysqli_query($this->conn,"SELECT *  FROM sms where active_flag=0" ) or die(mysqli_error($this->conn));
       $smsData=mysqli_fetch_array($temp);
       if (mysqli_num_rows($temp)>0) {
       extract($smsData);
        $totalChar= strlen($message);
        $smsUsed=round($totalChar/160);
        if ($smsUsed==0) {
          $smsUsed=1;
        }
        $smsUsed;


        $select = mysqli_query($this->conn,"SELECT default_time_zone FROM `society_master` WHERE society_id=$society_id") or die(mysqli_error($this->conn));
        $row=mysqli_fetch_array($select);
        $default_time_zone=$row['default_time_zone'];
        
        date_default_timezone_set("$default_time_zone");
        
         $senderNumber= $mobile;
         $senderMsg= $message;
         $apiCall = str_replace('$mobile', $senderNumber, "$sms_api");
         $senderMsg=urlencode($senderMsg);
         $apiCall = str_replace('$msg', "$senderMsg", "$apiCall");
         $sms= file_get_contents("$apiCall");
         $now=date("Y-m-d H:i:s");
         $val="'$society_id','$mobile','$message','$smsUsed','$now'";
          mysqli_set_charset($this->conn,"utf8mb4");
          return mysqli_query($this->conn,"INSERT INTO sms_log_master(society_id,user_mobile,sms_log,used_credit,log_time) VALUES($val)") or die(mysqli_error($this->conn));

       }
      // echo $sms= file_get_contents("https://2factor.in/API/R1/?module=TRANS_SMS&apikey=2eb6de0f-3a58-11e9-8806-0200cd936042&to=$mobile&from=FINCAS&msg=$msg");

    }

   

    // get fcm token
    function getFcm($fildName,$table,$where){
     mysqli_set_charset($this->conn,"utf8mb4");
     $sql="SELECT $fildName FROM $table WHERE $where";
     $temp=mysqli_query($this->conn,$sql);
     $data=mysqli_fetch_array($temp);
       if($data > 0){
        $fcm=$data[$fildName];
        return $fcm;
       }
       else{
        return false;
       }
      }


   function get_android_fcm($table,$where) {
        if($where != '')
        {
            $where= 'where ' .$where;
        }
        mysqli_set_charset($this->conn,"utf8mb4");
        $select = mysqli_query($this->conn,"SELECT * FROM $table $where") or die(mysqli_error($this->conn));
        $totalUsers = mysqli_num_rows($select);
        $loopCount= $totalUsers/1000;
        $loopCount= round($loopCount)+1;

           for ($i=0; $i <$loopCount ; $i++) { 
                $limit_users = $i."000";
                $fcmArray=array();
                $q1 = mysqli_query($this->conn,"SELECT user_token FROM $table $where GROUP BY user_token") or die(mysqli_error($this->conn));
                  while ($row=mysqli_fetch_array($q1)) {
                    $user_token= $row['user_token'];
                    array_push($fcmArray, $user_token);
                  }
               $fcmArray = array_unique($fcmArray);
               $fcmArray = array_values($fcmArray);  
                 return $fcmArray;

              }
   }

    function get_emp_fcm($table,$where) {
        if($where != '')
        {
            $where= 'where ' .$where;
        }
        mysqli_set_charset($this->conn,"utf8mb4");
        $select = mysqli_query($this->conn,"SELECT * FROM $table $where") or die(mysqli_error($this->conn));
        $totalUsers = mysqli_num_rows($select);
        $loopCount= $totalUsers/1000;
        $loopCount= round($loopCount)+1;

           for ($i=0; $i <$loopCount ; $i++) { 
                $limit_users = $i."000";
                $fcmArray=array();
                $q1 = mysqli_query($this->conn,"SELECT emp_token FROM $table $where") or die(mysqli_error($this->conn));
                  while ($row=mysqli_fetch_array($q1)) {
                    $emp_token= $row['emp_token'];
                    array_push($fcmArray, $emp_token);
                  }
                  $fcmArray = array_unique($fcmArray);
                  $fcmArray = array_values($fcmArray); 
                 return $fcmArray;
              }
   }

   function get_admin_fcm($table,$where) {
        if($where != '')
        {
            $where= 'where ' .$where;
        }
        mysqli_set_charset($this->conn,"utf8mb4");
        $select = mysqli_query($this->conn,"SELECT * FROM $table $where") or die(mysqli_error($this->conn));
        $totalUsers = mysqli_num_rows($select);
        $loopCount= $totalUsers/1000;
        $loopCount= round($loopCount)+1;

           for ($i=0; $i <$loopCount ; $i++) { 
                $limit_users = $i."000";
                $fcmArray=array();
                $q1 = mysqli_query($this->conn,"SELECT token FROM $table $where") or die(mysqli_error($this->conn));
                  while ($row=mysqli_fetch_array($q1)) {
                    $token= $row['token'];
                    array_push($fcmArray, $token);
                  }
                $fcmArray = array_unique($fcmArray);
                $fcmArray = array_values($fcmArray); 
                 return $fcmArray;
              }
   }


   function formatSizeUnits($bytes)
    {
        if ($bytes >= 1073741824)
        {
            $bytes = number_format($bytes / 1073741824, 2) . ' GB';
        }
        elseif ($bytes >= 1048576)
        {
            $bytes = number_format($bytes / 1048576, 0) . ' MB';
        }
        elseif ($bytes >= 1024)
        {
            $bytes = number_format($bytes / 1024, 0) . ' KB';
        }
        elseif ($bytes > 1)
        {
            $bytes = $bytes . ' bytes';
        }
        elseif ($bytes == 1)
        {
            $bytes = $bytes . ' byte';
        }
        else
        {
            $bytes = '0 bytes';
        }

        return $bytes;
}
  //update counter
  function updateCounter($table ,$value='')
    {
        mysqli_set_charset($this->conn,"utf8mb4");
        return mysqli_query($this->conn,"update $table SET $value");
    }


      //select funtion display data
    function dbSize()
    {
        mysqli_set_charset($this->conn,"utf8mb4");
        $select = mysqli_query($this->conn,"SHOW TABLE STATUS") or die(mysqli_error($this->conn));
        return $select;
    }

    
    function selectArray($table, $where='', $other='')
    {
      if($where != '')
      {
          $where= 'where ' .$where;
      }
      mysqli_set_charset($this->conn,"utf8");
      mysqli_set_charset($this->conn,"utf8mb4");
      $select = mysqli_query($this->conn,"SELECT * FROM $table $where $other") or die(mysqli_error($this->conn));
      $data = mysqli_fetch_array($select);
      return $data;
    }


    function GetCurrencySymbol($currency_char){
        // $fmt = new NumberFormatter('en_US', NumberFormatter::CURRENCY);
        // $fmt->setTextAttribute(NumberFormatter::CURRENCY_CODE, $currency_char);
        // $fmt->setAttribute(NumberFormatter::FRACTION_DIGITS, 0);
        // $temp=$fmt->formatCurrency("0",$currency_char);
        // $temp = preg_replace('/[0-9]+/', '', $temp);
        return '₹';
    }


    function send_sms_multiple($mobiles,$message) {
      $curl = curl_init();
      curl_setopt_array($curl, array(
        CURLOPT_URL => "http://2factor.in/API/V1/2eb6de0f-3a58-11e9-8806-0200cd936042/ADDON_SERVICES/SEND/TSMS",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => "{\"From\": \"FINCAS\",\"To\": \"$mobiles\", \"Msg\": \"$message\"}",
      ));
      $response = curl_exec($curl);
      $err = curl_error($curl);
      curl_close($curl);
      if ($err) {
        echo "cURL Error #:" . $err;
      } else {
        echo $response;
      }
      return $error;
    }


    function number_format_short( $n ) {
        if ($n > 0 && $n < 1000) {
            // 1 - 999
            $n_format = floor($n);
            $suffix = '';
        } else if ($n >= 1000 && $n < 1000000) {
            // 1k-999k
            $n_format = floor($n / 1000);
            $suffix = 'K+';
        } else if ($n >= 1000000 && $n < 1000000000) {
            // 1m-999m
            $n_format = floor($n / 1000000);
            $suffix = 'M+';
        } else if ($n >= 1000000000 && $n < 1000000000000) {
            // 1b-999b
            $n_format = floor($n / 1000000000);
            $suffix = 'B+';
        } else if ($n >= 1000000000000) {
            // 1t+
            $n_format = floor($n / 1000000000000);
            $suffix = 'T+';
        }

        return !empty($n_format . $suffix) ? $n_format . $suffix : 0;
    }

    function haversineGreatCircleDistance(
      $latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo, $earthRadius = 6371000)
    {
      // convert from degrees to radians
      $latFrom = deg2rad($latitudeFrom);
      $lonFrom = deg2rad($longitudeFrom);
      $latTo = deg2rad($latitudeTo);
      $lonTo = deg2rad($longitudeTo);

      $latDelta = $latTo - $latFrom;
      $lonDelta = $lonTo - $lonFrom;

      $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +
        cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));
      return $angle * $earthRadius;
    }


    function add_sms_log($mobile,$message_name,$society_id,$country_code,$sms_count) {
       
        $now=date("Y-m-d H:i:s");
        $val="'$society_id','$mobile','$message_name','$sms_count','$now','$country_code'";
          mysqli_set_charset($this->conn,"utf8mb4");
          return mysqli_query($this->conn,"INSERT INTO sms_log_master(society_id,user_mobile,sms_log,used_credit,log_time,country_code) VALUES($val)") or die(mysqli_error($this->conn));


    }

    function get_encrypt_key($society_id) {
        $common_key = "4c5cfefcc958f1748eb31dcc609736FK";
        $society_id_count = strlen($society_id); 
        if ($society_id!='' && $society_id!='0') {
          $newKey = $society_id.substr($common_key, $society_id_count);
        } else {
          $newKey = $common_key;
        }
        return $newKey;
    } 

    function get_encrypt_iv($society_id) {
        $iv_master = "K8Csuc2GiKvetPZg";
        $society_id_count = strlen($society_id); 
        if ($society_id!='' && $society_id!='0') {
          $newIv = $society_id.substr($iv_master, $society_id_count);
        } else {
          $newIv = $iv_master;
        }
        return $newIv;
    }  

    function master_url() {
        $newIv = "https://master.myassociation.app/";
        return $newIv;
    }
    /******************** Satyajeet ***********/
    function get_server_key() {
        $newIv = "key=AAAAAAgqcT0:APA91bEuWr657sbbVWo-2-u-VVYqxSeMpq8VZw_FPcv1zNZlljh_23n4O81eGUGUPAWnMZv--4qjY9EvQzpeYHQheV0HzySB29J8tCAwY2yXxvLDuIIK8VR-GK7D7_edk3VrEK69_srb";
        return $newIv;
    }
    function send_otp_sp($mobile,$otp) {
        $value1=urlencode("<#>");
        $sms= file_get_contents("https://2factor.in/API/R1/?module=TRANS_SMS&apikey=2eb6de0f-3a58-11e9-8806-0200cd936042&to=$mobile&from=FINCAG&templatename=Fincasys+Service+Provider+OTP&var1=$value1&var2=$otp");
    }
    /******************** Satyajeet ***********/

    function change_timezone($dbtime,$newtimezone,$format) {
    
      $datetime = new DateTime($dbtime);
    
      $datetime->format($format);
    
      $la_time = new DateTimeZone($newtimezone);
    
      $datetime->setTimezone($la_time);
    
    return $datetime->format($format);
    
    }
    

    

    
    function insert_log_specific($society_id,$user_id,$user_name,$log_name,$log_type)
    
    {   
    
      $log_name = $this->conn->real_escape_string($log_name);
    
      $user_name = $this->conn->real_escape_string($user_name);
    
        $now=date("y-m-d H:i:s");
    
        $val="'$society_id','$user_id','$log_type','$user_name','$log_name','$now'";
    
        mysqli_set_charset($this->conn,"utf8mb4");
    
        return mysqli_query($this->conn,"INSERT INTO log_master(society_id,user_id,log_type,user_name,log_name,log_time) VALUES($val)") or die(mysqli_error($this->conn));
    
    }

    function getWebFcm($table,$where) {
      if($where != '')
      {
          $where= 'where ' .$where;
      }
      mysqli_set_charset($this->conn,"utf8mb4");
      $select = mysqli_query($this->conn,"SELECT * FROM $table $where") or die(mysqli_error($this->conn));
      $totalUsers = mysqli_num_rows($select);
      $loopCount= $totalUsers/1000;
      $loopCount= round($loopCount)+1;

      for ($i=0; $i <$loopCount ; $i++) { 
          $limit_users = $i."000";
          $fcmArray=array();
          $q1 = mysqli_query($this->conn,"SELECT fcm_token FROM $table $where GROUP BY fcm_token") or die(mysqli_error($this->conn));
            while ($row=mysqli_fetch_array($q1)) {
              $fcm_token= $row['fcm_token'];
              array_push($fcmArray, $fcm_token);
            }
           return $fcmArray;
        }
    }

    function android_url() {
        $newIv = "https://play.google.com/store/apps/details?id=com.myassociation";
        return $newIv;
    }

    function ios_url() {
        $newIv = "https://apps.apple.com/kh/app/my-association-app/id1565765469";
        return $newIv;
    }
    function bm_random_hex() {
     $rand = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'a', 'b', 'c', 'd', 'e', 'f');
     return '#' . $rand[rand(0,15)] . $rand[rand(0,15)] . $rand[rand(0,15)] . $rand[rand(0,15)] . $rand[rand(0,15)] . $rand[rand(0,15)];
    }

    function app_name() {
        $project_name = "IND IN ADL";
        return $project_name;
    }

    function deep_link_url($link_url)
    {
        include_once 'model.php';
        $m = new model();

        $android_package_list = '{"androidPackageName":"'.ANDROID_PACKAGE_NAME.'"}';
        $ios_package_list = '{"iosBundleId":"'.IOS_PACKAGE_NAME.'"}';
        $dynamicLinkInfo = '{"domainUriPrefix":"'.DOMAIN_URL.'","link":"'.$link_url.'","androidInfo":'.$android_package_list.',"iosInfo":'.$ios_package_list.'}';
        $postdata = array('dynamicLinkInfo' => json_decode($dynamicLinkInfo));
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://firebasedynamiclinks.googleapis.com/v1/shortLinks?key='.WEB_API_KEY,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>json_encode($postdata),
            CURLOPT_HTTPHEADER => array(
              'Content-Type: application/json'
          ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        $result = json_decode($response,true);

        return $result;
    }

    function executeSql($sql, $type)
    {
        $query = mysqli_query($this->conn, $sql);
        $result01=array();
        switch ($type) {

            case 'result_array':
            while ( $data=mysqli_fetch_array($query)) {
                array_push($result01,$data);
            }
            $result = $result01;
            break;
            case 'row_array':
            $result = mysqli_fetch_assoc($query);
            break;
            case 'num_rows':
            $result = mysqli_num_rows($query);
            break;
            default:
            $result = 'Failed';
            break;
        }
        return $result;

    }


 function getTimeSlot($interval, $start_time, $end_time){
                    $start = new DateTime($start_time);
                    $end = new DateTime($end_time);
                    $startTime = $start->format('H:i');
                    $endTime = $end->format('H:i');
                    $i=0;
                    $time = [];
                    while(strtotime($startTime) <= strtotime($endTime))
                    {
                        $start = $startTime;
                        $end = date('H:i',strtotime('+'.$interval.' minutes',strtotime($startTime)));
                        $startTime = date('H:i',strtotime('+'.$interval.' minutes',strtotime($startTime)));
                        $i++;
                        if(strtotime($startTime) <= strtotime($endTime)){
                            $time[$i]['slot_start_time'] = $start;
                            $time[$i]['slot_end_time'] = $end; 
                        }
                    }
                        
                    
                    return $time;

            }
}
?>