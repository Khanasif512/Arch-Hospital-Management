<?php
require_once("../main_function.php");
// require_once("perpage.php");
require_once("pagination.php");
require_once("class/membership.php");
$obj = new operation;

$users = $obj->get_all_users();
$all_status = $obj->get_all_status();

if (isset($_GET["search"])) {
    $institute_name = ($_GET["institute_name"]);
	// $institute_bname = ($_GET["institute_bname"]); 
	$bed_qty = ($_GET["bed_qty"]);
    $generalmember_no = $_GET["generalmember_no"];
	$institute_type = $_GET["institute_type"];
    $tin_no = $_GET["tin_no"];
    $reg_no = $_GET["reg_no"];
    $trade_no = $_GET["trade_no"];
    $hospital_info = $_GET["hospital_info"];
    // $diagnostic_selected = $_GET["diagnostic_selected"];
    $payorder_no = $_GET['payorder_no'];
	$name = $_GET['name'];
	// $application_date = $_GET['application_date'];
    $proposer_name = $_GET['proposer_name'];
    $proposer_company = $_GET['proposer_company'];

    // Prepare WHERE conditions
    $whereArr = array();
	if ($institute_name != "") $whereArr[] = "t1.institute_name = '{$institute_name}'";
    // if ($institute_bname != "") $whereArr[] = "t2.institute_bname = '{$institute_bname}'";
	if ($bed_qty != "") $whereArr[] = "t2.bed_qty = '{$bed_qty}'";
    if ($generalmember_no != "") $whereArr[] = "t2.generalmember_no = '{$generalmember_no}'";
	if ($institute_type != "") $whereArr[] = "t1.institute_type = '{$institute_type}'";
    if ($tin_no != "") $whereArr[] = "t2.tin_no = '{$tin_no}'";
    if ($reg_no != "") $whereArr[] = "t2.reg_no = '{$reg_no}'";
    if ($trade_no != "") $whereArr[] = "t2.trade_no = '{$trade_no}'";
    if ($hospital_info != "") $whereArr[] = "t2.hospital_info = '{$hospital_info}'";
    // if ($diagnostic_selected != "") $whereArr[] = "t2.diagnostic_selected = '{$diagnostic_selected}'";
    if ($payorder_no != "") $whereArr[] = "t2.payorder_no = '{$payorder_no}'";
	if ($name != "") $whereArr[] = "t2.name = '{$name}'";
	// if ($application_date != "") $whereArr[] = "t2.application_date = '{$application_date}'";
    if ($proposer_name != "") $whereArr[] = "t2.proposer_name = '{$proposer_name}'";
    if ($proposer_company != "") $whereArr[] = "t2.proposer_company = '{$proposer_company}'";

    // Combine the WHERE conditions
    $whereStr = implode(" AND ", $whereArr);

// Construct the SQL query with INNER JOIN
if (!empty($whereStr)) {
	// INNER JOIN (only rows that match in both tables)
        $statement = "arch_client_req_tbl t1 LEFT JOIN arch_req_details t2 ON t1.id = t2.reqID WHERE {$whereStr}";
} else {
	// INNER JOIN (only rows that match in both tables)
	$statement = "arch_client_req_tbl t1 RIGHT JOIN arch_req_details t2 ON t1.id = t2.reqID";
}



// Query to fetch customers data
$customers = QB::query("SELECT t1.*, t2.* FROM {$statement} GROUP BY t1.id ORDER BY t1.id DESC LIMIT {$startpoint}, {$per_page}")->get();

// Query to count total customers
$total_search_customer = QB::query("SELECT COUNT(DISTINCT(t1.id)) as num FROM {$statement}")->first();
$total_active_customer = $total_search_customer->num;


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
			<a href="membership_new.php" class="btn btn-sm btn-info pull-right">New Membership Request</a>
			<div class="page-header">
				<h4 class="page-title">Membership List </h4>
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
								<div class="col-12 col-md-6 col-lg-3 col">
										<div class="form-group">
											<input type="text" placeholder="Organization English Name" name="institute_name" class="form-control" value="<?php echo isset($_GET['institute_name']) ? $_GET['institute_name'] : ''; ?>">
										
										</div>
								</div>

                                   <div class="col-12 col-md-6 col-lg-3 col">
										<div class="form-group">
											<input type="text" placeholder="Organization Bangla Name" name="institute_bname" class="form-control" value="<?php echo isset($_GET['institute_bname']) ? $_GET['institute_bname'] : ''; ?>">
										
										</div>
									</div>

									<div class="col-12 col-md-6 col-lg-3 col">
										<div class="form-group">			     
											<input type="number" placeholder="Beds No" name="bed_qty" class="form-control" value="<?php echo isset($_GET['bed_qty']) ? $_GET['bed_qty'] : ''; ?>">
										</div>	
									</div>

									<div class="col-12 col-md-6 col-lg-3 col">
										<div class="form-group">			     
											<input type="number" placeholder="Member No" name="generalmember_no" class="form-control" value="<?php echo isset($_GET['generalmember_no']) ? $_GET['generalmember_no'] : ''; ?>">
										</div>	
									</div>

									<div class="col-12 col-md-6 col-lg-3 col">
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
										
									<div class="col-12 col-md-6 col-lg-3 col">
										<div class="form-group">			     
											<input type="text" placeholder="TIN No" name="tin_no" class="form-control" value="<?php echo isset($_GET['tin_no']) ? $_GET['tin_no'] : ''; ?>">
										</div>	
									</div>

									<div class="col-12 col-md-6 col-lg-2 col">
										<div class="form-group">			     
											<input type="text" placeholder="Reg No" name="reg_no" class="form-control" value="<?php echo isset($_GET['reg_no']) ? $_GET['reg_no'] : ''; ?>">
										</div>	
									</div>

                                    <div class="col-12 col-md-6 col-lg-2 col">
										<div class="form-group">			     
											<input type="text" placeholder="Trade Licence No" name="trade_no" class="form-control" value="<?php echo isset($_GET['trade_no']) ? $_GET['trade_no'] : ''; ?>">
										</div>	
									</div>                               
									
									<div class="col-12 col-md-6 col-lg-2 col">
										<div class="form-group">
											<input type="text" placeholder="Hospital Info" name="hospital_info" class="form-control" value="<?php echo isset($_GET['hospital_info']) ? $_GET['hospital_info'] : ''; ?>">
										
										</div>
									</div>

									<div class="col-12 col-md-6 col-lg-2 col">
										<div class="form-group">			     
											<input type="text" placeholder="PAY-ORDER No" name="payorder_no" class="form-control" value="<?php echo isset($_GET['payorder_no']) ? $_GET['payorder_no'] : ''; ?>">
										</div>	
									</div>

									<div class="col-12 col-md-6 col-lg-2 col">
										<div class="form-group">
											<input type="text" placeholder="Applicant Name" name="name" class="form-control" value="<?php echo isset($_GET['name']) ? $_GET['name'] : ''; ?>">
									
										</div>
									</div>
									
									<div class="col-12 col-md-6 col-lg-2 col">
										<div class="form-group">
											<input type="text" placeholder="Proposer Name" name="proposer_name" class="form-control" value="<?php echo isset($_GET['proposer_name']) ? $_GET['proposer_name'] : ''; ?>">
										
										</div>
									</div>

									<div class="col-12 col-md-6 col-lg-2 col">
										<div class="form-group">
											<input type="text" placeholder="Proposer Company" name="proposer_company" class="form-control" value="<?php echo isset($_GET['proposer_company']) ? $_GET['proposer_company'] : ''; ?>">
										
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
											<th>Organization Name (In English)</th>
											<th>Organization Name (In Bangla)</th>
											<th>Organization Type</th>
											<th>Beds No</th>
											<th>General Member No</th>
											<th>TIN No</th>
											<th>Reg No</th>
											<th>Trade Licence No</th>
											<th>Hospital Info</th>
											<th>Diagnostic Info</th>										
											<th>PAY-ORDER No</th>
											<th>Applicant Name</th>
										    <th>Application Date</th>
										    <th>Proposer Company</th>
                                            <th>Proposer Name</th>
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
										// echo "<pre>";
										// print_r($data);
										// echo "</pre>";
									  ?> 
										<tr>
										<td><?php echo $start; ?></td>
										    <td><a href="membershipdetails_view.php?id=<?php echo $data->id?>" target="_blank"><?php echo $data->institute_name;  ?></a></td>
										    <td><?php echo $data->institute_bname; ?></td>
											<td><?php echo $data->institute_type; ?></td>
											<td><?php echo $data->bed_qty; ?></td>
											<td><?php echo $data->generalmember_no; ?></td>
											<td><?php echo $data->tin_no; ?></td>
											<td><?php echo $data->reg_no; ?></td>											
											<td><?php echo $data->trade_no;  ?></td>
											<td><?php echo $data->hospital_info; ?></td>																					
											<td><?php echo $data->diagnostic_selected; ?></td>
											<td><?php echo $data->payorder_no; ?></td>
											<td><?php echo $data->name; ?></td>
											<td><?php echo $data->application_date; ?></td>					
											 <td><?php echo $data->proposer_company; ?></td>
											 <td><?php echo $data->proposer_name; ?></td>
											
									<?php 
									
									// if(!empty($data->update_by)){ 
									//    $assign=$obj->detailsAndupdateProfile($data->update_by);
									//    if(!empty($assign)){
									//    $update=" Update By : ". $assign->firstName.''.$assign->name;
									//  }else{
									//  	$update= "";
									//  }
									//   }else{
									// 	$update= "";
									//   }

									//      if(!empty($data->update_date)){ 
									//      $update_date =" Update Date : ". $obj->return_times($data->update_date);
							     	//      }else{
							     	//  	 $update_date="";
							     	//      }
									  
									//      $req_date= $obj->return_times($data->req_date);
                                    //     if($data->req_by!='0'){
									// 	    	 $reqBy=$obj->detailsAndupdateProfile($data->req_by);
									// 	    	 $reqBy=$reqBy->name;
									// 	    }else{
									// 	    	$reqBy="System";
									// 	    }

									     if(!empty($data->application_date)){ 
									        $application_date="Application Date: ".$obj->return_convert_date($data->application_date);
									     }else{
									        $application_date="";
									     } ?>								 	

										  	<td>
											  	<div class="btn btn-info btn-sm info-popover" data-trigger="hover" data-html="true" data-container="body" data-toggle="popover" data-placement="left" data-content="<p><?php echo "Request Date : ".$req_date.", Create By : ".$reqBy; ?></p> <p><?php echo $update ; ?></p> <p><?php echo $update_date ; ?></p> <p><?php echo $application_date ; ?></p><p><?php echo $campText; ?></p>" >
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
    // To check all checkboxes
    $(document).on("change", "#check_all", function () {
        $("input[class=case]:checkbox").prop("checked", $(this).is(":checked"));
    });
</script>