<?php



/**

 * @author Sharif Ahmed

 * @copyright 2018

 */
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require_once("../main_function.php");
 // $BTSMS_API_URL ="http://www.btssms.com/miscapi/R20000535f93c2e22634e6.09775572/getBalance";
 // $BTSMS_API_USER = "R2000053";
 // $BTSMS_API_PASS = "Bw7tyMNXiH";

$SMS_API_URL = "http://powersms.banglaphone.net.bd/httpapi/sendsms";
$SMS_API_USER = "esteem";
$SMS_API_PASS = "98i5F$061lE";

// /////////////////////////////////////////////////////// E-Mail And SMS /////////////////////////////////////////////////

// function Send_Mail($mail_id,$to_name,$subject,$body){
//         //require_once('PHPMailer/PHPMailerAutoload.php');
//         require_once('PHPMailer/Exception.php');
//         require_once('PHPMailer/PHPMailer.php');
//         require_once('PHPMailer/SMTP.php');
// 		$from       = config::$EMAIL_FROM;
// 		$mail       = new PHPMailer(TRUE);
// 		$mail->IsSMTP(true);  // use SMTP
// 		$mail->IsHTML(true);
// 		$mail->SMTPAuth   = true;                 // enable SMTP authentication
// 		$mail->Host       = config::$EMAIL_HOST; // SMTP host
// 		$mail->Port       = config::$EMAIL_PORT;                    // set the SMTP port
// 		$mail->Username   = config::$EMAIL_USER;  // SMTP  username
// 		$mail->Password   = config::$EMAIL_PASS;  // SMTP password
// 		$mail->SMTPSecure = 'ssl';  
// 		$mail->SetFrom($from,config::$EMAIL_FROM);
// 		$mail->AddReplyTo($from,config::$EMAIL_FROM);
// 		$mail->Subject    = $subject;
// 		$mail->MsgHTML($body);
//    if (strpos($mail_id, ',') !== false) { // find if recepit has multiple mail using coma
//         $addresses = explode(',',$mail_id);
//                 foreach ($addresses as $address) {
//                     $mail->AddAddress(trim($address));
//                 }}else{
//             $mail->AddAddress($mail_id, $to_name);
//         }

// 		if($mail->Send())
// 		{
// 			$message = "1";
// 			return $message;
// 		}
// 		else 
// 		{ 
// 			$message= "0";
// 			return $message;
// 		}
// }  

    

    

function xmlEscape($string) {
    return str_replace(array('&', '<', '>', '\'', '"'), array('&amp;', '&lt;', '&gt;', '&apos;', '&quot;'), $string);

}

// Check if mobile number has 880 or if not then add 880.
function check_mobile_number($mobile_number){	

	$check_number = substr($mobile_number,0,3);
	if($check_number =="880" && strlen($mobile_number)==13) {
		return $mobile_number;
	}elseif((strlen($mobile_number)==11) && ($check_number =="017" OR $check_number =="019" OR $check_number =="018" OR $check_number =="016" OR $check_number =="015" OR $check_number =="013" OR $check_number =="014")) {

		return "88".$mobile_number;
	}else{
		return "false";
	}
}

/**
*@Return send SMS
 */    


