<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

date_default_timezone_set('Asia/Dhaka');
require_once("../main_function.php");


function get_email_password($email){

	switch ($email) {
		case 'esteemsoft.mkt@gmail.com':
			return 'sfjihpqnqoiqbwoc';
			break;
		case 'esteemcampaign@gmail.com':
			return 'dmpycmdfamsruhgi';
			break;
		case 'esteemcampaign1@gmail.com':
			return 'rnotdtezyydbpdrd';
			break;
		case 'esteemcampaign2@gmail.com':
			return 'wflxithgfzvcphzt';
			break;
		case 'esteemcampaign3@gmail.com':
			return 'ataoxfyuafiqaost';
			break;
		case 'esteemcampaign4@gmail.com':
			return 'mqpqkonxuqtyjdgu';
			break;
		case 'esteemcampaign5@gmail.com':
			return 'kjcctmqtlypwwerd';
			break;
	    case 'esteemcampaign6@gmail.com':
			return 'nfcrqmmozsitbwds';
			break;
    	case 'esteemcampaign7@gmail.com':
			return 'qjdoqsjxctodwzvu';
			break;		
		
		default:
			break;
	}
}



function Send_Mail($mail_id,$to_name,$subject,$body,$cc_mail,$bcc_mails,$files=null,$sendByEmail=null){

		require_once('class/PHPMailer/Exception.php');
        require_once('class/PHPMailer/PHPMailer.php');
        require_once('class/PHPMailer/SMTP.php');
		
		$replaTo="esteemsoft.mkt@gmail.com";
	  if(empty($sendByEmail)){
        	$sendByEmail="esteemcampaign1@gmail.com";
        }
      
		$from =$sendByEmail;
		$mail = new PHPMailer(true);
		$mail->isSMTP(true);           // use SMTP		
		$mail->CharSet = "UTF-8";
        $mail->Encoding = "base64";	
		$mail->Host       = "smtp.gmail.com"; // SMTP host	  
		$mail->SMTPSecure = 'SSL'; // set the SMTP port ssl	
		$mail->SMTPAuth   = true;   // enable SMTP authentication
		/*$mail->SMTPDebug = 3;*/

		$mail->Username   = $sendByEmail;  // SMTP  username
		$mail->Password   = get_email_password($sendByEmail);  // SMTP password sj7Ik1@G3-45 'esteem2011'
		//$mail->Password   = 'esteem2011';  // SMTP password sj7Ik1@G3-45 'esteem2011'
	    $mail->Port       = "587";  // set the SMTP port465

    	$mail->SMTPOptions = array(
						'ssl' => array(
						'verify_peer' => false,
						'verify_peer_name' => false,
						'allow_self_signed' => true
						)
					);

		$mail->SetFrom($from,"Esteem Soft Limited");
		$mail->AddAddress($mail_id, $to_name);	
		$mail->AddReplyTo($replaTo,"Esteem Soft Limited");	


       if(!empty($cc_mail)){
	  	foreach($cc_mail as $key => $cc_email) {
	         if(checkEmail(trim($cc_email))){         	
	          	// $scc_mails.=$cc_email.","." "; 
	           $mail->AddCC($cc_email);    	                
	           }         	
            }
        }

        if(!empty($bcc_mails)){
 	  	foreach($bcc_mails as $key => $bcc_email) {	           
	       $mail->AddBCC($bcc_email);            	
            } 
        }

		if(!empty($files)){ 
		  foreach ($files as $key => $file) {
   	 		if(!empty($file)){
   	 			$filepath="assets/img/email_img/".$file; 
              $mail->addAttachment($filepath); 
         	 }
      	} 
		}
         
		

     	$mail->IsHTML(true);
     	
		$mail->Subject    = $subject;
		$mail->MsgHTML($body);

 		if(!$mail->send()){ 
 		     
 		return "Mailer Error: " . $mail->ErrorInfo;
			
		   }else{ 
			
			return 1;
		
		}
}




