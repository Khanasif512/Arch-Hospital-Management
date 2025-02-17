<?php
/**
 * @author Sharif Ahmed
 * @copyright 2018
 */
if(isset($_GET["page"]) && !empty($_GET["page"])){
    
    $page = $_GET["page"];

    switch ($page) {
		case 'dashboard.php':
            $Page_Title = 'Dashboard';
            break;
        case 'witty-request.php':
            $Page_Title = 'Witty Request List';
            break;
        case 'new-request-witty.php':
            $Page_Title = 'Witty New Request';
            break;
        case 'witty-demo-view.php':
            $Page_Title = 'Details Witty Request';
            break;
        case 'witty-comments-details.php':
            $Page_Title = 'Witty Comment Details';
            break;
        case 'arch-request.php':
            $Page_Title = 'Arch Request List';
            break;
        case 'new-request-arch.php':
            $Page_Title = 'Arch New Request';
            break;
         case 'arch-demo-view.php':
            $Page_Title = 'Details Arch Request';
            break;
         case 'arch-comments-details.php':
            $Page_Title = 'Arch Comment Details';
            break;
        case 'campaign.php':
            $Page_Title = 'Campaign List';
            break;
        case 'campaign-sent-email.php':
            $Page_Title = 'Send Mail';
            break;
        case 'campaign-sent-email-list.php':
            $Page_Title = 'Sent E-Mail List';
            break;
        case 'request-report.php':
            $Page_Title = 'Request Report List';
            break;
        case 'comment-reports.php':
            $Page_Title = 'Comment Reports';
            break;
        case 'comment-lists.php':
            $Page_Title = 'Comment List';
            break;
        case 'campaign-sent-sms.php':
            $Page_Title = 'Send SMS';
            break;

        case 'sms-history.php':
            $Page_Title = 'SMS History / Report';
            break;
        case 'sms-report.php':
            $Page_Title = 'Date Based SMS Report';
            break;
        case 'add-user.php':
            $Page_Title = 'Add User';
            break;
        case 'user-profile.php':
            $Page_Title = 'User Profile';
            break;
        case 'user-list.php':
            $Page_Title = 'User List';
            break;
        case 'cam_email_template.php':
            $Page_Title = 'Email Template List';
            break;
        case 'status.php':
            $Page_Title = 'Status List';
            break;
		case 'status-report.php':
            $Page_Title = 'Status Report';
            break; 
        case 'followup-report.php':
            $Page_Title = 'Followup Report';
            break;

        case 'campaign_arch.php':
            $Page_Title = 'Arch Campaign List';
            break;
          case 'campaign_witty.php':
            $Page_Title = 'Witty Campaign List';
            break; 

         case 'sms-template.php':
            $Page_Title = 'SMS Template';
            break; 

         case 'sms-template-add.php':
            $Page_Title = 'SMS Template Add';
            break;
        case 'arch-web-info-view.php':
            $Page_Title = 'Web Profile Info Update';
            break;      	    
		default :
            $Page_Title = 'Esteem Sales/Marketing Admin Portal';    
    } 
}	else{
		$Page_Title = 'Esteem Sales/Marketing Admin Portal'; 
	}

?>
