<?php
require_once("../main_function.php");
require_once("sms.php");
require_once("class/organization.php");
$org=new Organization;
$obj=new operation;


if(isset($_GET['id'])){
$result=$obj->detailsarchclientRequest($_GET['id']);
$latestfivesms=$obj->witty_latest_five($_GET['id'],2); //2=arch
$latestfiveemail=$obj->email_latest_five($_GET['id'],2); //2=arch
$comment=$obj->arch_last_five_comments($_GET['id']);
$campaigns=$obj->assign_getCampaign((int)$result->id,2); //2=arch
$campaignList=$obj->get_all_campagin_type(2); //2=arch
$documents=$obj->get_all_documents($_GET['id'],2);
/*if(!empty($documents->type)){
$doctype=	$obj->get_docType($documents->type);
}*/

}


if(isset($_GET['del'])){
	if(isAthorized(array('deleteArchReq'), $perms)){ 
	$obj->delete_arch_client_request($_GET['del']);
   }
}


if(isset($_GET["campId"])){
	$campId=$_GET["campId"];
		QB::table('campaign_list')->where('id',$campId)->delete();
		$reqID=$_GET['reqID'];
		$msg=3;
		echo"<script> window.location.replace('arch-demo-view.php?id=$reqID&msg=$msg');</script>";
}

$status=$obj->get_all_status();
$users= $obj->get_all_users();
$district=$obj->get_district();
$templateList=$org->get_all_temp_type_wise(2);


if(isset($_POST['submit'])){
	if(!isset($_POST['remarks'])){
		$_POST['remarks']=$result->remarks;
	}
	$obj->update_arch_req($_POST);
}

if(isset($_POST['comment'])){
$obj->set_arch_comments($_POST, $result->id);
}

if(isset($_POST['campaignAdd'])){
$obj->set_single_campaign_list($_POST,2); //2=Arch
}

if(isset($_POST['sendSMS'])){


	 $message = $_POST["message"];
	$recipients = array();
	if(!empty($message)){
     
	  $mobile_numbers = $_POST['mobileNumbers']; 

	 foreach ($mobile_numbers as  $recipient){			
		// Check mobile number formate
		if(check_mobile_number($recipient)!="false"){ 
			$recipients[] = check_mobile_number($recipient);
		
		}
	} 


	$sms_result=send_sms($message,$recipients,$_POST);	
	
	if($sms_result){	
		$requestID=$_GET['id'];
		$flash->success('New Sent SMS History Loaded successfully.','arch-demo-view.php?id='.$requestID.'');		
	}

	}else{					
		echo " <script type='text/javascript'>		
			alert('Click on check box to select possible customer to send SMS.');
			</script> ";
	}  	


}

// Abdul Halim
// insert customer contact
if (isset($_POST['submit_customer_contact'])) {

		$old_image = $_POST['old_image'] ?? NULL;

		$profile_image = $_FILES['files']['name'][0];	
		$marketting_file = $_FILES['marketting_file']['name'][0];
		   
		$image_stack=array();   
	    $valid_formats = array("jpg","jpeg", "png", "gif", "bmp","JPG", "JPEG");
	    $max_file_size = 1024*4200; //4000 kb / 4MB
	    /*$path =  SITE_ROOT.DS."website".DS."images".DS."slide".DS;*/ // Upload directory			   
	    $path = SITE_ROOT.DS."uploads".DS."custmerContact".DS."profileImg".DS;
	    $image_name_in_arry="";

	   //remove old image
	    
	  if(!empty($_FILES['files']['name'][0]) && !empty($profile_image) && !empty($old_image)){
          $removeOldImage = $path."{$old_image}";
        if (file_exists($removeOldImage)) {
                    unlink($removeOldImage);
                }

    	}

	    // Loop $_FILES to execute all files
	  if ($_FILES['files']['size'] != 0 && $_FILES['files']['error'] != 0){

	    foreach ($_FILES['files']['name'] as $f => $name) 
	    {  
	        $file_tmp =$_FILES['files']['tmp_name'][$f];
	        $file_name = $_FILES['files']['name'][$f];
	        $file_type = $_FILES['files']['type'][$f];
	        $file_size = $_FILES['files']['size'][$f];
	    
	        $ext = pathinfo($file_name, PATHINFO_EXTENSION); // get the file extension name like png jpg
	        if ($_FILES['files']['error'][$f] == 4) {
	            continue; // Skip file if any error found
	        }          
	        if ($_FILES['files']['error'][$f] == 0) {              
	     
	                if(move_uploaded_file($file_tmp,$path.$file_name))
	                    $new_dir= uniqid().rand(1000, 9999).".".$ext;                
	                    $new_name = rename($path.$file_name,$path.$new_dir) ; // rename file name
	                    array_push($image_stack,$new_dir); // file name store in array          
	                }               
	    }
	    

	    $image_name_in_arry=implode(",", $image_stack);
    
  } 

	$profile_image=$image_name_in_arry;
		

	//file upload at marketting file
    // Loop $_FILES to execute all files
    	
                  
                   $image_stack=array();   
				    $valid_formats = array("jpg","jpeg", "png", "gif", "bmp","doc", "docs", "pdf","JPG", "JPEG");
				    $max_file_size = 1024*10240; //4000 kb / 10MB
				    /*$path =  SITE_ROOT.DS."website".DS."images".DS."slide".DS;*/ // Upload directory
				   
				   $path = SITE_ROOT.DS."uploads".DS."custmerContact".DS."markettingFile".DS;
				   $image_name_in_arry="";
				    	 if ($_FILES['marketting_file']['size'] != 0 && $_FILES['marketting_file']['error'] != 0){

				    foreach ($_FILES['marketting_file']['name'] as $f => $name) 
				    {  
				        $file_tmp =$_FILES['marketting_file']['tmp_name'][$f];
				        $file_name = $_FILES['marketting_file']['name'][$f];
				        $file_type = $_FILES['marketting_file']['type'][$f];
				        $file_size = $_FILES['marketting_file']['size'][$f];				    
				        $ext = pathinfo($file_name, PATHINFO_EXTENSION); // get the file extension name like png jpg
				        if ($_FILES['marketting_file']['error'][$f] == 4) {
				            continue; // Skip file if any error found
				        }          
				        if ($_FILES['marketting_file']['error'][$f] == 0) { 				     
				                if(move_uploaded_file($file_tmp,$path.$file_name))
				                    $new_dir= uniqid().rand(1000, 9999).".".$ext;                
				                    $new_name = rename($path.$file_name,$path.DS.$new_dir) ; // rename file name
				                    array_push($image_stack,$new_dir); // file name store in array 
				                }               
				    }
				    $image_name_in_arry=implode(",", $image_stack);
				  } 
					$marketting_file=$image_name_in_arry;

			    	 

	$_POST['file'] = $profile_image;
	$_POST['marketting_file'] = $marketting_file;
	
	$org->addCustomerContact($_POST, 2); // type 1 = witty, 2 = arch
}

$contact_list = $org->CustomerContactList($_GET['id'],2);
$total_customer = $org->TotalCustomer($_GET['id'],2);

if(isset($_POST['message2'])){
	$wt_msg = $_POST['message2'];
}else{
	$wt_msg = "";
}

