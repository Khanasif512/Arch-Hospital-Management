<?php
require_once("../main_function.php");
// require_once("perpage.php");
require_once("pagination.php");
 $obj=new operation;
 
$users= $obj->get_all_users();
$all_status=$obj->get_all_status();
/*$all_campaign=$obj->get_all_campagin();*/
$campaignLists=$obj->get_all_campagin_type(2);
if(isset($_POST['submit'])){
	$obj->set_campaign_list($_POST);	
}

	if(isset($_GET["search"])) {
		
		 $name = ($_GET["name"]);
    	 $mobile = $_GET["mobile"];
    	 $email=isset($_GET["email"]) ? $_GET["email"] : NULL; 
    	 $req_type = $_GET["req_type"];
    	 $institute_type=$_GET["institute_type"];
    	 $assign_to=$_GET["assign_to"];
    	 $status=$_GET["status"];
    	 $str =$_GET['nf_date'];    	 
    	 $today =$_GET['today_date']; 
    	 if(!empty($today)){ 
	     $date = DateTime::createFromFormat('d/m/Y', $today);
	     $to_date= $date->format('Y-m-d');
	       }
	   
	     if(!empty($str)){ 
	     $date = DateTime::createFromFormat('d/m/Y', $str);
	     $nf_date= $date->format('Y-m-d');
	       }
	     
	     $last_date=$_GET['lf_date'];	   
	    if(!empty($last_date)){ 
	     $date = DateTime::createFromFormat('d/m/Y',$last_date);
	     $lf_date= $date->format('Y-m-d');
	       } 

	   $campaign=isset($_GET["campaign"])? $_GET["campaign"] : NULL;

	   $from_updatedate=isset($_GET["from_date"])? $_GET["from_date"] : NULL;
	   $to_updatedate=isset($_GET["to_date"])? $_GET["to_date"] : NULL;
	    
        $whereArr = array();
        if($name != "") $whereArr[] = "name LIKE '%$name%' OR institute_name LIKE '%$name%' ";        
        if($mobile != "") $whereArr[] = " mobile = '{$mobile}'";
        if($email != "") $whereArr[] = " email = '{$email}'";
        if($req_type != "") $whereArr[] = " req_type = '{$req_type}'";
        if($institute_type != "") $whereArr[] = "institute_type = '{$institute_type}'";
        if($assign_to != "") $whereArr[] = " assign_to = '{$assign_to}'";
        if($status != "") $whereArr[] = " t1.status = '{$status}'";
        if($campaign != "") $whereArr[] = " t3.id = '{$campaign}'";
        if(!empty($nf_date)){
        if($nf_date != "") $whereArr[] = " next_followup_date = '{$nf_date}'";
         } 
        if(!empty($lf_date)){
        if($lf_date != "") $whereArr[] = "last_followup_date = '{$lf_date}'";
         } 
        
        if(!empty($to_date)){
        if($to_date != "") $whereArr[] = "DATE(req_date) = '{$to_date}'";
         } 

        if(!empty($from_updatedate) && !empty($to_updatedate)){
        $whereArr[] = "(update_date BETWEEN '{$from_updatedate}' AND '$to_updatedate')";
         }
    
        
        $whereStr = implode(" AND ", $whereArr);
        if(!empty($whereStr)){
			$statement = "arch_client_req_tbl t1 LEFT JOIN campaign_list t2 ON t1.id=t2.req_id LEFT JOIN campaign t3 ON t3.id=t2.camp_id AND t3.type='2'  WHERE {$whereStr} ";  
		}else{
			$statement = "arch_client_req_tbl t1 LEFT JOIN campaign_list t2 ON t1.id=t2.req_id LEFT JOIN campaign t3 ON t3.id=t2.camp_id AND t3.type='2'";  
		}
           
      /*  $statement .= " ORDER BY t1.id DESC";*/
        $customers = QB::query("SELECT t1.* FROM {$statement} GROUP BY t1.id ORDER BY t1.id DESC LIMIT {$startpoint} , {$per_page}")->get();
                
        $total_search_customer = QB::query("SELECT COUNT(DISTINCT(t1.id)) as num FROM {$statement} ")->first();
        $total_active_customer= $total_search_customer->num;

	}
	
	include_once("header.php");
	include_once("menu.php");
    ?>
     <style type="text/css">
