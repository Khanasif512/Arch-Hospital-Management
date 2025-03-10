<?php
	include_once("header.php");
	include_once("menu.php");
?>						
	
	<div class="main-panel">
		<div class="container">
			<div class="page-inner">
				<div class="page-header">
					<h4 class="page-title">Form Validation</h4>
					<ul class="breadcrumbs">
						<li class="nav-home">
							<a href="#">
								<i class="flaticon-home"></i>
							</a>
						</li>
						<li class="separator">
							<i class="flaticon-right-arrow"></i>
						</li>
						<li class="nav-item">
							<a href="#">Forms</a>
						</li>
						<li class="separator">
							<i class="flaticon-right-arrow"></i>
						</li>
						<li class="nav-item">
							<a href="#">Form Validation</a>
						</li>
					</ul>
				</div>
				<div class="row">
					<div class="col-md-12">
						<div class="card">
							<div class="card-header">
								<div class="card-title">jQuery Validation</div>
								<div class="card-category">Form validation with jQuery from <a href="https://jqueryvalidation.org/">jQuery Validate</a></div>
							</div>
							<form id="exampleValidation">
								<div class="card-body">
									<div class="form-group form-show-validation row">
										<label for="name" class="col-lg-3 col-md-3 col-sm-4 mt-sm-2 text-right">Name <span class="required-label">*</span></label>
										<div class="col-lg-4 col-md-9 col-sm-8">
											<input type="text" class="form-control" id="name" name="name" placeholder="Enter Username" required>
										</div>
									</div>
									<div class="form-group form-show-validation row">
										<label for="username" class="col-lg-3 col-md-3 col-sm-4 mt-sm-2 text-right">Username <span class="required-label">*</span></label>
										<div class="col-lg-4 col-md-9 col-sm-8">
											<div class="input-group">
												<div class="input-group-prepend">
													<span class="input-group-text" id="username-addon">@</span>
												</div>
												<input type="text" class="form-control" placeholder="username" aria-label="username" aria-describedby="username-addon" id="username" name="username" required>
											</div>
										</div>
									</div>
									<div class="form-group form-show-validation row">
										<label for="email" class="col-lg-3 col-md-3 col-sm-4 mt-sm-2 text-right">Email Address <span class="required-label">*</span></label>
										<div class="col-lg-4 col-md-9 col-sm-8">
											<input type="email" class="form-control" id="email" placeholder="Enter Email" required>
											<small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
										</div>
									</div>
									<div class="form-group form-show-validation row">
										<label for="password" class="col-lg-3 col-md-3 col-sm-4 mt-sm-2 text-right">Password <span class="required-label">*</span></label>
										<div class="col-lg-4 col-md-9 col-sm-8">
											<input type="password" class="form-control" id="password" name="password" placeholder="Enter Password" required>
										</div>
									</div>
									<div class="form-group form-show-validation row">
										<label for="confirmpassword" class="col-lg-3 col-md-3 col-sm-4 mt-sm-2 text-right">Confirm Password <span class="required-label">*</span></label>
										<div class="col-lg-4 col-md-9 col-sm-8">
											<input type="password" class="form-control" id="confirmpassword" name="confirmpassword" placeholder="Enter Password" required>
										</div>
									</div>
									<div class="separator-solid"></div>
									<div class="form-group form-show-validation row">
										<label class="col-lg-3 col-md-3 col-sm-4 mt-sm-2 text-right">Gender <span class="required-label">*</span></label>
										<div class="col-lg-4 col-md-9 col-sm-8 d-flex align-items-center">
											<div class="custom-control custom-radio">
												<input type="radio" id="male" name="gender" class="custom-control-input">
												<label class="custom-control-label" for="male">Male</label>
											</div>
											<div class="custom-control custom-radio">
												<input type="radio" id="female" name="gender" class="custom-control-input">
												<label class="custom-control-label" for="female">Female</label>
											</div>
										</div>
									</div>
									<div class="form-group form-show-validation row">
										<label for="birth" class="col-lg-3 col-md-3 col-sm-4 mt-sm-2 text-right">Birth <span class="required-label">*</span></label>
										<div class="col-lg-4 col-md-9 col-sm-8">
											<div class="input-group">
												<input type="text" class="form-control" id="birth" name="birth" required>
												<div class="input-group-append">
													<span class="input-group-text">
														<i class="fa fa-calendar-o"></i>
													</span>
												</div>
											</div>
										</div>
									</div>
									<div class="form-group form-show-validation row">
										<label for="birth" class="col-lg-3 col-md-3 col-sm-4 mt-sm-2 text-right">State <span class="required-label">*</span></label>
										<div class="col-lg-4 col-md-9 col-sm-8">
											<div class="select2-input">
												<select id="state" name="state" class="form-control" required>
													<option value="">&nbsp;</option>
													<optgroup label="Alaskan/Hawaiian Time Zone">
														<option value="AK">Alaska</option>
														<option value="HI">Hawaii</option>
													</optgroup>
													<optgroup label="Pacific Time Zone">
														<option value="CA">California</option>
														<option value="NV" >Nevada</option>
														<option value="OR">Oregon</option>
														<option value="WA">Washington</option>
													</optgroup>
													<optgroup label="Mountain Time Zone">
														<option value="AZ">Arizona</option>
														<option value="CO">Colorado</option>
														<option value="ID">Idaho</option>
														<option value="MT">Montana</option>
														<option value="NE">Nebraska</option>
														<option value="NM">New Mexico</option>
														<option value="ND">North Dakota</option>
														<option value="UT">Utah</option>
														<option value="WY">Wyoming</option>
													</optgroup>
													<optgroup label="Central Time Zone">
														<option value="AL">Alabama</option>
														<option value="AR">Arkansas</option>
														<option value="IL">Illinois</option>
														<option value="IA">Iowa</option>
														<option value="KS">Kansas</option>
														<option value="KY">Kentucky</option>
														<option value="LA">Louisiana</option>
														<option value="MN">Minnesota</option>
														<option value="MS">Mississippi</option>
														<option value="MO">Missouri</option>
														<option value="OK">Oklahoma</option>
														<option value="SD">South Dakota</option>
														<option value="TX">Texas</option>
														<option value="TN">Tennessee</option>
														<option value="WI">Wisconsin</option>
													</optgroup>
													<optgroup label="Eastern Time Zone">
														<option value="CT">Connecticut</option>
														<option value="DE">Delaware</option>
														<option value="FL">Florida</option>
														<option value="GA">Georgia</option>
														<option value="IN">Indiana</option>
														<option value="ME">Maine</option>
														<option value="MD">Maryland</option>
														<option value="MA">Massachusetts</option>
														<option value="MI">Michigan</option>
														<option value="NH">New Hampshire</option>
														<option value="NJ">New Jersey</option>
														<option value="NY">New York</option>
														<option value="NC">North Carolina</option>
														<option value="OH">Ohio</option>
														<option value="PA">Pennsylvania</option>
														<option value="RI">Rhode Island</option>
														<option value="SC">South Carolina</option>
														<option value="VT">Vermont</option>
														<option value="VA">Virginia</option>
														<option value="WV">West Virginia</option>
													</optgroup>
												</select>
											</div>
										</div>
									</div>
									<div class="separator-solid"></div>
									<div class="form-group form-show-validation row">
										<label class="col-lg-3 col-md-3 col-sm-4 mt-sm-2 text-right">Upload Image <span class="required-label">*</span></label>
										<div class="col-lg-4 col-md-9 col-sm-8">
											<div class="input-file input-file-image">
												<img class="img-upload-preview img-circle" width="100" height="100" src="http://placehold.it/100x100" alt="preview">
												<input type="file" class="form-control form-control-file" id="uploadImg" name="uploadImg" accept="image/*" required >
												<label for="uploadImg" class="btn btn-primary btn-round btn-lg"><i class="fa fa-file-image"></i> Upload a Image</label>
											</div>
										</div>
									</div>
									<div class="form-check">
										<div class="row">
											<label class="col-lg-3 col-md-3 col-sm-4 mt-sm-2 text-right">Agree <span class="required-label">*</span></label>
											<div class="col-lg-4 col-md-9 col-sm-8 d-flex align-items-center">
												<div class="custom-control custom-checkbox">
													<input type="checkbox" class="custom-control-input" id="agree" name="agree" required>
													<label class="custom-control-label" for="agree">Agree with terms and conditions</label>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="card-action">
									<div class="row">
										<div class="col-md-12">
											<input class="btn btn-success" type="submit" value="Validate">
											<button class="btn btn-danger">Cancel</button>
										</div>										
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>

<?php
	include_once("footer.php");
?>