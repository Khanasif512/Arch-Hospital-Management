<?php
require_once("../main_function.php");
$obj=new operation;


if(isset($_POST["submit"])){
 if(isset($_POST["CHOOSING_EMAIL_FOR_SEND_EMAIL"])){
 	$value=$_POST["CHOOSING_EMAIL_FOR_SEND_EMAIL"];
 	$obj->update_setting("CHOOSING_EMAIL_FOR_SEND_EMAIL",$value);
 	$msg="Update Successfull";
 	 echo"<script> window.location.replace('settings.php?msg=$msg');</script>";
 }
}
$selectEmail=$obj->get_setting("CHOOSING_EMAIL_FOR_SEND_EMAIL");

	include_once("header.php");
	include_once("menu.php");
?>
<div class="main-panel">
	<div class="container">
		<div class="page-inner">
	<!-- 		<a href="new-request-arch.php" class="btn btn-sm btn-info pull-right">New Request</a> -->
			<div class="page-header">
				<h4 class="page-title">Settings</h4>
			<?php	if(isset($_GET['msg'])){ ?>
			<div class='alert alert-success fade in col-md-6 offset-md-3' role='alert'> <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a> <?php echo $_GET['msg']; ?></div>	
			  <?php } ?> 		
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="card">
						<div class="card-header">
						<form action="" method="post">					
							<div class="search-box">
								<div class="row">

                               		<div class="col-12 col-md-6 col-lg-3 col">
										<div class="form-group">
										 <label>Choose Email For Send Email  </label>	
											<div class="select2-input ">								
												<select  name="CHOOSING_EMAIL_FOR_SEND_EMAIL" class="form-control basic4" required="">
													<option value="">Select Send Email </option>									
													<option value="esteemcampaign@gmail.com" <?php if("esteemcampaign@gmail.com"==$selectEmail){echo "SELECTED";} ?>>esteemcampaign@gmail.com</option>
													<option value="esteemcampaign1@gmail.com" <?php if("esteemcampaign1@gmail.com"==$selectEmail){echo "SELECTED";} ?>>esteemcampaign1@gmail.com</option>
													<option value="esteemcampaign2@gmail.com" <?php if("esteemcampaign2@gmail.com"==$selectEmail){echo "SELECTED";} ?>>esteemcampaign2@gmail.com</option>
													<option value="esteemcampaign3@gmail.com" <?php if("esteemcampaign3@gmail.com"==$selectEmail){echo "SELECTED";} ?>>esteemcampaign3@gmail.com</option>
													<option value="esteemcampaign4@gmail.com" <?php if("esteemcampaign4@gmail.com"==$selectEmail){echo "SELECTED";} ?>>esteemcampaign4@gmail.com</option>
													<option value="esteemcampaign5@gmail.com" <?php if("esteemcampaign5@gmail.com"==$selectEmail){echo "SELECTED";} ?>>esteemcampaign5@gmail.com</option>
													<option value="esteemcampaign6@gmail.com" <?php if("esteemcampaign6@gmail.com"==$selectEmail){echo "SELECTED";} ?>>esteemcampaign6@gmail.com</option>
													<option value="esteemcampaign7@gmail.com" <?php if("esteemcampaign7@gmail.com"==$selectEmail){echo "SELECTED";} ?>>esteemcampaign7@gmail.com</option>
																										
												</select>
											</div>	
										</div>	
									</div>		
						
									<div class="col-lg-1 col-xl-1 col-12">
										<div class="form-group">
											<input type="submit" name="submit" class="btnSave btn btn-primary" value="Save">
										</div>
									</div>
							
								</div>	
								</div>	
							</form>	
							</div>
					
			
													  
							</div>
						</div>
								
						</div>
					</div>					
				</div>
			</div>

<?php include_once("footer.php");?>
<style type="text/css">
	.data-content{
		font-size: 8px;
	}
</style>
<script type="text/javascript">
	//to check all checkboxes
$(document).on("change","#check_all",function(){
	$("input[class=case]:checkbox").prop("checked", $(this).is(":checked"));
});
</script>
<script type="text/javascript">  
function popupwindow(url, title, w, h) {
              var left = (screen.width/2)-(w/2);
              var top = (screen.height/2)-(h/2);
              return window.open(url, title, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=no, copyhistory=no, width='+w+', height='+h+', top='+top+', left='+left);
}
</script>