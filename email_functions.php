<?php

defined('ADMIN_MAIL')   ? null : define("ADMIN_MAIL", "winsharif@gmail.com");
defined('CC_MAIL')   ? null : define("CC_MAIL", "tutulb21@gmail.com");

date_default_timezone_set('Asia/Dhaka');

function Send_Mail($mail_id,$to_name,$subject,$body){
		require_once('class/PHPMailer/PHPMailerAutoload.php');
		$from       = "winesteem@gmail.com";
		$mail       = new PHPMailer();
		$mail ->charSet = "UTF-8"; 
		$mail->IsSMTP(true);            // use SMTP
		$mail->IsHTML(true);
		$mail->SMTPAuth   = true;                  // enable SMTP authentication
		$mail->Host       = "smtp.gmail.com"; // SMTP host
		$mail->Port       =  465;                    // set the SMTP port
		$mail->Username   = "winesteem@gmail.com";  // SMTP  username
		$mail->Password   = 'e$teem007';  // SMTP password sj7Ik1@G3-45 
		$mail->SMTPSecure = 'ssl';  
		$mail->SetFrom($from, 'Esteem Soft Limited');
		$mail->AddReplyTo($from,'Esteem Soft Limited');
		$mail->Subject    = $subject;
		$mail->MsgHTML($body);
		$mail->AddAddress($mail_id, $to_name);
		if($mail->Send())
		{
			$message = "1";
			return $message;
		}
		else 
		{ 
			$message= "0"; 
			return $message;
		}
}

function send_message($msubject,$fname,$email,$pnumber,$message){
    
            $time= date('m/d/Y h:i:s a', time());
            
            $usermailBody = '
            <html>
            <head>
                <title>Welcome to Esteem Soft Limited</title>
            </head>
            <body>
				<div style="background: #efefef; width: 70%; padding: 50px 0; margin: 0 auto;">
					<div style="width: 90%; margin: 0 auto;">
						<h3 style="background: #ee7433; padding: 20px 0; color: #fff; font-size: 20px; text-align: center; margin: 0;">Thank you for contacting us</h3>
						<table cellspacing="0" style="width:100%;height:100%">
							<tbody>
								<tr>
									<td>
										<div style="background-color:#fff; padding: 30px 20px;">										
											<h5 style="font-size: 18px;">Dear '.$fname.',</h5>
											<p>Thank you for your '.$msubject.'. One of our team members will be in touch with you shortly.</p>
											<p>You can also directly call us at phone number: +88018 4400 4911.</p>
											<p>Website : <a href="https://esteemsoftbd.com/" target="_blank">esteemsoftbd.com/</a></p>
											<p style="margin-top: 60px;">Sales Team,</p>
											<p style="color: #ee7433;font-size: 14px;"><b>Esteem Soft Limited</b></p>
										</div>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
            </body>
            </html>';
            
            $adminMailBody = '
            <html>
            <head>
                <title>'.$msubject.' from Website</title>
            </head>
            <body>
				<div style="background: #efefef; width: 70%; padding: 50px 0; margin: 0 auto;">
					<div style="width: 90%; margin: 0 auto;">
						<h3 style="background: #ee7433; padding: 20px 0; color: #fff; font-size: 20px; text-align: center; margin: 0;">'.$msubject.' from '.$fname.'.</h3>
						<table cellspacing="0" style="width:100%;height:100%">
							<tbody>
								<tr>
									<td>
										<div style="background-color:#fff; padding: 30px 20px;">										
											<h5 style="font-size: 18px;">Dear Admin,</h5>
											<p>'.$msubject.' from Esteem Soft Website.</p>
											<p>Subject : '.$msubject.'</p>
											<p>Name : '.$fname.'</p>
											<p>Email : '.$email.'</p>
											<p>Mobile : '.$pnumber.'</p>										
											<p>Message : '.$message.'</p>										
											<p>Request On : '.$time.'</p>
										</div>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
            </body>
            </html>';
    
    Send_Mail($email,"Esteem Soft Limited","Thank you for contacting Esteem Soft Limited",$usermailBody);   
    Send_Mail(CC_MAIL,"Esteem Soft Limited Website","".$msubject." from ".$fname."",$adminMailBody); 
    Send_Mail("mkt@esteemsoftbd.com","Esteem Soft Limited Website","".$msubject." from ".$fname."",$adminMailBody);    
    $mail_response =  Send_Mail(ADMIN_MAIL,"Esteem Soft Limited Website","".$msubject." from ".$fname."",$adminMailBody);        
           
    if($mail_response){ 
    			return "1";
    } else {
    		return '0';
    }  	
} 


?>