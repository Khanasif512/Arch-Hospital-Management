<?php
require_once("../main_function.php");
require_once("sms.php");
require_once("class/membership.php");
require_once("class/organization.php");
$org=new Organization;
$obj=new operation;
$obj2=new Membership;


if(isset($_GET['id'])){
	$result=$obj2->fetch_arch_request_details($_GET['id']);
	

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
		echo"<script> window.location.replace('membershipdetails_view.php?id=$reqID&msg=$msg');</script>";
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
		

	//file upload at marketting file
    // Loop $_FILES to execute all files
    	
                  

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
<h4 class="page-title"><span class="fgRed"><?php echo "Membership".'  '.$result->req_type; ?></span> <span class="colorOrange">Request from <?php echo $result->institute_name ?></span></h4>

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


<?php
//  echo "<br>";
// print_r($result);
// echo "</pre>";
?>

<div class="row arch-demo-page">
	<div class="col-xl-20 col-lg-12 col-md-12">
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
					<div class="col-md-5">
						<div class="form-group">
							<label>Organization Bangla Name</label>
							<input type="text" class="form-control" name="institute_bname" placeholder="Bangla Name" value="<?php echo $result->institute_bname ?>">
						</div>
					</div>
					<div class="col-md-5">
						<div class="form-group">
							<label>Organization English Name</label>
							<input type="text" class="form-control" name="institute_name" placeholder="English Name" value="<?php echo $result->institute_name ?>">
						</div>
					</div>
					<div class="col-md-5">
						<div class="form-group">
							<label>Beds No</label>
							<input type="number" class="form-control" name="bed_qty" placeholder="Beds No" value="<?php echo $result->bed_qty?>">
						</div>
					</div>
					<div class="col-md-5">
						<div class="form-group">
							<label>General Member No</label>
							<input type="number" class="form-control" name="generalmember_no" placeholder="Member No" value="<?php echo $result->generalmember_no ?>">
						</div>
					</div>
			</div>
			<div class="row">
					<div class="col-md-5">
						<div class="form-group">
							<label>TIN No</label>
							<input type="number" class="form-control" name="tin_no" placeholder="TIN No" value="<?php echo $result->tin_no ?>">
						</div>
					</div>
					<div class="col-md-5">
						<div class="form-group">
							<label>REG No</label>
							<input type="number" class="form-control" name="reg_no" placeholder="REG No" value="<?php echo $result->reg_no ?>">
						</div>
					</div>
			</div>
			<div class="row">
                    <div class="col-md-5">
						<div class="form-group">
							<label>Trade Licence No	</label>
							<input type="number" class="form-control" name="trade_no" placeholder="Trade Licence" value="<?php echo $result->trade_no ?>">
						</div>
					</div>
                    <div class="col-md-5">
						<div class="form-group">
							<label>Hospital Info</label>
							<input type="text" class="form-control" name="hospital_info" placeholder="Hospital Information" value="<?php echo $result->hospital_info ?>">
						</div>
					</div>
			</div>
            <div class="row">
                    <div class="col-md-5">
						<div class="form-group">
							<label>Diagnostic Info</label>
							<input type="text" class="form-control" name="diagnostic_selected" placeholder="Diagnostic Information" value="<?php echo $result->diagnostic_selected ?>">
						</div>
					</div>
		
                    <div class="col-md-5">
						<div class="form-group">
							<label>PAY-ORDER No</label>
							<input type="number" class="form-control" name="payorder_no" placeholder="Pay Order No" value="<?php echo $result->payorder_no ?>">
						</div>
					</div>
            </div>
			
			<div class="row">
                    <div class="col-md-5">
						<div class="form-group date-wrapper">
							<label>Application Date</label>
							<div class="input-group">
								<input type="text" class="form-control" id="datepicker" value="<?php  if(isset($result->application_date)){ echo date('d-m-Y', strtotime($result->application_date)); } ?>"  name="application_date" placeholder="DD/MM/YYYY">
								<div class="input-group-append">
									<span class="input-group-text">
										<i class="fa fa-calendar"></i>
									</span>
								</div>
							</div>
						</div>
					</div>
                    <div class="col-md-5">
						<div class="form-group">
							<label>Proposer Name</label>
							<input type="text" class="form-control" name="proposer_name" placeholder="Proposer Name" value="<?php echo $result->proposer_name ?>">
						</div>
					</div>
			</div>
			<div class="row">
                    <div class="col-md-5">
						<div class="form-group">
							<label>Proposer Company</label>
							<input type="text" class="form-control" name="proposer_company" placeholder="Proposer Company" value="<?php echo $result->proposer_company ?>">
						</div>
					</div>
					
				
					<?php if(isAthorized(array('confidentialArch'), $perms)){  ?>
					<?php } ?>

				 	<?php if(!empty($result->update_by)){ $assign=$obj->detailsAndupdateProfile($result->update_by);
						 	$name= $assign->firstName. " " .$assign->lastName; }else{
						 	$name= "Pending"; } ?>
					<div class="col-md-5">
						<div class="form-group">
							<p style="margin: 0; font-size: 12px;">CREATE: <?php echo ($obj->return_times($result->req_date)) ; ?>, BY: <?php if($result->req_by!='0'){ $createBy= $obj->detailsAndupdateProfile($result->req_by); echo $createBy->firstName; }else{ echo "System"; } ?></p>
														
							<?php if(!empty($result->update_by)){ ?>
							<p style="margin: 0; font-size: 12px;">LAST UPDATE BY: <?php echo $name; ?>
						    <?php } if(!empty($result->update_date)){ ?>
							| DATE: <?php echo ($obj->return_convert_date($result->update_date)) ;  ?> </p>
						<?php } ?>
						</div>
					</div>
			</div>
	       <div class="row">
		         <div class="col-md-5">
						<div class="form-group">
							<label>Applicant Name</label>
							<input type="text" class="form-control" name="name" placeholder="Proposer Name" value="<?php echo $result->name ?>">
						</div>
			     </div>
		   </div>
					<!-- <div class="col-md-5 text-right" style="margin-top: 10px;">
						<button type="submit" name="submit" class="btn btn-success btn-rounded btn-login">Save </button>
					    <a href="campaign-sent-sms.php?type=2&reqID=<?php echo $result->id ?>&search=Search"  target="_blank" class="btn btn-primary btn-rounded">Send SMS</a>
						<a href="campaign-sent-email.php?type=2&temp_id=35&email_type=1&reqID=<?php echo $result->id ?>&search=Search"  target="_blank" class="btn btn-info btn-rounded">Send Email</a>
						<a href="arch-request.php" class="btn btn-warning btn-rounded">Back</a>
					</div> -->
	         	</div>
	         	<!-- Row Ends -->
			</form>
		</div>
		</div>
	</div>
	

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