function send_sms($text,$recipients,$post){ 
 $obj=new operation; //its only for esteem soft 
    
  global $flash,$SMS_API_URL,$SMS_API_USER,$SMS_API_PASS;
    $url = $SMS_API_URL;
  $message_sent_ok =false;

    /*sms vendor id 1= mir telecom, 2= banglaphone, 3=route mobile*/
    $SMS_VENDOR =3; // is_setting_session("SMS_VENDOR_ID");
    // 1=mir telecom
    if($SMS_VENDOR=='1'){    
    $message_sent_ok = sms_send_by_mirtelecom($text,$recipients);
     // 2= banglaphone
    }elseif($SMS_VENDOR=='2'){ // IF Mirtelecom doesn't have enough balance then use banglaphone getway
    $ck=0; //$ck = 0 means okay, $ck=1 means Break, and return error, its for prevent error loop 
    $message_sent_ok = sms_send_by_Banglaphone($text,$recipients,$ck);
   //3=route mobile
    }else{
    $message_sent_ok = sms_send_by_routemobile($text,$recipients);
    }

  // IF Mirtelecom doesn't have enough balance then use banglaphone getway

//global $db,$time;
    $count = sms_counter($text); // count number of sms
    $text = $text;
    $time=date("Y-m-d H:i:s");
       if($message_sent_ok){ 

  if (is_array($recipients)) {
    $arrlength = count($recipients);
        if(isset($post["profileID"])){
        $profileID=$post["profileID"];
       foreach ($post['mobileNumbers'] as $key => $req_mobile) {
        $reqMobile= check_mobile_number($req_mobile);

      if(in_array($reqMobile, $recipients)){
        $data= array(
            "uhid"=>$profileID,
            "number"=>$reqMobile,
            "text"=>$text,
            "qty"=>$count,
            "date"=>$time,
            "type"=>$post['type'],
            "userID" =>$_SESSION['user_id']);
        
         QB::table('sms_history')->insert($data);
      }    

    }

  }else{
    foreach ($post['req_id'] as $key => $req_mobile) {
      $reqMobile= check_mobile_number($req_mobile['mobile']);
      if(in_array($reqMobile, $recipients)){
        $data= array(
            "uhid"=>$key,
            "number"=>$reqMobile,
            "text"=>$text,
            "qty"=>$count,
            "date"=>$time,
            "type"=>$post['type'],
            "userID" =>$_SESSION['user_id']
            );
         QB::table('sms_history')->insert($data);
      }
    }
  }
      }else{

        $data= array(
                "uhid"=>'0',
                "number"=>$recipients,
                "text"=>$text,
                "qty"=>$count,
                "date"=>$time,
                "type"=>2,//2=arch 
                "userID" =>$_SESSION['user_id']
                );
         QB::table('sms_history')->insert($data);
       }

   
 return true;
}else{
  $error ='SMS Not Send. Please contact Software Support Team';
     echo"<script> window.location.replace('campaign-sent-sms.php?error=$error&msg=$success');</script>";
  }

}


/**

 * @param token array

 * @param sms sending type 1=patient receipt.2=admin,3=patient due

 * @param mobile number 

 * @param template from template table

 * @param text content optional to overwrite template content

 */

function send_sms_auto($token,$type,$cellNumber,$temp=null,$text=NULL){

     

        global $db,$time;   



        $recipient = array();

        if(check_mobile_number($cellNumber)!="false"){

            $recipient[] = check_mobile_number($cellNumber);

        }

  

        if(empty($text)){

         $content = $db->result_one("SELECT value FROM `settings` WHERE name='{$temp}' LIMIT 1")->value;

         $pattern = '[%s]';  

         foreach($token as $key=>$val){  

           $repVar[sprintf($pattern,$key)] = $val;  

         }  

         $text = strtr($content,$repVar); 

        }  

        if(isset($recipient)){

            send_sms($text,$recipient,$type); 

        }              

}

/**

*@Return count number of SMS

 */

function sms_counter($text){    

    return SMSCounter::count($text)->messages;                       

}


