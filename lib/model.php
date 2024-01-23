<?php
define('API_ACCESS_KEY', 'AAAAAAgqcT0:APA91bEuWr657sbbVWo-2-u-VVYqxSeMpq8VZw_FPcv1zNZlljh_23n4O81eGUGUPAWnMZv--4qjY9EvQzpeYHQheV0HzySB29J8tCAwY2yXxvLDuIIK8VR-GK7D7_edk3VrEK69_srb');

//Deeplink Code
//Association

define('WEB_API_KEY', 'AIzaSyAbqgfl6GUIZc6Ovtxq8e05kKLo2NdFRRE');

define('ANDROID_PACKAGE_NAME', 'com.myassociation');

define('IOS_PACKAGE_NAME', 'com.myassociation');

define('DOMAIN_URL', 'https://dlapp.myassociation.app');

/*
//Credai Ahmedabad

define('WEB_API_KEY', 'AIzaSyATugdEovtPBUH6HD5az975_bFH8txTHVQ');

define('ANDROID_PACKAGE_NAME', 'com.credaiahmedabad');

define('IOS_PACKAGE_NAME', 'com.credaiahmedabad');

define('DOMAIN_URL', 'https://dlca.myassociation.app');


//Credai Hydrabad

define('WEB_API_KEY', 'AIzaSyAoZKT_mtobKeRIonB2cSjcagVIQixiW7M');

define('ANDROID_PACKAGE_NAME', 'com.credaihyderabad');

define('IOS_PACKAGE_NAME', 'com.credaihyderabad');

define('DOMAIN_URL', 'https://dlch.myassociation.app');


//Ifea Association

define('WEB_API_KEY', 'AIzaSyCGtRHm0lZ9JY9tLixVyBx08L6HwTsa18o');

define('ANDROID_PACKAGE_NAME', 'com.ifeaassociation');

define('IOS_PACKAGE_NAME', 'com.ifeaassociation');

define('DOMAIN_URL', 'https://dlfea.myassociation.app');


//HRM

define('WEB_API_KEY', 'AIzaSyBKzGzbfpWbIB7NhbGskLpHOej6izuqvXs');

define('ANDROID_PACKAGE_NAME', 'com.hrmilestone');

define('IOS_PACKAGE_NAME', 'com.hrmilestone');

define('DOMAIN_URL', 'https://dlhrm.myassociation.app');


//UBVP

define('WEB_API_KEY', 'AIzaSyBjopRVqk6KRkUrs9sId_wDmN7zeZxifHQ');

define('ANDROID_PACKAGE_NAME', 'com.ubvp');

define('IOS_PACKAGE_NAME', 'com.ubvp');

define('DOMAIN_URL', 'https://dlubvp.myassociation.app');


//FTCCI

define('WEB_API_KEY', 'AIzaSyBZa-LI_Ejo6z-lBmG5nNVhaFtP0gmjyWo');

define('ANDROID_PACKAGE_NAME', 'com.ftcci');

define('IOS_PACKAGE_NAME', 'com.ftcci');

define('DOMAIN_URL', 'https://dlftcci.myassociation.app');

//MCMA 

define('WEB_API_KEY', 'AIzaSyCKFISWOnGvYMkHaDxMHUBbjSECQmmiEeg');

define('ANDROID_PACKAGE_NAME', 'com.mcmaassociation');

define('IOS_PACKAGE_NAME', 'com.mcma');

define('DOMAIN_URL', 'https://dlmcma.myassociation.app');*/

class model
{
    private $ary;
    function set_data($name, $value)
    {
        $this->ary[$name]=$value;
    }
    function get_data($name)
    {
        return $this->ary[$name];
    }

    function base_url() {
        // $base_url="https://ahmedabad.fincasys.com/developer/";
        $base_url="http://".$_SERVER['SERVER_NAME']."/Survey_project/";
        return $base_url;
    }
    function api_key() {
        return "bmsapikey";
    }
    function membershipLastNameId($lastname,$society_id){
        include_once 'dao.php';
        $d = new dao();
        if($society_id==6){
            /**** For GHAA ****/
            $Lastname = substr($lastname, 0, 1);
            $query= $d->selectRow("max(cast(SUBSTRING(unit_name,2) AS UNSIGNED))","unit_master","society_id='$society_id' AND unit_name LIKE '$Lastname%'","ORDER BY unit_id DESC LIMIT 1");
            $row = mysqli_fetch_row($query);
            if($row != ''){
                $membership = $row[0];
                $numbers = preg_replace('/[^0-9]/', '', $membership);
                $final = (int)$numbers + 1;
                $finalno= $final;
                $memberships=strtoupper($Lastname.$finalno);
            }else{ $memberships = $Lastname.'1'; }
            return $memberships;
        }else if($society_id==1){
            $membershipPrefix = "HRM";
            $query= $d->selectRow("max(cast(SUBSTRING(unit_name,4) AS UNSIGNED))","unit_master","society_id='$society_id' AND unit_name LIKE '$membershipPrefix%'","ORDER BY unit_id DESC LIMIT 1");
            $row = mysqli_fetch_row($query);
            if($row != ''){
                $membership = $row[0];
                $numbers = preg_replace('/[^0-9]/', '', $membership);
                $final = (int)$numbers + 1;
                $finalno= $final;
                $memberships=strtoupper($membershipPrefix.$finalno);
            }else{ $memberships = $membershipPrefix.'1'; }
            return $memberships;
        }else if($society_id==24){
            $query= $d->selectRow("unit_name","unit_master","society_id='$society_id' AND unit_name!=''","ORDER BY INET_ATON(unit_name) DESC LIMIT 1");
            $row = mysqli_fetch_row($query);
            if($row != ''){
                $final = (int)$row[0] + 1;
                $memberships= $final;
            }else{ $memberships = 1; }
            return $memberships;
        }else{
            $query= $d->selectRow("max(cast(unit_name AS UNSIGNED))","unit_master","society_id='$society_id'","ORDER BY unit_id DESC LIMIT 1");
            $row = mysqli_fetch_row($query);
            if($row != ''){
                $membership = $row[0];
                $numbers = preg_replace('/[^0-9]/', '', $membership);
                $memberships = (int)$numbers + 1;
            }else{ $memberships = '1'; }
            return $memberships;
            /*$memberships = "";
            return $memberships;*/
        }
    }

    function request_society_mail()
    {
        $to_mail = "vivek@silverwingteam.com,ankit@silverwingteam.com,shivani@silverwingteam.com";
        return $to_mail;
    }

    function powered_by()
    {
        $powered_by = "SDB";
        return $powered_by;
    }
}
//for filter data

function test_input($data)
{
    // $data = trim($data);
    // $data = stripslashes($data);
    // $data = strip_tags($data);
    // $data = htmlspecialchars($data);
    return $data;

}
function custom_echo($x, $length)
{
  if(strlen($x)<=$length)
  {
    echo $x;
  }
  else
  {
    $y=substr($x,0,$length) . '...';
    echo $y;
  }
}

// count time 
function time_elapsed_string($datetime, $full = false) {
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' ago' : 'just now';
}


function imageResize($imageSrc,$imageWidth,$imageHeight,$newImageWidth,$newImageHeight) {

    $newImageLayer=imagecreatetruecolor($newImageWidth,$newImageHeight);
    imagecopyresampled($newImageLayer,$imageSrc,0,0,0,0,$newImageWidth,$newImageHeight,$imageWidth,$imageHeight);

    return $newImageLayer;
    // echo $newImageLayer;
}
?>