/*Custom Checkbox Style*/
/* Customize the label (the checkbox-wrapper) */
.checkbox-wrapper {
    display: block;
    position: relative;
    padding-left: 25px;
    margin-bottom: 5px;
    cursor: pointer;
    font-size: 17px;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
}

/* Hide the browser's default checkbox */
.checkbox-wrapper input {
  position: absolute;
  opacity: 0;
  cursor: pointer;
  height: 0;
  width: 0;
}
.table .checkbox-wrapper .checkmark {
    border-radius: 2px;
}
/* Create a custom checkbox */
.checkbox-wrapper .checkmark {
    position: absolute;
    top: 0;
    left: 0;
    height: 20px;
    width: 20px;
    background-color: #ccc;
}

/* On mouse-over, add a grey background color */
.checkbox-wrapper:hover input ~ .checkmark {
	background-color: #ddd;
}

/* When the checkbox is checked, add a Green background */
.checkbox-wrapper input:checked ~ .checkmark {
	background-color: #007bff;
}

/* Create the checkmark/indicator (hidden when not checked) */
.checkbox-wrapper .checkmark:after {
	content: "";
	position: absolute;
	display: none;
}

/* Show the checkmark when checked */
.checkbox-wrapper input:checked ~ .checkmark:after {
  display: block;
}

/* Style the checkmark/indicator */
.checkbox-wrapper .checkmark:after {
    left: 7px;
    top: 2px;
    width: 7px;
    height: 14px;
    border: solid white;
    border-width: 0 3px 3px 0;
    -webkit-transform: rotate(45deg);
    -ms-transform: rotate(45deg);
    transform: rotate(45deg);
}

.checkbox.checkbox-wrapper {
    line-height: normal;
}
.checkbox.checkbox-wrapper label {
    padding: 0;
    font-size: 15px;
}
/*Custom Checkbox Style*/