function sms_send_by_mirtelecom($text,$recipients){

    global $flash;
    $message_sent_ok = false;
    $mirsenderArray = array("8809601001655","8809601001655");
    if(is_array($recipients)){                       
    $arrlength = count($recipients);
    $recipient="";

    for($x = 0; $x < $arrlength; $x++) {
      $recipient = $recipients[$x].",".$recipient;
      }
        }else{
    $recipient = $recipients;
      }      

        $mir_username = "34434343";
        /*$mir_password = "12345678"; */
        $mir_password = '344343';
        $port="3434";
        $senderID ="34434343";// is_setting_session("SMS_SENDER_ID");

        if(in_array($senderID,$mirsenderArray)){
           $senderID = $senderID; 
        }else{
           $senderID = $mirsenderArray[0];  
        }

        $btssms_url ="test";  
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$btssms_url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_POST, 1);
        // curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $response_str = curl_exec($ch);
     
        if(is_string($response_str)){
       $response_array = explode("|",$response_str);
       $response = $response_array[0];
        }else{
      $response = $response_str;
            }        
          
        if($response=='1701'){ //1701 means success              
            $message_sent_ok = true;
        if (!$flash->hasMessages($flash::SUCCESS)) {
             $flash->success("SMS has been sent successfully!!!");
            }
             curl_close($ch);
             return $message_sent_ok;
             
        }else{ // if SMS sending failed/error for mir telecom then use routemobile             
      return $message_sent_ok =  sms_send_by_routemobile($text,$recipients);   
        }

}


function sms_send_by_Banglaphone($text,$recipients,$ck){
    global $flash,$SMS_API_URL,$SMS_API_USER,$SMS_API_PASS;
        $url = $SMS_API_URL;
        $message_sent_ok = false;

    if (is_array($recipients)) {
        $arrlength = count($recipients);
        $recipient="";

        for($x = 0; $x < $arrlength; $x++) {
            $recipient = $recipients[$x].",".$recipient;
        }
        }else{
            $recipient = $recipients;
        }
        
        $fields = array(
                        'userId' => urlencode($SMS_API_USER),
                        'password' => urlencode($SMS_API_PASS),
                        'smsText' => urlencode($text),
                        'commaSeperatedReceiverNumbers' => $recipient
                        );

 
        $fields_string = "";
        foreach($fields as $key=>$value){ 
            $fields_string .= $key.'='.$value.'&'; 
        }
                        
        rtrim($fields_string, '&');

        $ch = curl_init();
            curl_setopt($ch,CURLOPT_URL, $url);            
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($ch, CURLOPT_POST, count($fields));
            curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_FAILONERROR, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);            
        $result = curl_exec($ch);
             
        if($result === false){   
            // $message_sent_ok = false; 
            $flash->error('%s CURL error: '.curl_error($ch));
                    curl_close($ch);
             if(!empty($ck)){ //checking its come from route mobile with error also find error in banglaphone thats why return
             return $message_sent_ok;
             }else{
            return sms_send_by_routemobile($text,$recipients);
           }
        } 

        $json_result = json_decode($result);            
        if($json_result->isError){
        // $message_sent_ok = false;
        $flash->error("ERROR: %s ".$json_result->message);
                curl_close($ch);

        if(!empty($ck)){ //checking its come from route mobile with error also find error in banglaphone thats why return 
             return $message_sent_ok;
             }else{ // if SMS sending failed/error for Banglaphone then use route mobile
             return sms_send_by_routemobile($text,$recipients);
           }}else{
        $message_sent_ok = true;
        if (!$flash->hasMessages($flash::SUCCESS)) {
                $flash->success("SMS has been sent successfully!!!");
            }
        }

        curl_close($ch);
        return $message_sent_ok;

}


