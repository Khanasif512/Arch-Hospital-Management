<?php
require_once("../main_function.php");
require_once("pagination.php");
$obj=new operation;

if(isset($_POST['submit'])){
$obj->set_campaign($_POST);
}
if(isset($_GET["search"])) {

		 $name = ($_GET["name"]);
    	 $type = $_GET["type"];
    	
        $whereArr = array();
        if($name != "") $whereArr[] = "camp_name LIKE '%$name%'";        
        if($type != "") $whereArr[] = " type = '{$type}'";
    
        
        $whereStr = implode(" AND ", $whereArr);
        if(!empty($whereStr)){
			$statement = "camp_email_template WHERE {$whereStr} ";  
		}else{
			$statement = "camp_email_template ";  
		}	
           
        $statement .= " ORDER BY id DESC";
        $result = QB::query("SELECT * FROM {$statement} LIMIT {$startpoint} , {$per_page}")->get();
                
        $total_search_temp= QB::query("SELECT COUNT(id) as num FROM {$statement} ")->first();
        $total_search_temp= $total_search_temp->num;

	}else{
	$result=$obj->get_all_camp_email_temp();
	}


if(isset($_GET['id'])){
 $res= $obj->get_status($_GET['id']);
}
include_once("header.php");
include_once("menu.php");
 ?>
	<div class="main-panel">
		<div class="container">
			<div class="page-inner">
	      <!--  <button type="button" class="btn btn-primary btn-sm pull-right" data-toggle="modal" data-target="#myModal"> Add template </button> -->
	       <a href="camp_add_email_template.php" class="btn btn-primary btn-sm pull-right">Add template </a>	
			<div class="page-header">
             <h4 class="page-title">Email Template List</h4>
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
										<div class="select2-input">										
											<input type="text" name="name" class="form-control" placeholder="Search By Name">
										</div>	
									</div>	
								</div>
								<div class="col-12 col-md-6 col-lg-3 col">
									<div class="form-group">	
										<div class="select2-input">										
											<select name="type" class="form-control basic" >
												<option value="">Select Type</option>
												<option value="1" <?php if(isset($_GET["type"])){if($_GET["type"]==1){echo "SELECTED";}} ?> >Witty</option>
												<option value="2" <?php if(isset($_GET["type"])){if($_GET["type"]==2){echo "SELECTED";}} ?>>Arch</option>													
											</select>
										</div>	
									</div>	
								</div>																		
								
									<div class="col-lg-1 col-xl-1 col-12">
										<div class="form-group">
											<input type="submit" name="search" class="btnSearch btn btn-primary" value="Search">
										</div>
									</div>
								
								</div>	
								</div>	
							</form>	
							</div>
						</div>
					</div>
			   </div>

				<div class="row">
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
												<th>SN</th>												
												<th>Name</th>												
												<th>Option</th>										
											</tr>
										</thead>									
										<tbody>
										   <?php
                                                   $start=0;
									          if(isset($_GET['pages'])){
										           $page=$_GET['pages'];
										           $start=($page-1)*$per_page;
										        }
										    foreach ($result as  $value) { 
                                             $start+=1; 
										   	?>
											<tr>
											<td><?php echo $start; ?></td>								           
								             <td><?php echo $value->name ?></td>							           
								           
								             <td><a href="camp_add_email_template.php?id=<?php echo $value->id; ?>" class="btn btn-info btn-xs">Details</a></td>
								            
											</tr>										
											<?php } ?>
										</tbody>
									</table>
								</div>
							</div>
							<?php 
							if(isset($statement)){
									echo '<div class="pagination-wrapper">'; 
									echo '<div class="col-md-12">'; 
									echo pagination($statement,$per_page,$page,curPageURL()); } ?>
						    <p><?php if(!empty($total_search_temp)){ echo "Total Result :  ".$total_search_temp; } ?></p>
						
						</div>
					</div>					
				</div>
			</div>
			</div>

   

<?php
	include_once("footer.php");
?>