include_once("header.php");
include_once("menu.php");
?>

<div class="main-panel">
<div class="container">
<div class="page-inner">
<?php  if(isAthorized(array('deleteArchReq'), $perms)){  ?>
<a onclick="return confirm('Are you sure want to delete?')" href="?del=<?php echo $result->id ?>"  class="btn btn-danger btn-sm pull-right">Delete</a>
<?php } ?>
<a href="https://archhms.com/hospital/esadmin/directory-org-request-view.php?id=<?php echo ID_encode($result->id); ?>" target="_blank"  class="btn btn-info btn-sm pull-right">Update Web Profile</a>
<?php if(!empty($result->slug_url)){ ?>
<a href="https://archhms.com/hospital/profile/<?php echo $result->slug_url; ?>" target="_blank"  class="btn btn-info btn-sm pull-right">View Web Profile</a>
<?php } ?>
<?php if(!empty($result->fb_link)){ ?>
<a href="<?php echo $result->fb_link; ?>" target="_blank" class="btn btn-info btn-sm pull-right" ><i class="lni lni-facebook-oval"></i> Facebook</a>
<?php } ?>
<h4 class="page-title"><span class="fgRed"><?php echo "Arch".'  '.$result->req_type; ?></span> <span class="colorOrange">Request from <?php echo $result->institute_name ?></span></h4>

<?PHP
if(isset($_GET['msg'])){
   if($_GET['msg']=='3'){
   	$_GET['msg']="Campaign Deleted Successfully";

   }elseif($_GET['msg']=='1'){
   	 	$_GET['msg']="Save Successfully";
   }elseif($_GET['msg']=='2'){
     	$_GET['msg']="Update Successfully";
   }elseif ($_GET['msg']=='11') {
   		$_GET['msg']="Already Exist";
   }
	?>
<div class='alert alert-success fade in col-md-6 offset-md-3' role='alert'> <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a> <?php echo $_GET['msg']; ?></div>
<?php
}

?>