function sms_send_by_routemobile($text,$recipients){

    global $flash;
    $message_sent_ok = false;  
    $routesenderArray = array("8809617611130","8809617611131","8809617611132","8809617611133","8809617611134","8809617611135","8809617611136","8809617611137","8809617611138");  
    if(is_array($recipients)){                       
        $arrlength = count($recipients);
        $recipient="";                     
        for($x = 0; $x < $arrlength; $x++) {
            $recipient = $recipients[$x].",".$recipient;
        }
        }else{
            $recipient = $recipients;
        }

        $mobile_username = "EsteemSoft";
        $mobile_password = "c3eqrDQ0";
        $senderID = "8809617611130";//is_setting_session("SMS_SENDER_ID");      
        
        if(in_array($senderID,$routesenderArray)){
           $senderID = $senderID; 
        }else{
           $senderID = $routesenderArray[0];  
        }

        $btssms_url ="http://apibd.rmlconnect.net/bulksms/personalizedbulksms?username=".urlencode($mobile_username)."&password=".urlencode($mobile_password)."&source=".urlencode($senderID)."&destination=".urlencode($recipient)."&message=".urlencode($text);  

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$btssms_url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_POST, 1);
        // curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $response_str = curl_exec($ch);

        if(is_string($response_str)){
            $response_array = explode("|",$response_str);
            $response = $response_array[0];
            }else{
            $response = $response_str;
        }        
          
        if($response=='1701'){ //1701 means success                 
             $message_sent_ok = true;
             if(!$flash->hasMessages($flash::SUCCESS)) {
                 $flash->success("SMS has been sent successfully!!!");
             }
             curl_close($ch);
             return $message_sent_ok;                 
         }else{ // if SMS sending failed/error for route mobile then use Banglaphone  
         $ck=1;               
          return $message_sent_ok = sms_send_by_Banglaphone($text,$recipients,$ck);   
         } 
}




//Find number of SMS sent in certain date and type



function sms_today_report($from_date,$to_date,$type,$limits){

    global $db;

    $from_date = empty($from_date) ?  NULL : $from_date." 00:00:00"; 

    $to_date = empty($to_date) ?  NULL : $to_date." 23:59:59";  

    $statement = " sms_history WHERE `type`='$type' "; 

    empty($from_date) ? NULL : $statement .= " AND (date BETWEEN '$from_date' AND '$to_date') ";    

    $qty= QB::query("SELECT SUM(qty) AS qty FROM {$statement} ORDER BY id DESC LIMIT $limits")->first();

    return $qty->qty;

    // return $db->result_one("SELECT SUM(qty) AS qty FROM {$statement} ORDER BY id DESC LIMIT $limits")->qty;

}

// Return SMS type

function return_sms_type($type){  

    switch ($type) {

       case 1: return "Payment";

       case 2: return "Absent";

       case 3: return "Due";

	    case 4: return "Result";

	    case 5: return "Present";

       case 7: return "Notice";

    }    

}



function absent_sms(){

       

}



/**

@ author https://github.com/acpmasquerade/sms-counter-php 

*/

class SMSCounter{



  # character set for GSM 7 Bit charset

  # @deprecated

  const gsm_7bit_chars = "@�\$�������\n��\r��?_FG?O??ST?���� !\"#�%&'()*+,-./0123456789:;<=>?�ABCDEFGHIJKLMNOPQRSTUVWXYZ���ܧ�abcdefghijklmnopqrstuvwxyz�����";

  

  # character set for GSM 7 Bit charset (each character takes two length)

  # @deprecated

  const gsm_7bitEx_chars = "\\^{}\\\\\\�[~\\]\\|";



  const GSM_7BIT = 'GSM_7BIT';

  const GSM_7BIT_EX = 'GSM_7BIT_EX';

  const UTF16 = 'UTF16';



  public static function int_gsm_7bit_map(){

    return array(10,13,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,

      51,52,53,54,55,56,57,58,59,60,61,62,63,64,65,66,67,68,69,70,

      71,72,73,74,75,76,77,78,79,80,81,82,83,84,85,86,87,88,89,90,

      92,95,97,98,99,100,101,102,103,104,105,106,107,108,109,110,

      111,112,113,114,115,116,117,118,119,120,121,122,

      161,163,164,165,191,196,197,198,199,201,209,214,

      216,220,223,224,228,229,230,232,233,236,241,242,

      246,248,249,252,915,916,920,923,926,928,931,934,

      936,937);

  }



  public static function int_gsm_7bit_ex_map(){

    return array(91,92,93,94,123,124,125,126,8364);

  }



  public static function int_gsm_7bit_combined_map(){

    return array_merge(self::int_gsm_7bit_map(), self::int_gsm_7bit_ex_map());

  }



  # message length for GSM 7 Bit charset

  const messageLength_GSM_7BIT = 160;

