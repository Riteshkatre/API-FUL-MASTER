<?php

class sms_api
{    
   

    function send_otp($mobile,$otp,$country_code) {
        $msg = urlencode("<#> $otp is your OTP for My Association app verification.\nPlease do not share this OTP with anyone.\nThank you, CHPL Team.\nj74ibuhzdfo");

        if ($country_code=="+91") {
          $sms= file_get_contents("https://2factor.in/API/V1/2eb6de0f-3a58-11e9-8806-0200cd936042/SMS/$mobile/$otp/ASNOTP");
	return true;
        } 
    }

     function send_otp_admin($otp,$mobile,$society_name,$country_code) {
        $msg = urlencode("$otp is your OTP for $society_name Association Admin Panel Login.\nPlease do not share this OTP with anyone.\nThank You,\nCHPL Team by Dev server.");
         $appName=urlencode("Association Admin");
       if ($country_code=="+91") {
            // https://2factor.in/API/R1/?module=TRANS_SMS&apikey=2eb6de0f-3a58-11e9-8806-0200cd936042&to=$mobile&from=CHPLGP&templatename=CHPLOTP&var1=$otp&var2=Association Admin&var3=xUeaCNfJWeo
          $sms= file_get_contents("https://2factor.in/API/R1/?module=TRANS_SMS&apikey=2eb6de0f-3a58-11e9-8806-0200cd936042&to=$mobile&from=CHPLGP&templatename=CHPLOTP&var1=$otp&var2=$appName&var3=eR7Xv3F0Pax");

        } 
    }

    function send_otp_vendor($mobile,$otp,$country_code) {
        /*$msg = urlencode("$otp is your OTP for $society_name Association Admin Panel Login.\nPlease do not share this OTP with anyone.\nThank You,\nCHPL Team by Dev server.");*/
         $appName=urlencode("My Vendor");
         $smsAutoDetectKey=urlencode("yn2XP9IEW+k");
       if ($country_code=="+91") {
            // https://2factor.in/API/R1/?module=TRANS_SMS&apikey=2eb6de0f-3a58-11e9-8806-0200cd936042&to=$mobile&from=CHPLGP&templatename=CHPLOTP&var1=$otp&var2=Association Admin&var3=xUeaCNfJWeo
          $sms= file_get_contents("https://2factor.in/API/R1/?module=TRANS_SMS&apikey=2eb6de0f-3a58-11e9-8806-0200cd936042&to=$mobile&from=CHPLGP&templatename=CHPLOTP&var1=$otp&var2=$appName&var3=$smsAutoDetectKey");

        } 
    }

    
    function send_voice_otp($mobile,$otp,$country_code) {
       
       if ($country_code=="+91") {
        $sms= file_get_contents("https://2factor.in/API/V1/2eb6de0f-3a58-11e9-8806-0200cd936042/VOICE/$mobile/$otp");
       } else if ($country_code=="+234") {
           
       }
    }

   


    function send_welcome_message($society_id,$mobile,$receiver,$society,$country_code) {
        $society = html_entity_decode($society);
        $society=urlencode($society);
        $mobile=urlencode($mobile);
        $receiver=urlencode($receiver);
        if ($country_code=="+91") {

            // $sms= file_get_contents("https://2factor.in/API/R1/?module=TRANS_SMS&apikey=2eb6de0f-3a58-11e9-8806-0200cd936042&to=$mobile&from=CHPLGP&templatename=ASNWELCOMEUSER&var1=$receiver&var2=$society&var3=&var4=$mobile");
        } 

    }

    function send_welcome_message_admin($society_id,$receiver,$role,$society,$mobile,$email,$password,$login_url,$country_code) {
        $role = html_entity_decode($role);
        $society = html_entity_decode($society);
        $role=urlencode($role);
        $society=urlencode($society);
        $mobile=urlencode($mobile);
        $receiver=urlencode($receiver);
        if ($country_code=="+91") {

            // $sms= file_get_contents("https://2factor.in/API/R1/?module=TRANS_SMS&apikey=2eb6de0f-3a58-11e9-8806-0200cd936042&to=$mobile&from=CHPLGP&templatename=ASNWELCOMEADMINNOLINK&var1=$receiver&var2=$role&var3=$society&var4=$mobile&var5=$email&var6=$password");
        } 


    }

   

    function send_sms_password_reset($society_id,$receiver,$mobile,$url,$country_code) {
        $mobile=urlencode($mobile);
        $receiver=urlencode($receiver);
        $url=urlencode($url);
        if ($country_code=="+91") {

            // $sms= file_get_contents("https://2factor.in/API/R1/?module=TRANS_SMS&apikey=2eb6de0f-3a58-11e9-8806-0200cd936042&to=$mobile&from=CHPLGP&templatename=ASNOTADMINPASSRESET&var1=$receiver&var2=$url");
        }

    }

    function send_approval_message($society_id,$mobile,$receiver,$country_code) {
        $mobile=urlencode($mobile);
        $receiver=urlencode($receiver);
        if ($country_code=="+91") {

            // $sms= file_get_contents("https://2factor.in/API/R1/?module=TRANS_SMS&apikey=2eb6de0f-3a58-11e9-8806-0200cd936042&to=$mobile&from=CHPLGP&templatename=ASNMEMBERAPPROVAL&var1=$receiver&var2=$mobile");
        }
    }

    function send_vendor_msg($mobile,$country_code,$vendor_name,$user_name,$user_mobile) {
        $vendor_name = html_entity_decode($vendor_name);
        $user_name = html_entity_decode($user_name);
        $user_mobile = html_entity_decode($user_mobile);
        $vendor_name = urlencode($vendor_name);
        $user_name = urlencode($user_name);
        $user_mobile = urlencode($user_mobile);

        if ($country_code=="+91") {
          $sms= file_get_contents("https://2factor.in/API/R1/?module=TRANS_SMS&apikey=2eb6de0f-3a58-11e9-8806-0200cd936042&to=$mobile&from=CHPLGP&templatename=VENDOR_CALL_BACK&var1=$vendor_name&var2=$user_name&var3=$user_mobile");
          return true;
        } 
    }

    function send_otp_dealer($mobile,$otp,$country_code,$signature_key=null) {
        $appName=urlencode("Dealer");
        if($signature_key==null){
            $smsAutoDetectKey=urlencode("yn2XP9IEW+k");
        }else{ $smsAutoDetectKey=$signature_key; }
        if ($country_code=="+91") {
          $sms= file_get_contents("https://2factor.in/API/R1/?module=TRANS_SMS&apikey=2eb6de0f-3a58-11e9-8806-0200cd936042&to=$mobile&from=CHPLGP&templatename=CHPLOTP&var1=$otp&var2=$appName&var3=$smsAutoDetectKey");
        }
    }


}
?>