<div class="row arch-demo-page">
	<div class="col-xl-8 col-lg-12 col-md-12">
		<div class="card card-with-nav">
			<div class="card-header">
		   <!-- <div class="row row-nav-line">
					<ul class="nav nav-tabs nav-line nav-color-secondary w-100 pl-3" role="tablist">
						<li class="nav-item"> <a class="nav-link active show" data-toggle="tab" href="#home" role="tab" aria-selected="true">Timeline</a> </li>
						<li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#profile" role="tab" aria-selected="false">Profile</a> </li>
						<li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#settings" role="tab" aria-selected="false">Settings</a> </li>
					</ul>
				</div> -->
			</div>
			<center><b><?php $flash->display(); ?></b></center>
		<div class="card-body">
			<form  method="POST" action="" >
				<div class="row">
					<div class="col-md-7">
						<div class="form-group">
							<label>Organization Name</label>
							<input type="text" class="form-control" name="institute_name" placeholder="Organization Name" value="<?php echo $result->institute_name ?>">
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group">
							<label>Type</label>
							<div class="select2-input">
								<select required name="institute_type" class="form-control basic">
								    <option value="">Select Type</option>
								    <?php foreach($obj->arch_type_list() AS $key => $value){ ?>
								    <option value="<?php echo $key;?>" <?php if(!empty($result->institute_type)){ if($key==$result->institute_type){echo "SELECTED"; }} ?>><?php echo $value;?></option>
								    <?php } ?>
								</select>
							</div>
						</div>
					</div>
					<div class="col-md-2">
						<div class="form-group">
							<label>Beds</label>
							<input type="number" class="form-control" name="student_qty" placeholder="Beds No" value="<?php echo $result->bed_qty ?>">
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label>Status</label>
							<div class="select2-input">
								<select required name="status" class="form-control basic3">
								    <option value="" > Select Status</option>
								    <?php foreach($status as $sts){ ?>
								    <option value="<?php echo $sts->id;?>" <?php if(!empty($result->status)){ if($sts->id==$result->status){echo "SELECTED"; }} ?>><?php echo $sts->name;?></option>
								    <?php } ?>
								</select>
							</div>
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group">
							<label>Query Type</label>
							<div class="select2-input">
								<select name="req_type" class="form-control basic">
									<option value="">Query Type</option>
									<option value="Price" <?php if(isset($result->req_type)){if($result->req_type=="Price"){echo "SELECTED";}} ?>>Price</option>
									<option value="Demo" <?php if(isset($result->req_type)){if($result->req_type=="Demo"){echo "SELECTED";}} ?>>Demo</option>
								    <option value="camp" <?php if(isset($result->req_type)){if($result->req_type=="camp"){echo "SELECTED";}} ?>>Campaign</option>
								    <option value="Refer" <?php if(isset($result->req_type)){if($result->req_type=="Refer"){echo "SELECTED";}} ?>>Refer</option>
								</select>
							</div>
						</div>
					</div>
					<div class="col-md-5">
						<div class="form-group">
							<label>Campaigns <button type="button" class="modalButton" data-toggle="modal" data-target="#myModal">+</button></label>
							<div class="campaigns-list">
								<?php foreach($campaigns as $campaign){ ?>
								<span class="campaignsName"><?php echo $campaign->camp_name; ?> </span> <a href="?campId=<?php echo $campaign->id; ?> &reqID=<?php echo $_GET['id']; ?>" onclick="return confirm('Are you sure want to delete?')" class="closeButtons"><i class="fa fa-times-circle"></i></a>
							<?php } ?>
							</div>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label>Name <sup style="color: red; ">*</sup></label>
							<input type="text" class="form-control" name="name" placeholder="Name" value="<?php echo $result->name  ?>" required="">
							<input type="hidden" class="form-control" name="id" value="<?php echo $result->id  ?>">
							<input type="hidden" class="form-control" name="pre_thana_id" value="<?php echo $result->thana  ?>">
						   <input type="hidden" class="form-control" name="update_by" value="<?php echo $_SESSION['user_id']  ?>">
						</div>
					</div>
				   	<div class="col-md-3">
						<div class="form-group">
							<label>Designation<sup style="color: red; ">*</sup></label>
							<input type="text" class="form-control" name="desig" placeholder="Designation" value="<?php echo $result->desig  ?>" required="">
						</div>
					</div>
					<div class="col-md-2">
						<div class="form-group">
							<label>Mobile number <sup style="color: red; ">*</sup></label>
							<input type="text" class="form-control" onkeypress="return IsNumeric(event);" name="mobile" placeholder="Mobile Number" value="<?php echo $result->mobile ?>" required="">
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group">
							<label>Email <div  class="btn btn-info btn-sm info-popover" data-trigger="hover" data-html="true" data-container="body" data-toggle="popover" data-placement="left" data-content="You can add multiple email with comma , Example: abc@gamil.com,xyz@gmail.com" data-original-title="" title="" style="padding: 2px 5px !important;"> <i class="fa fa-info-circle" aria-hidden="true"></i> </div><sup style="color: red; ">*</sup></label>
							
							<input type="text" class="form-control" name="email" placeholder="Email" value="<?php echo $result->email ?>" required="">
						</div>
					</div>
					<div class="col-md-3">
					 	<div class="form-group">
						 	<label>District</label>
						 	<div class="select2-input">
                   	<select id="addDistricts" name="district_id" class="form-control basic4" required>
                          <option value="">Select District</option>
                          <?php if(!empty($district)){
                          foreach($district as $row){ ?>
                          <option value="<?php echo $row->id ?>" <?php if(!empty($result->district)){if($result->district==$row->id){echo "SELECTED"; }} ?>><?php echo $row->name ?></option>
                          <?php  }}else{
                               echo '<option value="">Country not available</option>';
                          }?>
                   	</select>
							</div>
						</div>
				 	</div>
				 	<div class="col-md-3">
						<div class="form-group">
							<label>Thana</label>
							<div class="select2-input">
                       	<select id="addThanas" name="thana_id" class="form-control basic5">
                         	<option value=""><?php if(!empty($result->thana)){$thana_name= $obj->get_thana_name($result->thana); echo $thana_name->name;}else{?> Select district first <?php  } ?> </option>
                       	</select>
							 </div>
						 </div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
						   <label>Address</label>
						   <textarea name="institute_add" class="orgAddress" rows="1"><?php echo $result->org_address ?></textarea>
						</div>
					</div>

					<div class="col-md-3">
						<div class="form-group date-wrapper">
							<label>Last Followup Date</label>
							<div class="input-group">
								<input type="text" class="form-control" id="datepicker" value="<?php  if(isset($result->last_followup_date)){ echo date('d-m-Y', strtotime($result->last_followup_date)); } ?>"  name="lf_date" placeholder="DD/MM/YYYY">
								<div class="input-group-append">
									<span class="input-group-text">
										<i class="fa fa-calendar"></i>
									</span>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group date-wrapper">
							<label>Next Followup Date</label>
							<div class="input-group">
								<input type="text" class="form-control" value="<?php if(isset($result->next_followup_date)){  echo date('d-m-Y', strtotime($result->next_followup_date)); } ?>"  id="datepicker2" name="nf_date" placeholder="DD/MM/YYYY">
								<div class="input-group-append">
									<span class="input-group-text">
										<i class="fa fa-calendar"></i>
									</span>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>Assign To </label>
							<div class="select2-input">
							    <select name="assign_to" class="form-control basic2" required>
								    <option value="" > Select User</option>
								    <?php foreach($users as $user){ ?>
								    <option value="<?php echo $user->user_id;?>" <?php if(!empty($result->assign_to)){ if($user->user_id==$result->assign_to){echo "SELECTED"; }} ?>><?php echo $user->firstName.' '.$user->lastName;?></option>
								    <?php } ?>
								</select>
							</div>
						</div>
					</div>
					<div class="col-md-12">
						<div class="form-group">
						   <label>Remark</label>
		            	   <textarea name="note" class="remarks" placeholder="Remarks write here" rows="10" ><?php echo $result->note ?></textarea>
						</div>
					</div>
					<?php if(isAthorized(array('confidentialArch'), $perms)){  ?>		
					<div class="col-md-12">
						<div class="form-group">
						   <label>Assessment</label>
		            	   <textarea name="remarks" class="remarks" placeholder="Assessment write here" rows="10" ><?php echo $result->remarks ?></textarea>
						</div>
					</div>
					<?php } ?>

				 	<?php if(!empty($result->update_by)){ $assign=$obj->detailsAndupdateProfile($result->update_by);
						 	$name= $assign->firstName. " " .$assign->lastName; }else{
						 	$name= "Pending"; } ?>
					<div class="col-md-6">
						<div class="form-group">
							<p style="margin: 0; font-size: 12px;">CREATE: <?php echo ($obj->return_times($result->req_date)) ; ?>, BY: <?php if($result->req_by!='0'){ $createBy= $obj->detailsAndupdateProfile($result->req_by); echo $createBy->firstName; }else{ echo "System"; } ?></p>
														
							<?php if(!empty($result->update_by)){ ?>
							<p style="margin: 0; font-size: 12px;">LAST UPDATE BY: <?php echo $name; ?>
						    <?php } if(!empty($result->update_date)){ ?>
							| DATE: <?php echo ($obj->return_convert_date($result->update_date)) ;  ?> </p>
						<?php } ?>
						</div>
					</div>
					<div class="col-md-6 text-right" style="margin-top: 10px;">
						<button type="submit" name="submit" class="btn btn-success btn-rounded btn-login">Save </button>
					    <a href="campaign-sent-sms.php?type=2&reqID=<?php echo $result->id ?>&search=Search"  target="_blank" class="btn btn-primary btn-rounded">Send SMS</a>
						<a href="campaign-sent-email.php?type=2&temp_id=35&email_type=1&reqID=<?php echo $result->id ?>&search=Search"  target="_blank" class="btn btn-info btn-rounded">Send Email</a>
						<a href="arch-request.php" class="btn btn-warning btn-rounded">Back</a>
					</div>
	         	</div>
	         	<!-- Row Ends -->
			</form>
		</div>
		</div>
	</div>

	<!-- Comment Section Starts -->
	<div class="col-xl-4 col-lg-12 col-md-12">
		<div class="card commentCard">
			<div class="card-body">
				<div class="comment-wrapper">
					<div class="comment-field">
						<div class="row">
							<div class="col-md-12">
								<div class="write-sms-button" onclick="myFunction('comment-section')">
								   <i class="far fa-comment-alt"></i> New Comment
								</div>
								<form action="" method="POST">
									<div id="comment-section">
										<div class="form-group">
										   	<input type="hidden" class="form-control" name="arch_req_id" value="<?php echo $result->id  ?>">
										   	<input type="hidden" class="form-control" name="user_id" value="<?php echo $_SESSION['user_id']   ?>">
											<textarea class="comments" name="remarks"  placeholder="Write comment here" rows="5"></textarea>
										</div>
										<div class="form-group">
											<button type="submit" name="comment" class="btn btn-primary btn-sm pull-right">POST</button>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
					<div class="comment-details">
						<h4>Latest Comments</h4>
						<ul>
							<?php foreach($comment as $value) {
								# code...
							?>
							<li>
								<h6><span class="colorBlue"><?php echo $value->firstName.' '.$value->lastName ?></span> <span class="pull-right comment-time"><small><?php echo $obj->return_times($value->rem_date) ?></small></span></h6>
								<p><?php echo  $value->remarks; ?></p>
							</li>
							<?php } ?>
						</ul>

						<a href="arch-comments-details.php?id=<?php echo $result->id ?>" class="colorGrey" target="_blank">View Previous Comments</a>
					</div>
				</div>
			</div>
	 	</div>
	</div>
	<!-- Comment Section Ends -->

	<!-- Abdul halim -->
	<!-- Start add and view customer contact -->
	<div class="col-xl-12 col-lg-12 col-md-12">
			<div class="card">
			<div class="card-body">
		<a data-toggle="modal" data-target="#addCustomerContactModal"  class="btn btn-info btn-sm pull-right" onclick="addContact();">Add Contact</a>
			<div class="comment-details">

					<form action="" method="POST">
						<div class="row">
							
							<div class="col-md-2">
								<h4><span class="text-warning institute_name"><?php echo $result->institute_name ?></span> Contact List</h4>
							</div>

							<div class="col-md-2">
								<div class="form-group">
									<label>Select template for whats app</label>
									<select name="temp_id" id="smstemp_id2" class="form-control basic2">
								 		<option value="">Template</option>
								 		<?php foreach($templateList as $temp){ ?>
								 		<option value="<?php echo $temp->id; ?>"><?php echo $temp->name; ?></option><?php } ?>
								 	</select>
									
								</div> 
							</div>

							<div class="col-md-4">
								<textarea rows="3" id="tempMessage2" class="comments" name="message2" required="" placeholder="Choose template or write your message"><?php echo isset($smsTemp_one) ?  $smsTemp_one->message : "";?></textarea>
							</div>

							<div class="col-md-3">
								<input type="submit" class="btn btn-primary " name="choose" value="Choose">
							</div>
							
						</div>
					</form>

					<div class="table-responsive">
						<?php if(isset($contact_list)){ ?>
						<table   class="display table table-striped table-hover table-bordered" >
							<thead>
								<tr>
									<th>SL</th>
									<th>Profile</th>
									<th>Name</th>
									<th>Designation</th>
									<th>Mobile <div  class="btn btn-info btn-sm info-popover" data-trigger="hover" data-html="true" data-container="body" data-toggle="popover" data-placement="left" data-content="You can add multiple mobile number with comma, Example: 018XXXXXXXX,017XXXXXXXX. Click number for whats app ." data-original-title="" title="" style="padding: 2px 5px !important;"> <i class="fa fa-info-circle" aria-hidden="true"></i> </div></th>
									<th>Email <div  class="btn btn-info btn-sm info-popover" data-trigger="hover" data-html="true" data-container="body" data-toggle="popover" data-placement="left" data-content="You can add multiple email with comma, Example: abc@gmail.com,xyz@gmail.com" data-original-title="" title="" style="padding: 2px 5px !important;"> <i class="fa fa-info-circle" aria-hidden="true"></i> </div></th>

									<th>Marketing File <div  class="btn btn-info btn-sm info-popover" data-trigger="hover" data-html="true" data-container="body" data-toggle="popover" data-placement="left" data-content="Visiting file for any information" data-original-title="" title="" style="padding: 2px 5px !important;"> <i class="fa fa-info-circle" aria-hidden="true"></i> </div></th>
									<th>Action</th>
									<th class="checkbox-width">
										<div class="checkbox-wrapper">	
											<label>
												<input id="check_all" type="checkbox" />
												<span class="checkmark"></span>
											</label>											
										</div>	
									</th>		
								</tr>
							</thead>
							
							<tbody>
								

								<?php $sl = 1; ?>
								<?php foreach ($contact_list as  $value) { ?>
							   <tr>
							   	<td><?php echo $sl++; ?></td>
							   	<td><?php if(!empty($value->profile_img)){ ?><img src="<?php echo SITE_URL."uploads".DS."custmerContact".DS."profileImg".DS.$value->profile_img; ?>" width="80px" height="80px" alt="Profile Img Not Found"> <?php }else{?><img src="<?php echo SITE_URL."uploads".DS."custmerContact".DS."avatar.jpg"; ?>" width="80px" height="80px" alt="Profile Img Not Found"><?php }?></td>
							   	<td><?php echo $value->name; ?></td>
							   	<td><?php echo $value->designation_name; ?></td>
							   	<td><?php 
							    	$wtmesg="";
								   	$contacts = $value->pcell;
								   	if (!empty($contacts)) {
								   		$contact_arr = explode(',', $contacts);
								   		foreach($contact_arr as $contact){
								   			
								   		?>
								   		<a class="wt_msg"  target="_blank" href="<?php echo 'https://wa.me/'.'88'.trim($contact); ?>?text=<?php echo $wt_msg; ?>"><span class="badge badge-info"><?php echo $contact;  ?></span></a>

								   		<?php
								   		}
								   	}
								
							   	 ?> <input type="hidden" name="" class="contacts_no" id="contacts_no<?php echo $value->id; ?>" value="<?php echo $value->pcell; ?>">
							   	</td>
							   	<td><?php echo $value->pmail; ?></td>
							   	<td>
							   		
			                        <?php 
			                        	if(!empty($value->marketing_file)){
			                            $getMarketingFile = explode(',',$value->marketing_file); ?>
			                            <?php foreach ($getMarketingFile as $markettingfile){ if(!empty($markettingfile)){ ?>                                            
			                               <a href="<?php echo SITE_URL."uploads".DS."custmerContact".DS."markettingFile".DS.$markettingfile; ?>" class="glightbox"><i class="fa fa-eye" aria-hidden="true"></i><img style="display:none" width="80px" height="80px" alt="Marketting File Not Found" src= "<?php echo SITE_URL."uploads".DS."custmerContact".DS."markettingFile".DS.$markettingfile; ?>"></a> 

			                               <span style="color:red;text-decoration: underline;cursor: pointer;"  onclick="delete_file(<?php echo $value->id;?>,<?php echo "'".$markettingfile."'"; ?>)"><sub>x</sub></span>
			                           <?php }}} ?>
			                       
			                     
							   	</td>
							   
							   	<td>
							   		<a data-toggle="modal" data-target="#addCustomerContactModal"  class="btn btn-primary btn-sm" onclick="editContact(<?php echo $value->id; ?>);" style="color: #fff;">Edit</a> 

							   		<a data-toggle="modal" data-target="#ViewCustomerContactModal"  class="btn btn-info btn-sm" onclick="ViewContact(<?php echo $value->id; ?>);" style="color: #fff;">View</a>
							   	</td>

							   	<td class="text-center">
								  		<div class="checkbox-wrapper">	
											<label>
												<input type="checkbox" class="case" name="checkbox[]" id="checkbox[]"  value="<?php echo $value->id ?>" />
												<span class="checkmark"></span>
											</label>											
										</div>
								    </td>	
							   	
							   </tr>

							   <?php } ?>
							</tbody>
						</table>
					<?php } ?>

					<a target="_blank"  href="view-customer-contact-list.php?id=<?php echo $_GET['id'] ?? ''; ?>&type=2" class="btn btn-info btn-sm pull-right">View Contact</a> <!--  type 1 = witty, 2 = arch -->

					<p><?php if(!empty($total_customer->num)){ echo "Total Result :  ".$total_customer->num; } ?></p>
					</div> <!-- end table-responsive -->

				
			</div>
		</div>
	</div>
	</div>