function send_single_email($post,$type,$attached){  
	     $obj=new operation;
	     /* $sendByEmail=$obj->get_setting("CHOOSING_EMAIL_FOR_SEND_EMAIL");*/
         if($type==1){
           $institute= $obj->detailsWityclientRequest($post["institute"]);
           }

         if($type==2){
       	   $institute=$obj->detailsarchclientRequest($post["institute"]);
          }

         $to_mail=$institute->email; 
         $client_name=$institute->name; 


          $company_mails=array();
          $i=0;
         if(isset($post['company_mail'])){
	     foreach ($post['company_mail'] as $key => $value) {
	    	     $company_mail = return_company_email($value);
	             // $company_mails.=$company_mail.","." ";
	             $company_mails[]=$company_mail;
	           }
	       }
	           

           if(isset($post["cc_mail"])){
		       $cc_mails = $post["cc_mail"];		  
              if(!is_array($cc_mails)){
             	$cc_mail = explode(',', $cc_mails); 
              }else{
              	$cc_mail=$cc_mails;
              } 
             }else{
         	 $cc_mail='';
             }
	
	
		// $scc_mails="";       
		// foreach($cc_mail as $key => $cc_email) {
		//  if(checkEmail(trim($cc_email))){         	
		//   	$scc_mails.=$cc_email.","." ";                 
		//    }         	
		//    }

         $subject=$post['subject'];
         $main_body=$post['body'];
         $sendByEmail='esteemsoft.mkt@gmail.com';
         /*$sendByEmail=$obj->get_setting("CHOOSING_EMAIL_FOR_SEND_EMAIL");*/
         // $time= date('m/d/Y h:i:s a', time());          		
		 $mail_response=Send_Mail($to_mail,$client_name,$subject,$main_body,$cc_mail,$company_mails,$attached,$sendByEmail);   
		// Send_Mail($scc_mails,"Arch Website",$subject,$main_body);     
		// Send_Mail($company_mails,"Arch Website","Arch Demo Request From ".$fname."",$adminMailBody);     
		// $mail_response =  Send_Mail(ADMIN_MAIL,"Arch Website",$subject,$main_body);        
           
			if($mail_response){ 
				return "1";
			
			   } else {
				return '0';
			}  	
 	
}

function send_campaign_email($post,$type,$attached){  
	      $obj=new operation;
	       $sendByEmail=$obj->get_setting("CHOOSING_EMAIL_FOR_SEND_EMAIL");
	      $req_campaign_email=array();
         $campaign_req = QB::table('campaign_list')->where('camp_id','=',$post['campaign'])->get(); 

        if(!empty($campaign_req)){
        foreach ($campaign_req as $key => $requision_id) {
       	   if($type==1){
           $institute= $obj->detailsWityclientRequest($requision_id->req_id);
           $req_campaign_email[]=$institute->email;
           }

         if($type==2){
       	   $institute=$obj->detailsarchclientRequest($requision_id->req_id);
       	   $req_campaign_email[]=$institute->email;
          }
         
       }
   }  

   
               $company_mails=array();
               if(isset($post['company_mail'])){
                 		$i=0;
		           	foreach ($post['company_mail'] as $key => $value) {
		    	     	$company_mail = return_company_email($value);
		             	// $company_mails.=$company_mail.","." ";
		            	 $company_mails[]=$company_mail;
		          	}
               }
               
            if(isset($post["cc_mail"])){
		     $cc_mails = $post["cc_mail"];		  
             if(!is_array($cc_mails)){
             $cc_mail = explode(',', $cc_mails); 
              }else{
              	$cc_mail=$cc_mails;
              }   
               }else{
         	$cc_mail='';
            }

         $bcc_email=array_merge($req_campaign_email,$company_mails);  
           
 
         $subject=$post['subject'];
         $main_body=$post['body'];
         $to_mail="esteemsoft.mkt@gmail.com";
         $client_name="Esteem Soft Limited";
         // $time= date('m/d/Y h:i:s a', time());          		
		 $mail_response=Send_Mail($to_mail,$client_name,$subject,$main_body,$cc_mail,$bcc_email,$attached,$sendByEmail);   
		// Send_Mail($scc_mails,"Arch Website",$subject,$main_body);     
		// Send_Mail($company_mails,"Arch Website","Arch Demo Request From ".$fname."",$adminMailBody);     
		// $mail_response =  Send_Mail(ADMIN_MAIL,"Arch Website",$subject,$main_body);        
           
			if($mail_response){ 
				return "1";
			
			   } else {
				return '0';
			}  	
 	
}


 function checkEmail($email) {
         // $find1 = strpos($email, '@');
         // $find2 = strpos($email, '.');
         // return ($find1 !== false && $find2 !== false && $find2 > $find1);
         // return (boolean) filter_var($email, FILTER_VALIDATE_EMAIL);
     if (!preg_match("/^([a-zA-Z0-9\._-])+([a-zA-Z0-9\._-] )*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/" , $email)){
          return false;
     }
     return true;
}





?>