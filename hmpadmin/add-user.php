<?php
  require_once("../main_function.php");
  $obj=new operation;

  require_once("class/organization.php");
  $org=new Organization;

  if(isset($_POST['submit'])){   
    	$obj-> user_registration($_POST);
  }

	include_once("header.php");
	include_once("menu.php");

?>	

	<div class="main-panel">
		<div class="container">
			<div class="page-inner">
				<h4 class="page-title">Add User</h4>
				<div class="row">
					<div class="col-md-12">
						<div class="card card-with-nav">
				<!-- 			<div class="card-header">
								<div class="row row-nav-line">
									<ul class="nav nav-tabs nav-line nav-color-secondary w-100 pl-3" role="tablist">
										<li class="nav-item"> <a class="nav-link active show" data-toggle="tab" href="#home" role="tab" aria-selected="true">Timeline</a> </li>
										<li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#profile" role="tab" aria-selected="false">Profile</a> </li>
										<li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#settings" role="tab" aria-selected="false">Settings</a> </li>
									</ul>
								</div>
							</div> -->
							<div class="card-body">
							<form  method="POST" action="" >
								<div class="row mt-3">
									<div class="col-md-3">
										<div class="form-group form-group-default">
											<label>First Name <sup style="color: red; ">*</sup></label>
											<input type="text" class="form-control" name="fname" placeholder="First Name" value="" required="">
										</div>
									</div>
									<div class="col-md-3">
										<div class="form-group form-group-default">
											<label>Last Name <sup style="color: red; ">*</sup></label>
											<input type="text" class="form-control" name="lname" placeholder="Last Name" value="" required="">
										</div>
									</div>
										<div class="col-md-3">
										<div class="form-group form-group-default">
											<label>Mobile number <sup style="color: red; ">*</sup></label>
											<input type="number" class="form-control" name="fnum" placeholder="Enter The Mobile Number" value="" required="">
										</div>
									</div>
									<div class="col-md-3">
										<div class="form-group form-group-default">
											<label>Cell Number  </label>
											<input type="number" class="form-control" name="lnum" placeholder="Enter The Cell Number" value="">
										</div>
									</div>

									<div class="col-md-3">
										<div class="form-group form-group-default">
											<label>Email <sup style="color: red; ">*</sup></label>
											<input type="email" class="form-control" name="email" placeholder="Enter The Email" value="" required="">
										</div>
									</div>	
									<div class="col-md-3">
										<div class="form-group form-group-default">
											<label>Password <sup style="color: red; ">*</sup></label>
											<input type="password" class="form-control" name="password" placeholder="Enter The Password" value="" required="">
										</div>
									</div>	
									<div class="col-md-3">
										<div class="form-group form-group-default">
											<label>Department</label>
										<input type="text" class="form-control" name="dept" placeholder="Enter The Department" value="">
										</div>
									</div>
									<div class="col-md-3">
										<div class="form-group form-group-default">
											<label>Designations</label>
										<input type="text" class="form-control" name="desig" placeholder="Enter The Designations" value="">
										</div>
									</div>	
									<div class="col-md-3">
										<div class="form-group form-group-default">
											<label>User Access Role</label>
										  	<select class="form-control" name="roleId" required="">
											 	<option value="">Select User Access Role</option>
											 	<?php foreach (user_access_level() as $key => $acl) { ?>
									 	         <option value="<?php echo $acl->id; ?>"><?php echo $acl->role; ?></option>
											 <?php } ?>
										  	</select>
										</div>
									</div>

									<div class="col-md-3">
										<div class="form-group form-group-default">
											<label>Status</label>
										  	<select class="form-control" name="status">
											 	<option value="1">Active</option>
											 	<option value="0">Inactive</option>
										  	</select>
										</div>
									</div>								
								</div>							
								
						
								<div class="text-right mt-3 mb-3">
									<button type="submit" name="submit" class="btn btn-success btn-rounded btn-login">Save </button>		
									<a href="user-list.php" class="btn btn-warning btn-rounded">Back</a>
								</div>
							</form>
							</div>
						</div>
					</div>
					<!-- <div class="col-md-4">
						<div class="card card-profile">
							<div class="card-header" style="background-image: url('assets/img/blogpost.jpg')">
								<div class="profile-picture">
									<div class="avatar avatar-xl">
										<img src="assets/img/profile.jpg" alt="..." class="avatar-img rounded-circle">
									</div>
								</div>
							</div>
							<div class="card-body">
								<div class="user-profile text-center">
									<div class="name">Hizrian, 19</div>
									<div class="job">Frontend Developer</div>
									<div class="desc">A man who hates loneliness</div>
									<div class="social-media">
										<a class="btn btn-info btn-twitter btn-sm btn-link" href="#"> 
											<span class="btn-label just-icon"><i class="flaticon-twitter"></i> </span>
										</a>
										<a class="btn btn-danger btn-sm btn-link" rel="publisher" href="#"> 
											<span class="btn-label just-icon"><i class="flaticon-google-plus"></i> </span> 
										</a>
										<a class="btn btn-primary btn-sm btn-link" rel="publisher" href="#"> 
											<span class="btn-label just-icon"><i class="flaticon-facebook"></i> </span> 
										</a>
										<a class="btn btn-danger btn-sm btn-link" rel="publisher" href="#"> 
											<span class="btn-label just-icon"><i class="flaticon-dribbble"></i> </span> 
										</a>
									</div>
									<div class="view-profile">
										<a href="#" class="btn btn-secondary btn-block">View Full Profile</a>
									</div>
								</div>
							</div>
							<div class="card-footer">
								<div class="row user-stats text-center">
									<div class="col">
										<div class="number">125</div>
										<div class="title">Post</div>
									</div>
									<div class="col">
										<div class="number">25K</div>
										<div class="title">Followers</div>
									</div>
									<div class="col">
										<div class="number">134</div>
										<div class="title">Following</div>
									</div>
								</div>
							</div>
						</div>
					</div> -->
				</div>
			</div>
		</div>
<?php
	include_once("footer.php");
?>	