<!-- end add and view customer contact -->

	<!--  Latest Customer Contact Section Starts-->
	<div class="col-xl-6 col-lg-12 col-md-12">
		<div class="card">
			<div class="card-body">
				<div class="email-wrapper">
					
					<div class="email-wrapper emailCard">

						<div class="comment-details">
							<h4>Latest Emails</h4>
							<ul>
								<?php 
								foreach($latestfiveemail as  $emailHistory) {
								 ?>
								<li>
								<?php if(isAthorized(array('manageemail'), $perms)){  ?>
									<h6><span class="emailAddress">To: <strong><?php echo  $emailHistory->to_email; ?></strong></span> <span class="pull-right comment-time"><small><i class="fas fa-eye"></i> <a href="camp_email_req_send_view.php?camp_email_set_req_id=<?php echo $emailHistory->id.'&type=2' ?>" onclick="popupwindow('camp_email_req_send_view.php?camp_email_set_req_id=<?php echo $emailHistory->id.'&type=2' ?>','Details', 1024, 600); return false;"  data-toggle="tooltip" data-placement="bottom"><?php echo $obj->return_times($emailHistory->time); ?></a></small></span></h6>
									<p>Sub: <a href="camp_email_req_send_view.php?camp_email_set_req_id=<?php echo $emailHistory->id.'&type=2' ?>" onclick="popupwindow('camp_email_req_send_view.php?camp_email_set_req_id=<?php echo $emailHistory->id.'&type=2' ?>','Details', 1024, 600); return false;"  data-toggle="tooltip" data-placement="bottom"><span class="fgPurple"><?php echo $emailHistory->subject; ?></span></a></p>
									
									<?php }else{ ?>
										<h6><span class="emailAddress">To: <strong><?php echo  $emailHistory->to_email; ?></strong></span> <span class="pull-right comment-time"><small>  <?php echo $obj->return_times($emailHistory->time); ?></small></span></h6>
									<p>Sub: <span class="fgPurple"><?php echo $emailHistory->subject; ?></span></p>
									<?php } ?>
								</li>
							  <?php } ?>


							</ul>
						</div>
					</div>

				</div>
			</div>
		</div>
	</div>
	<!--  Latest Customer Contact Section Starts-->



	<!--  Latest SMS Section Starts-->
	<div class="col-xl-6 col-lg-12 col-md-12">
		<!--  message sent option -->
	 	<div class="card latestSMSCard">
			<div class="card-body">
				<div class="comment-wrapper">

					<div class="comment-field">
						<div class="row">
							<div class="col-md-12">
								<div class="row col-md-12">
								<div class="col-md-6"> 
									<div class="btn btn-primary btn-rounded" onclick="myFunction('sms-section')">
								   <i class="far fa-comment-alt"></i> Send SMS
								</div>
								</div>	
								<div class="col-md-6">
									<div class="form-group">
										<select name="temp_id" id="smstemp_id" class="form-control basic2">
									 	<option value="">Template</option>
									 	<?php foreach($templateList as $temp){ ?>
									 		<option value="<?php echo $temp->id; ?>"><?php echo $temp->name; ?></option><?php } ?>
									 	</select>
										
									</div>
									 
								</div>
								</div>
								<form action="" method="POST">
									<div id="sms-section">
										<div class="form-group sms">
	                                <label>Message (English/Bangla): </label> 
	                                		<input type="hidden" name="profileID" value="<?php echo $result->id  ?>">
										   	<input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id']   ?>">
										   	<input type="hidden" name="type" value="2">
	                                <textarea rows="3" id="tempMessage" class="comments" name="message" required="" placeholder="ইংরেজিতে SMS লেখার সময় ইউনিকোড (বাংলা) এর কোন চিহ্ন বা বর্ণ ব্যবহার করলে তা বাংলা SMS হিসাবে গণনা করা হবে। SMS পাঠানোর পূর্বে নিচে উল্লিখিত SMS সংখ্যাটি দেখে নিবেন।"><?php echo isset($smsTemp_one) ?  $smsTemp_one->message : "";?></textarea>

	                                <ul id="sms-counter">
	                                    <!-- <li>Encoding: <span class="encoding"></span></li> -->
	                                    <li>Characters: <span class="length"></span></li>
	                                    <li>SMS: <span class="messages"></span></li>
	                                    <li>Per SMS: <span class="per_message"></span></li>
	                                    <li>Remaining: <span class="remaining"></span></li>
	                                </ul>
	                            </div> 
										 <div>
												<div class="form-group">	
													<label>Mobile Numbers: </label>   
													<input type="hidden" id="contactNumber" value="<?php echo $result->mobile; ?>">                   	
					    	                        <select name="mobileNumbers[]" class="form-control clumn"  title="Select Column" multiple="multiple" required="">                                
					    	                          <option value="<?php echo $result->mobile; ?>" <?php if(isset($result->mobile)){ echo "SELECTED"; } ?>><?php echo $result->mobile; ?></option>

					    	                        </select>
			                          			</div>
										 	<!-- <input type="text" name="extraNumber" class="form-control" placeholder="018XXXXXXXX,017XXXXXXXX"> -->
										 </div>
										<div class="form-group">
											<button type="submit" name="sendSMS" class="btn btn-primary btn-sm pull-right">Send</button>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
					<div class="comment-details">
						<h4>Latest Sent SMS</h4>
						<div class="comment-details">
							<ul>
								<?php foreach($latestfivesms as  $value) { ?>
								<li>
									<h6><span class="colorGreen"><?php echo $value->number ?></span> <span class="pull-right comment-time"><small><?php echo $obj->return_times($value->date) ?></small></span></h6>
									<p><?php echo  $value->text; ?></p>
								</li>
								<?php } ?>
							</ul>
							<a href="sms-history.php?mobile=&req_id=<?php echo $result->id ?>&from_date=&to_date=&type=2&search_sms=Search" class="colorGrey" target="_blank">View Previous SMS</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