  # message length for GSM 7 Bit charset with extended characters

  const messageLength_GSM_7BIT_EX = 160;

  # message length for UTF16 charset

  const messageLength_UTF16 = 70;



  # message length for multipart message in GSM 7 Bit encoding

  const multiMessageLength_GSM_7BIT = 153;

  # message length for multipart message in GSM 7 Bit encoding with extended characters

  const multiMessageLength_GSM_7BIT_EX = 153;

  # message length for multipart message in UTF16 encoding

  const multiMessageLength_UTF16 = 67;



  /**

   * function count($text)

   * Detects the encoding, Counts the characters, message length, remaining characters

   * @return - stdClass Object with params encoding,length,per_message,remaining,messages

   */

  public static function count($text){



    $unicode_array = self::utf8_to_unicode($text);



    # variable to catch if any ex chars while encoding detection.

    $ex_chars = array();

    $encoding = self::detect_encoding($unicode_array, $ex_chars);



    if ($encoding === self::UTF16) {



      $length = 0;



      foreach($unicode_array as $uc) {



        // UTF-16 stores most characters as two bytes,

        // but it can only store 0xFFFF (= 65535) characters this way.

        // Characters above that number are stored as four bytes and

        // therefore need to count as 2 in length in a text message.

        $length += ($uc > 65535) ? 2 : 1;



      }



    } else {

      $length = count($unicode_array);



      if ( $encoding === self::GSM_7BIT_EX){

        $length_exchars = count($ex_chars);

        # Each exchar in the GSM 7 Bit encoding takes one more space

        # Hence the length increases by one char for each of those Ex chars. 

        $length += $length_exchars;

      }

    }    



    # Select the per message length according to encoding and the message length

    switch($encoding){

      case self::GSM_7BIT:

      if ( $length > self::messageLength_GSM_7BIT){

        $per_message = self::multiMessageLength_GSM_7BIT;

      }else{

        $per_message = self::messageLength_GSM_7BIT;

      }

      break;



      case self::GSM_7BIT_EX:

      if ( $length > self::messageLength_GSM_7BIT_EX){

        $per_message = self::multiMessageLength_GSM_7BIT_EX;

      }else{

        $per_message = self::messageLength_GSM_7BIT_EX;

      }

      break;



      default:

      if($length > self::messageLength_UTF16){

        $per_message = self::multiMessageLength_UTF16;

      }else{

        $per_message = self::messageLength_UTF16;

      }

      break;

    }



    $messages = ceil($length / $per_message);

    $remaining = ( $per_message * $messages ) - $length;



    $returnset = new stdClass();



    $returnset->encoding = $encoding;

    $returnset->length = $length;

    $returnset->per_message = $per_message;

    $returnset->remaining = $remaining;

    $returnset->messages = $messages;



    return $returnset;



  }



  /** 

   * function detect_encoding($text)

   * Detects the encoding of a particular text

   * @return - one of GSM_7BIT, GSM_7BIT_EX, UTF16

   */

  public static function detect_encoding ($text, & $ex_chars) {



    if(!is_array($text)){

      $text = utf8_to_unicode($text);

    }



    $utf16_chars = array_diff($text, self::int_gsm_7bit_combined_map());



    if(count($utf16_chars)){

      return self::UTF16;

    }



    $ex_chars = array_intersect($text, self::int_gsm_7bit_ex_map());



    if(count($ex_chars)){

      return self::GSM_7BIT_EX;

    }else{

      return self::GSM_7BIT;

    }



  }



  /**

   * function utf8_to_unicode ($str)

   * Generates array of unicode points for the utf8 string

   * @return array

   */