.text-right.mt-3.mb-3 {
    padding-right: 10px;
}
</style>
<div class="main-panel">
	<div class="container">
		<div class="page-inner">
			<a href="new-request-arch.php" class="btn btn-sm btn-info pull-right">New Request</a>
			<div class="page-header">
				<h4 class="page-title">Membership Request List </h4>
			<?PHP	if(isset($_GET['msg'])){?>
			<div class='alert alert-success fade in col-md-6 offset-md-3' role='alert'> <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a> <?php echo $_GET['msg']; ?></div>	
			  <?php } ?> 		
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="card">
						<div class="card-header">
							<form name="frmSearch" method="GET" action="" class="arch-request-form">
							<div class="search-box">
								<div class="row">
									<div class="col-12 col-md-6 col-lg-2 col">
										<div class="form-group">
											<input type="text" placeholder="Name or Organization" name="name" class="form-control" value="<?php echo isset($_GET['name']) ? $_GET['name'] : ''; ?>">
										
										</div>
									</div>
									<div class="col-12 col-md-6 col-lg-2 col">
										<div class="form-group">			     
											<input type="number" placeholder="Mobile" name="mobile" class="form-control" value="<?php echo isset($_GET['mobile']) ? $_GET['mobile'] : ''; ?>">
										</div>	
									</div>
										
									<div class="col-12 col-md-6 col-lg-2 col">
										<div class="form-group">			     
											<input type="text" placeholder="email" name="email" class="form-control" value="<?php echo isset($_GET['email']) ? $_GET['email'] : ''; ?>">
										</div>	
									</div>
										
									<div class="col-12 col-md-6 col-lg-2 col">
										<div class="form-group">	
											<div class="select2-input">
												<select  name="institute_type" class="form-control basic2">
													<option value="">Institute Type</option>							
													<?php foreach($obj->arch_type_list() AS $key => $value){ ?>
													<option value="<?php echo $key;?>" <?php if(isset($_GET["institute_type"])){if($_GET["institute_type"]==$key){echo "SELECTED";}} ?>><?php echo $value;?></option>
													<?php } ?>	
												</select>
											</div>	
										</div>	
									</div>

									<div class="col-12 col-md-6 col-lg-2 col">
										<div class="form-group">	
											<div class="select2-input">										
												<select name="req_type" class="form-control basic">
													<option value="">Query Type</option>
													<option value="Price" <?php if(isset($_GET["req_type"])){ if($_GET["req_type"]=="Price"){ echo "SELECTED";}} ?> >Price</option>
													<option value="Demo" <?php if(isset($_GET["req_type"])){ if($_GET["req_type"]=="Demo"){ echo "SELECTED";}} ?>>Demo</option>
													<option value="camp" <?php if(isset($_GET["req_type"])){ if($_GET["req_type"]=="camp"){ echo "SELECTED";}} ?>>Campaign</option>
													<option value="Refer" <?php if(isset($_GET["req_type"])){ if($_GET["req_type"]=="Refer"){ echo "SELECTED";}} ?>>Refer</option>
												</select>
											</div>	
										</div>	
									</div>
									<div class="col-12 col-md-6 col-lg-2 col">
										<div class="form-group">	
											<div class="select2-input">										
												<select name="campaign" class="form-control basic">
													<option value="">All Campaign</option>
														<?php foreach($campaignLists as $campList){ ?>
													<option value="<?php echo $campList->id;?>" <?php if(isset($_GET["campaign"])){if($_GET["campaign"]==$campList->id){echo "SELECTED";}} ?>><?php echo $campList->camp_name;?></option>
                                                    <?php } ?>
													</select>
											</div>	
										</div>	
									</div>

									<div class="col-12 col-md-6 col-lg-2 col">
										<div class="form-group">	
											<div class="select2-input">								
												<select  name="status" class="form-control basic4">
													<option value="">All status </option>							
													<?php foreach($all_status as $sts){ ?>
													<option value="<?php echo $sts->id;?>" <?php if(isset($_GET["status"])){if($_GET["status"]==$sts->id){echo "SELECTED";}} ?>><?php echo $sts->name;?></option>
                                                    <?php } ?>	
												</select>
											</div>	
										</div>	
									</div>

									<div class="col-12 col-md-6 col-lg-2 col">
										<div class="form-group date-wrapper">											
											<div class="input-group">
												<input type="text" class="form-control" id="datepicker3" value="<?php if(isset($_GET["today_date"])){ echo $_GET['today_date'] ; }?>" name="today_date" placeholder="Request Date (etc. DD/MM/YYYY)">
												<div class="input-group-append">
													<span class="input-group-text">
														<i class="fa fa-calendar"></i>
													</span>
												</div>
											</div>
										</div>
									</div>
									
									<div class="col-12 col-md-6 col-lg-2 col">
										<div class="form-group">
											<div class="select2-input">	
												<select  name="assign_to" class="form-control basic3">
													<option value="">Assigned User</option>							
													<?php foreach($users as $user){ ?>
													<option value="<?php echo $user->user_id;?>" <?php if(isset($_GET["assign_to"])){if($_GET["assign_to"]==$user->user_id){echo "SELECTED";}} ?>><?php echo $user->firstName;?></option>
													<?php } ?>	
												</select>
											</div>	
										</div>	
									</div>
									
									<div class="col-lg-1 col-xl-1 col-12">
										<div class="form-group">
											<input type="submit" name="search" class="btnSearch btn btn-primary" value="Search">
										</div>
									</div>
									<!-- <div class="col-lg-3 col-xl-2 col">
										<div class="form-group">
											<input type="reset" class="btnSearch btn btn-secondary btn-block" value="Reset" onclick="window.location='witty-request.php'">
										</div>	
									</div>	 -->
								</div>	
								</div>	
							</form>	
							</div>
						<!-- id="basic-datatables" -->
				<?php	if(!empty($customers)){  ?>
						<div class="arch-table-wrapper">
							<div class="table-responsive">
								<form method="post" action="">
								<table id="basic-datatables" class="display table table-striped table-hover" >
									<thead>
										<tr>
											<th>SN</th>
											<th>Organization</th>
											<th>Type</th>
											<th>Bed No</th>
											<th>Status</th>
											<th>Name</th>
											<th>Mobile</th>
											<th>District</th>											
											<th>Query</th>
										    <th>Assign to</th>
										    <th>Info</th>
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
									<?php 
                                       $start=0;
							          if(isset($_GET['pages'])){
								           $page=$_GET['pages'];
								           $start=($page-1)*$per_page;
								        }
									 foreach ( $customers as $data) { $start+=1;
                                          $campaigns=$obj->assign_getCampaign((int)$data->id,2);
                                               $campName="";
                                         foreach ($campaigns as $key => $campaign) { 
                                                 $campName.= $campaign->camp_name.", "; 
							               } 
							               if(!empty($campName)){
							               	$campText="Campaigns: ".$campName;
							               }else{
							               	$campText="";
							               }
                                            
									  ?> 
										<tr>
											<td><?php echo $start; ?></td>
											<td><a href="arch-demo-view.php?id=<?php echo $data->id?>" target="_blank"><?php echo $data->institute_name;  ?></a></td>
											<td><?php echo  $obj->return_arch_type_list($data->institute_type);  ?></td>	
											<td><?php echo $data->bed_qty; ?></td>
											<td><?php
                                               if(!empty($data->status)){
											 $status=$obj->get_status($data->status);
											 echo $status->name;}else{
											 	echo "Pending";
											 }  
											 ?></td>
											<td><?php echo $data->name;  ?></td>
											<td><?php echo $data->mobile; ?></td>
											<td <?php if(empty($campText)){ ?> bgcolor="yellow"<?php } ?>><?php  if(!empty($data->district)){ $district= $obj->return_district($data->district); 
                                               echo $district->name;}else{ echo "NA";}
											  ?>
											</td>											
											<td><?php echo $data->req_type; ?></td>
											<td title="<?php echo $obj->return_times($data->req_date);  ?>"><?php
                                             if(!empty($data->assign_to)){ 
											 $assign=$obj->detailsAndupdateProfile($data->assign_to);
											 echo $assign->firstName;
											 }else{
												echo "Not Assigned";
											 } ?>											 	
											 </td>
											 

									<?php 
									
									if(!empty($data->update_by)){ 
									   $assign=$obj->detailsAndupdateProfile($data->update_by);
									   if(!empty($assign)){
									   $update=" Update By : ". $assign->firstName.''.$assign->lastName;
									 }else{
									 	$update= "";
									 }
									  }else{
										$update= "";
									  }

									     if(!empty($data->update_date)){ 
									     $update_date =" Update Date : ". $obj->return_times($data->update_date);
							     	     }else{
							     	 	 $update_date="";
							     	     }
									  
									     $req_date= $obj->return_times($data->req_date);
                                        if($data->req_by!='0'){
										    	 $reqBy=$obj->detailsAndupdateProfile($data->req_by);
										    	 $reqBy=$reqBy->firstName;
										    }else{
										    	$reqBy="System";
										    }

									     if(!empty($data->next_followup_date)){ 
									        $next_f_date="Followup Date : ".$obj->return_convert_date($data->next_followup_date);
									     }else{
									        $next_f_date="";
									     } ?>									 	

										  	<td>
											  	<div class="btn btn-info btn-sm info-popover" data-trigger="hover" data-html="true" data-container="body" data-toggle="popover" data-placement="left" data-content="<p><?php echo "Request Date : ".$req_date.", Create By : ".$reqBy; ?></p> <p><?php echo $update ; ?></p> <p><?php echo $update_date ; ?></p> <p><?php echo $next_f_date ; ?></p><p><?php echo $campText; ?></p>" >
												  <i class="fa fa-info-circle" aria-hidden="true"></i>
												</div>
										  	</td>
										  	<td class="text-center">
										  		<div class="checkbox-wrapper">	
													<label>
														<input type="checkbox" class="case" name="checkbox[]" id="checkbox[]" value="<?php echo $data->id ?>" />
														<span class="checkmark"></span>
													</label>											
												</div>
										    </td>	
											
										</tr>
										<?php   } ?>		
									</tbody>
								</table>
								<div class="col-md-12">
									<div class="row">
										<div class="col-md-6"></div>
										<div class="col-md-offset-6 col-md-4 select2-input">
											<select class="form-control basic" name="campaign_id"  required="">
												<option value="">Select Campaign <sup style="color: red">*</sup></option>
												<?php foreach ($campaignLists as $camp) { ?>
												<option value="<?php echo $camp->id ?>"><?php echo $camp->camp_name ?></option>
											<?php } ?>
											</select>
											<input type="hidden" name="type" value="2">
										</div>
									 	<div class="col-md-2">								
											<button type="submit" name="submit" class="btn btn-success btn-rounded btn-login">Submit</button>
										</div>	
									</div>	
								</div>	
							</form>
								<?php 
								echo '<div class="pagination-wrapper">'; 
								echo '<div class="col-md-12">'; 
								echo pagination($statement,$per_page,$page,curPageURL(),$total_active_customer);  ?>
								<p><?php if(!empty($total_active_customer)){ echo "Total Result :  ".$total_active_customer; } ?></p>
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