<!--  Latest SMS Section Ends-->
	<?php  if (!empty($result->marketing_image)){ ?>	
<!--  Private Marketing Section Starts-->
<div class="col-xl-12 col-lg-12 col-md-12">
<!--  message sent option -->
<div class="card documentPhoto">
<div class="card-body">
<div class="comment-wrapper">
	<div class="comment-details">		
		<a href="arch-web-info-view.php?profileID=<?php echo ID_encode($result->id); ?>" target="_blank"  class="btn btn-info btn-sm pull-right">Update Web Info</a>	
		<h4> Profile's Necessary Files </h4>
		<div id="gallery">
			<div class="galleryItemWrapper">
				<div class="row">
	          		          
		      	   <div class="galleryImage">
                     <ul>
                        <?php 
                            $getGallery = explode(',',$result->marketing_image); ?>
                            <?php foreach ($getGallery as $mimage){ ?>                                            
                               <li><a href="<?php echo SITE_URL."uploads".DS."archProfileImage".DS."marketingImage".DS.$mimage; ?>" class="glightbox"><img src= "<?php echo SITE_URL."uploads".DS."archProfileImage".DS."marketingImage".DS.$mimage; ?>"></a> </li>
                           <?php } ?>
                       
                     </ul>
                  </div>
		      	
		      </div>
	      </div>
		</div>
	</div>
</div>
</div>
</div>
</div>
	<!--  Private Marketing Section Ends-->
	<?php } ?>



