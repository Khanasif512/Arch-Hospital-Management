<?php 
require_once("../main_function.php");
require_once("class/organization.php");
$org=new Organization;
$obj=new operation;

if(!empty($_POST['sofType_id'])){
       $type_id=$_POST['sofType_id'];
       $campaign= $obj->get_all_campagin_type($type_id);
       if(!empty($campaign)){
        echo '<option value="">Select Campaign</option>';
       foreach($campaign as $camp){
            echo '<option value="'.$camp->id.'">'.$camp->camp_name.'</option>';
        }
    }else{
        echo '<option value="">Campaign not available</option>';
    }
}

if(!empty($_POST['sofType_sms'])){
       $type_id=$_POST['sofType_sms'];
       $smsTemplate= $org->get_all_temp_type_wise($type_id);
       if(!empty($smsTemplate)){
        echo '<option value="">Select SMS Template</option>';
       foreach($smsTemplate as $smsTemp){
            echo '<option value="'.$smsTemp->id.'">'.$smsTemp->name.'</option>';
        }
    }else{
        echo '<option value="">Template not available</option>';
    }
}

if(!empty($_POST['tempSmsId'])){
       $smsTemp_id=$_POST['tempSmsId'];
       $smsTemplate= $org->get_single_sms_temp($smsTemp_id);
       if(!empty($smsTemplate)){
         echo $smsTemplate->message;
    }
}
?>