  public static function utf8_to_unicode( $str ) {



    $unicode = array();        

    $values = array();

    $looking_for = 1;



    for ($i = 0; $i < strlen( $str ); $i++ ) {



      $this_value = ord( $str[ $i ] );



      if ( $this_value < 128 ) {

       

        $unicode[] = $this_value;

      

      } else {



        if ( count( $values ) == 0 ) {

        

          if ($this_value < 224) {

            $looking_for = 2;  

          } else if ($this_value < 240) {

            $looking_for = 3;

          } else if ($this_value < 248) {

            $looking_for = 4;

          }

     

        }



        $values[] = $this_value;



        if ( count( $values ) == $looking_for ) {



          if ($looking_for == 4) {

        

            $number = ( ( $values[0] % 8 ) * 262144 ) + 

                      ( ( $values[1] % 64 ) * 4096 ) + 

                      ( ( $values[2] % 64 ) * 64 ) + 

                      ( $values[3] % 64 );

        

          } else if ($looking_for == 3) {



            $number = ( ( $values[0] % 16 ) * 4096 ) + 

                      ( ( $values[1] % 64 ) * 64 ) + 

                      ( $values[2] % 64 );

          

          } else if ($looking_for == 2) {

          

            $number = ( ( $values[0] % 32 ) * 64 ) + 

                      ( $values[1] % 64 );

          

          }



          $unicode[] = $number;

          $values = array();

          $looking_for = 1;



                } # if



            } # if

            

        } # for



        return $unicode;



    } # utf8_to_unicode



    /**

     * unicode equivalent chr() function

     * @return character

     */

    public static function utf8_chr($unicode){

      $unicode=intval($unicode);



      if($unicode<128){

        $utf8char=chr($unicode);

      }

      else if ($unicode >= 128 && $unicode < 2048){

        $utf8char = chr(192 | ($unicode >> 6)) . chr(128 | ($unicode & 0x3F));

      }

      else if ($unicode >= 2048 && $unicode < 65536){

        $utf8char = chr(224 | ($unicode >> 12)) . chr(128 | (($unicode >> 6) & 0x3F)) . chr(128 | ($unicode & 0x3F));

      }

      else{

        $utf8char = chr(240 | ($unicode >> 18)) . chr(128 | (($unicode >> 12) & 0x3F)) . chr(128 | (($unicode >> 6) & 0x3F)) . chr(128 | ($unicode & 0x3F));

      }



      return $utf8char;

    }



    /**

     * Converts unicode code points array to a utf8 str

     * @param $array - unicode codepoints array

     * @return $str - utf8 string

     */

    public static function unicode_to_utf8($array){

      $str = '';

      foreach($array as $a){

        $str .= self::utf8_chr($a);

      }



      return $str;

    }



    /**

     * Removes non GSM characters from a string

     * @return string

     */

    public static function remove_non_gsm_chars( $str ){

      # replace non gsm chars with a null character

      return self::replace_non_gsm_chars($str, null);

    }



    /**

     * Replaces non GSM characters from a string

     * @param $str - string to be replaced 

     * @param $replacement - character to be replaced with 

     * @return string

     * @return false, if replacement string is more than 1 character in length

     */

    public static function replace_non_gsm_chars( $str , $replacement = null){



      $valid_chars = self::int_gsm_7bit_combined_map();



      $all_chars = self::utf8_to_unicode($str);



      if(strlen($replacement) > 1){

        return FALSE;

      }



      $replacement_array = array();

      $unicode_arr = self::utf8_to_unicode($replacement);

      $replacement_unicode = array_pop($unicode_arr);



      foreach($all_chars as $some_position=>$some_char){

        if(!in_array($some_char, $valid_chars)){

          $replacement_array[] = $some_position;

        }

      }



      if($replacement){

        foreach($replacement_array as $some_position){

          $all_chars[$some_position] = $replacement_unicode;

        }

      }else{

        foreach($replacement_array as $some_position){

          unset($all_chars[$some_position]);

        }

      }



      return self::unicode_to_utf8($all_chars);

    }

  }





    function get_content($URL){

      $ch = curl_init();

      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

      curl_setopt($ch, CURLOPT_URL, $URL);

      $data = curl_exec($ch);

      curl_close($ch);

      return $data;

    }

?>