<!--  Document Section Starts-->
<div class="col-xl-12 col-lg-12 col-md-12">
<!--  message sent option -->
<div class="card latestSMSCard">
<div class="card-body">
<div class="comment-wrapper">
	<div class="comment-details">		
		<a class="btn btn-sm btn-info pull-right" target="_blank" href="new-document.php?softID=<?php  echo base64_encode(2); ?>&reqID=<?php echo base64_encode($_GET['id']); ?>" title=""> Add Document</a>
	
		<h4> Document List</h4>
		<div class="row">
		<?php if(!empty($documents)){ ?>
		
      	<div class="col-md-12">
						<div class="card">
						<!-- 	<div class="card-header">
								<h4 class="card-title">Basic</h4>
							</div> -->
							<div class="card-body">
								<div class="table-responsive">
									<table id="basic-datatables" class="display table table-striped table-hover" >
										<thead>
											<tr>
												<th>Name</th>
												<th>Type</th>
												<th>Date</th>
												<?php if(isAthorized(array('viewDoc'), $perms)){  ?>	
												<th>File</th>	
												<?php } ?>										
												<th>By</th>
												<th>Info</th>
												<th>Option</th>
											</tr>
										</thead>
								
										<tbody>
										   <?php foreach ($documents as  $document) { ?>
											<tr>
								             <td><?php echo $document->name; ?></td>
								             <td><?php echo $document->docName; ?></td>
								             <td><?php echo $obj->return_convert_date($document->date); ?></td>
								             <?php if(isAthorized(array('viewDoc'), $perms)){  ?>
								             <td>
								             	<div class="form-group">
														<?php if(empty($document->file_names)) { ?>
														   <div class="alert alert-info">
															  	<i class="icon fa fa-info"></i> <?php echo 'No files have been uploaded yet!'; ?>
															</div>
													     	<?php }else{  ?>
														  	<ol class="clearfix" id="fileslist">
															  	<?php
										             			$files= explode(',', $document->file_names);
										             			$i=1;
															   	foreach($files as $file) { if(!empty($file)){ ?>
															    	<li>
																    	<div class="button-group-wrapper">
																			<a href="../uploads/documents/<?php echo $file; ?>" download class="downloadButton">
																			 	<!-- <?php //echo "File-".$i; ?> --><i class="fa fa-cloud-download-alt"></i>
																			</a>													
																			<a href="../uploads/documents/<?php echo $file; ?>" onclick="window.open('../uploads/documents/<?php echo $file; ?>', '_blank', 'width=800,height=600,scrollbars=yes,menubar=no,status=yes,resizable=yes,screenx=0,screeny=0'); return false;" 0="" class="viewButton"><i class="fa fa-eye"></i></a>
																			<a href="new-document.php?delete_id=<?php echo base64_encode($document->id); ?>&file_name=<?php echo $file; ?>&softid=2&reqID=<?php echo $_GET['id']; ?>" onclick = "if (! confirm('Are you sure you want to delete this File ?')) { return false; }" class="closeButton"><i class="fa fa-trash"></i></a>
																		</div>
															    	</li>
															  <?php $i++;} } ?>
														  	</ol>
										            <?php } ?>
										      	</div>

								             </td>
											 <?php } ?>	
								             <td><?php echo $document->firstName.' '.$document->lastName; ?></td>
								             <td>
											  	<div class="btn btn-info btn-sm info-popover" data-trigger="hover" data-html="true" data-container="body" data-toggle="popover" data-placement="left" data-content="<p><?php if(!empty($document->note)){ echo "Note: ".$document->note; } ?></p> <p><?php if(!empty($document->update_date)){ echo "Update Time: ".$obj->return_times($document->update_date); } ?></p> " >
												  <i class="fa fa-info-circle" aria-hidden="true"></i>
												</div>
										  	  </td>
											<?php if(isAthorized(array('editDoc'), $perms)){  ?>
								             <td><a  class="btn btn-sm btn-info pull-right" target="_blank" href="new-document.php?doc_id=<?php echo $document->id; ?>" title="Update">Update</a></td>
												<?php } ?>	
											</tr>
											<?php } ?>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>

	<?php } ?>

		</div>
	</div>
</div>
</div>
</div>
</div>
	<!--  Document Section Ends-->

</div>
</div>
</div>
<style type="text/css">
	.sms textarea.form-control {
	    resize: none;
	    border: 2px solid #7fd000;
	    box-shadow: 0 10px 19px -10px #7fd000;
	    margin-bottom: 15px;
	    transition: all .35s ease-in 0s;
	}
	.sms textarea.form-control:focus {
	    box-shadow: 0 10px 19px -10px #29b3e7;
	}
	ul#sms-counter {
	    padding: 0;
	    list-style: none;
	}
	ul#sms-counter>li {
	    display: initial;
	    padding: 0 5px;
	    font-weight: 600;
	}
	ul#sms-counter>li>span {
	    color: red;
	}
	.sms-note {
	    background: #F5F5F5;
	    border-radius: 10px;
	    padding: 10px 10px;
	}
	.sms-note p {
	    margin-bottom: 5px;
	}
</style>
<style type="text/css">
.arch-demo-page .card-body>form>.row>div {
padding: 0 5px;
}
.select2-input .select2{
width: auto!important;
}
.arch-demo-page .form-group, .arch-demo-page .form-check{
padding: 0;
margin-bottom: 5px;
}
.arch-demo-page .form-group label, .arch-demo-page .form-check label {
text-transform: uppercase;
color: #848484!important;
font-weight: normal;
font-size: 12px!important;
margin-bottom: 5px;
}
.arch-demo-page .form-control {
padding: 5px;
}
.arch-demo-page .form-control, .arch-demo-page .select2-container--bootstrap .select2-selection--single{
height: 35px!important;
}
.arch-demo-page .select2-container--bootstrap .select2-selection {
border: 1px solid #ebedf2;
padding: 5px;
}
.arch-demo-page .form-group.date-wrapper {
padding: 0;
}
.arch-demo-page .campaignsName {
margin-bottom: 5px;
display: inline-block;
font-size: 12px;
}
.arch-demo-page .campaignsName:first-child{
background: #E8F1FA;
color: #1976D2;
font-weight: 600;
padding: 2px 5px;
border-radius: 5px;
}
.arch-demo-page .campaignsName:nth-child(2){
background: #FFF4E5;
color: #FF9706;
font-weight: 600;
padding: 2px 5px;
border-radius: 5px;
}
.arch-demo-page .campaignsName:nth-child(3){
background: #F6ECF8;
color: #AE4DBE;
font-weight: 600;
padding: 2px 5px;
border-radius: 5px;
}
.arch-demo-page .campaignsName:nth-child(4){
background: #e5f7ec;
color: #00b44a;
font-weight: 600;
padding: 2px 5px;
border-radius: 5px;
}
.arch-demo-page .campaignsName:last-child{
background: #fdeded;
color: #ef5350;
font-weight: 600;
padding: 2px 5px;
border-radius: 5px;
}
.arch-demo-page textarea.orgAddress {
min-height: 35px;
}
.arch-demo-page textarea.remarks {
min-height: 5em;
}
.arch-demo-page textarea{
width: 100%;
resize: vertical!important;
border-color: #ebedf2;
}
.arch-demo-page textarea:focus{
border-color: #3e93ff;
}
.btn {
padding: 5px 20px;
}
/*Show/Hide Comment Section*/
.arch-demo-page .write-sms-button {
	font-weight: 600;
	color: #1976D2;
	cursor: pointer;
	margin-bottom: 5px;
	outline: 0;
}
.arch-demo-page #sms-section {
	overflow: hidden;
	display: none;
}
.arch-demo-page #comment-section {
	overflow: hidden;
	display: none;
}
.arch-demo-page textarea.comments {
	min-height: 5em!important;
}
.colorGrey {
	color: #777;
	font-weight: 700;
}

@media (min-width: 1200px){
	/*Main Form & Comment Section Height*/
	.card.card-with-nav, .card.commentCard {
		min-height: 69em;
	}
	.arch-demo-page .card.commentCard .comment-details ul{
		height: 58em;
	}
	/*Email and Latest SMS Card*/
	.card.emailCard, .card.latestSMSCard {
		min-height: 38em;
	}
}
/*Gallery*/
div#gallery ul>li {
	float: left;
	margin: 5px;
}
div#gallery ul>li img {
	width: auto;
	height: 100px;
}
/*Gallery*/


</style>

<?php include_once("footer.php"); ?>
<script src="assets/js/sms_counter.min.js"></script>
<script src="assets/js/plugin/tinymce/tinymce.min.js"></script>

<script type="text/javascript">
tinymce.init({
  	selector: 'textarea#local-upload',
  	plugins: 'image code',
  	toolbar: 'undo redo | image code',

	/* without images_upload_url set, Upload tab won't show up*/
  	images_upload_url: 'postAcceptor.php',
	automatic_uploads : false,

	/* we override default upload handler to simulate successful upload*/
  	images_upload_handler: function (blobInfo, success, failure) {
    setTimeout(function () {
      /* no matter what you upload, we will turn it into TinyMCE logo :)*/
      success('');
    }, 2000);
  }
});
</script>

<script type="text/javascript">
	//to check all checkboxes
$(document).on("change","#check_all",function(){
	$("input[class=case]:checkbox").prop("checked", $(this).is(":checked"));
});
</script>

<script type="text/javascript">
   var lightbox = GLightbox();
      lightbox.on('open', (target) => {
       console.log('lightbox opened');
   });
</script>

<script type="text/javascript">
$(document).ready(function(){
/* Populate data to state dropdown */
$('#addDistricts').on('change',function(){
var countryID = $(this).val();
if(countryID){
$.ajax({
 type:'GET',
 url:'../witty/ajaxdata.php',
 data:'district_id='+countryID,
 success:function(data){
    $('#addThanas').html('<option value="">Select Thana</option>');
    var dataObj = jQuery.parseJSON(data);
    if(dataObj){
        $(dataObj).each(function(){
            var option = $('<option />');
            option.attr('value', this.id).text(this.name);
            $('#addThanas').append(option);
        });

    }else{

        $('#addThanas').html('<option value="">State not available</option>');
    }
}
});
}else{
$('#addThanas').html('<option value="">Select country first</option>');
}
});
});

//Show/Hide Comment Section
function myFunction($id) {
var x = document.getElementById($id);
if (x.style.display === "block") {
x.style.display = "none";
} else {
x.style.display = "block";
}
}


$(".clumn").select2({
  tags: true
});
$(".clumn").on("select2:select", function (evt) {
  var element = evt.params.data.element;
  var $element = $(element);
  $(this).focus();
  
  $element.detach();
  $(this).append($element);
  $(this).trigger("change");
});



 $('#smstemp_id').on('change', function(){
        var smstempID = $(this).val();
        if(smstempID){
            $.ajax({
                type:'POST',
                url:'ajax-query.php',
                data:'tempSmsId='+smstempID,
                success:function(html){
                
                    $('#tempMessage').html(html);                    
                    $("#tempMessage").countSms("#sms-counter");

                }
            });
        }else{
        	$('#tempMessage').html("");
        	
        }
    });
// Sms counter
	 $("#tempMessage").countSms("#sms-counter");
</script>

<script type="text/javascript">
	 $('#smstemp_id2').on('change', function(){
        var smstempID = $(this).val();
        if(smstempID){
            $.ajax({
                type:'POST',
                url:'ajax-query.php',
                data:'tempSmsId='+smstempID,
                success:function(html){
                
                    $('#tempMessage2').html(html);                    
                       
                }
            });
        }else{
        	$('#tempMessage2').html("");
        	
        }
    });

</script>

<script type="text/javascript">  
function popupwindow(url, title, w, h) {
              var left = (screen.width/2)-(w/2);
              var top = (screen.height/2)-(h/2);
              return window.open(url, title, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=no, copyhistory=no, width='+w+', height='+h+', top='+top+', left='+left);
}
</script>

<!-- Abdul Halim -->
<!-- start view single contact show -->
<script type="text/javascript">
	function ViewContact(id){
		
		
		$.ajax({
                type:'POST',
                url:'ajax-get-customer-contact-query.php',
                data:{id:id},
                success:function(response){
                   var data = JSON.parse(response);
                   $("#modal_tilte_name_contact").html(data.name+' Contact Information');
                   $("#cust_name").html(data.name);
                   
                   if (data.profile_img) {
                   	$("#profile_img").html('<img src=<?php echo SITE_URL.'uploads/custmerContact/profileImg/';?>'+data.profile_img+' height="80px" width="80px">');
                   }else{
                   	$("#profile_img").html('<img src="<?php echo SITE_URL; ?>uploads/custmerContact/avatar.jpg" height="80px" width="80px">');
                   }

                   $("#cust_designation").html(data.designation_name);
                   $("#cust_mobile").html(data.pcell);
                   $("#cust_email").html(data.pmail);
                   $("#cust_note").html(data.note);
                  
                }
            });

	}
</script>
<!-- end view single contact show -->

<!-- start editContact function -->
<script type="text/javascript">
	function editContact(id){
		$.ajax({
                type:'POST',
                url:'ajax-get-customer-contact-query.php',
                data:{id:id},
                success:function(response){
                   var data = JSON.parse(response);
                   $("#contact_title").html(data.name+' Edit Information');
                   $(".submit_contact").attr("value","Update");
                   $("#hidden_contact_id").val(data.id);
                   $("#contact_name").val(data.name);
                   if(data.profile_img){
                   	$("#contact_profile_img").html('<img src=<?php echo SITE_URL.'uploads/custmerContact/profileImg/';?>'+data.profile_img+' height="80px" width="80px">');
                   }else{
                   	$("#contact_profile_img").html('<img src="<?php echo SITE_URL; ?>uploads/custmerContact/avatar.jpg" height="80px" width="80px">');
                   }
                   
                    $("#contact_designation").val(data.designationID);
                    $("#contact_no").val(data.pcell);
                    $("#contact_mail").val(data.pmail);
                    $("#old_image").val(data.profile_img);
                    $("#old_marketing_file").val(data.marketing_file);
                    $(".contact_note").val(data.note);
                  
                }
            });
	}
</script>
<!-- end editContact function -->

<!-- add contact -->
<script type="text/javascript">
	function addContact(){
		 document.getElementById("myForm").reset();
		 var institute_name = $(".institute_name").html();
		  $("#hidden_contact_id").val('');
		 $("#contact_profile_img").html('');
		 $("#old_image").val('');
		 $("#old_marketing_file").val('');
		 $("#contact_title").html(' Add '+institute_name+' Contact');
       $(".submit_contact").attr("value","Save");
	}
</script>
<!-- end add contact -->

<!-- delete marketing file -->
<script type="text/javascript">
	function delete_file(id, filename){
		 let text = "Are you sure want to delete?";
		  if (confirm(text) == true) {
		    $.ajax({
	            type:'POST',
	            url:'ajax-get-customer-contact-query.php',
	            data:{del_id:id, filename:filename},
	            success:function(response){
	              	location.reload(true);
	            }
	        });
		  }
	}
</script>

<script type="text/javascript">
	$(".case").on("click", function(){
		var text = "";
		var old_opt = $(".clumn").val();
		var mainContact = $("#contactNumber").val();
		text+=mainContact+',';
		$(".case:checked").each(function(){
				
				var id = $(this).val();

				
				var contact_data = $("#contacts_no"+id).val();

				text+=contact_data+',';
				var myArray = text.split(",");

				
				var html = [];
				for (var i = 0;i < myArray.length-1; i++) {
					//alert(myArray[i]);
					html.push("<option value='"+myArray[i]+"' selected>"+myArray[i]+"</option>");

				}
    			
    			document.querySelector(".clumn").innerHTML = html.join("");
    			
			    // Iterate over object and add options to select
			    
				
		});
	});
	
</script>




<!-- The Modal -->
  <div class="modal fade" id="myModal">
    <div class="modal-dialog">
      <div class="modal-content">
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Request Add In Campaign</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <form method="POST" action="">
        <!-- Modal body -->
        <div class="modal-body">
	        <div class="form-group">
	            <label for="p-in" class="col-md-3 label-heading">Campaign</label>
	            <div class="col-md-8 ui-front">
            		<select class="form-control" name="campaign_id" required="">
							<option value="">Select Campaign <sup style="color: red">*</sup></option>
							<?php foreach($campaignList as $camp) { ?>
							<option value="<?php echo $camp->id ?>"><?php echo $camp->camp_name ?></option>
							<?php } ?>
						</select>
	            </div>
	       </div>
        </div>
        <!-- Modal footer -->
        <div class="modal-footer">
        	<input type="hidden" name="reqID" value="<?php echo $_GET["id"]; ?> ">
         <input type="submit" name="campaignAdd" class="btn btn-primary btn-xs" value="Add">
          <button type="button" class="btn btn-danger btn-xs" data-dismiss="modal">Close</button>
        </div>
    </form>
      </div>
    </div>
  </div>

<!-- Abdul Halim -->
<!-- Start  Add , View  customer contact -->

<!-- The Modal -->
  <div class="modal fade" id="addCustomerContactModal">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title" id="contact_title">Add Contact</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        	<form  method="POST" action="" enctype="multipart/form-data" id="myForm">
        		<input type="hidden" name="hidden_contact_id" id="hidden_contact_id" value="">
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
						    <label >Name <sup style="color: red; ">*</sup></label>
						    <input type="text" class="form-control" placeholder="Enter Name" name="name" id="contact_name" value="" required>
						    <input type="hidden" class="form-control" placeholder="" name="profileID" value="<?php echo $_GET['id'] ?? ''; ?>" >
						  </div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
						    <label >Designation <sup style="color: red; ">*</sup></label>
						    <select class="form-control" name="designation" id="contact_designation" required>
						    	<option value="">Select Designation</option>
						    	<?php foreach(customer_designation() as $designation){
						    		?>

						    		<option value="<?php echo $designation->id; ?>"><?php echo $designation->name; ?></option>
						    		
						    		<?php
						    	} ?>
						    </select>
						</div>
					</div>
					
					<div class="col-md-12">
						<div class="form-group">
						    <label >Mobile </label> <small>(You can add multiple mobile number with comma , Example: 017XXXXXXXX,018XXXXXXXX)</small>
						    <input type="text" class="form-control" placeholder="017XXXXXXXX,018XXXXXXXX" name="contact" id="contact_no" value="" >
						  </div>
					</div>

					<div class="col-md-12">
						  <div class="form-group date-wrapper">
					  	  <label >Mail</label> <small>(You can add multiple email with comma , Example: abc@gmail.com,xyz@gmail.com)</small>
						    <input type="text" class="form-control" placeholder="example1@domain.com,example2@domain.com" name="mail" id="contact_mail" value="" >
				      </div>
					 </div>

					 <div class="col-md-6">
						<div class="form-group">
							<p id="contact_profile_img" ></p>
						    <label >Profile Image </label>

						    <input type="file" class="form-control" placeholder="Enter Profile Image" id="" name="files[]">
						    <input type="hidden" name="old_image" id="old_image" value="">
						  </div>
					</div>

					<div class="col-md-6">
						  <div class="form-group date-wrapper">
					  	  	  <label >Marketing File</label> <small>(Visiting file for any information) </small>
						    <input type="file" class="form-control" placeholder="Enter File" name="marketting_file[]" multiple="multiple"  value="" >
						    <input type="hidden" name="old_marketing_file" id="old_marketing_file" value="">
				        </div>
					 </div>

			   		<div class="col-md-12">
						<div class="form-group">
						    <label >Note</label>						   
						  	<textarea name="note" id="local-upload" class="form-control contact_note"  rows="25" ></textarea>
						  </div>
					</div>

            

						 <!-- Modal footer -->
		        <div class="modal-footer offset-md-9 offset-lg-9">
		          <input type="submit" name="submit_customer_contact" class="btn btn-primary btn-xs submit_contact" value="Save" onclick="return confirm('Are you sure want to save?')">
		          <button type="button" class="btn btn-danger btn-xs" data-dismiss="modal">Close</button>
		        </div>
					
	         	</div>
	         	<!-- Row Ends -->
			</form>
      </div>
    </div>
  </div>  

<!-- The Modal -->
  <div class="modal fade" id="ViewCustomerContactModal">
    <div class="modal-dialog">
      <div class="modal-content">
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title" id="modal_tilte_name_contact">View Contact</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
				<table class="table table-bordered">
					<tr>
						<th>Profile Image</th>
						<td id="profile_img"></td>
					</tr>
					<tr>
						<th>Name</th>
						<td id="cust_name"></td>
					</tr>

					<tr>
						<th>Designation</th>
						<td id="cust_designation"></td>
					</tr>

					
					<tr>
						<th>Mobile</th>
						<td id="cust_mobile"></td>
					</tr>

					<tr>
						<th>Email</th>
						<td id="cust_email"></td>
					</tr>

					

					<tr>
						<th>Note</th>
						<td id="cust_note"></td>
					</tr>

					
				</table>
			 <!-- Modal footer -->
	        <div class="modal-footer offset-md-9 offset-lg-9">
	          <button type="button" class="btn btn-danger btn-xs" data-dismiss="modal">Close</button>
	        </div>

      </div>
    </div>
  </div>  

  <!-- end Add , View  customer contact -->
  <style>
  	@media (min-width:  1920px){
   .galleryItemWrapper .gallery-item .zoomIcon img {
      width: 100%;
      height: 178px;
   }
}
@media (min-width: 992px) and (max-width: 1365px ){
   .galleryItemWrapper .gallery-item .zoomIcon img {
      width: 100%;
      height: 121px;
   }
}
@media (max-width: 768px){
   .galleryItemWrapper .gallery-item .zoomIcon img {
      width: 100%;
      height: 118px;
   }  
}
  </style>