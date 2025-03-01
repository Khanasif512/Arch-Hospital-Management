<?php
	include_once("header.php");
	include_once("menu.php");
?>						
	
	<div class="main-panel">
			<div class="container">
				<div class="page-inner">
					<div class="page-header">
						<h4 class="page-title">Form Widget</h4>
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
								<a href="#">Form Widget</a>
							</li>
						</ul>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="card">
								<div class="card-header">
									<h4 class="card-title">Bootstrap Datetimepicker</h4>
								</div>
								<div class="card-body">
									<div class="row">
										<div class="col-md-4">
											<div class="form-group">
												<label>Input DateTime Picker</label>
												<div class="input-group">
													<input type="text" class="form-control" id="datetime" name="datetime">
													<div class="input-group-append">
														<span class="input-group-text">
															<i class="fa fa-calendar"></i>
														</span>
													</div>
												</div>
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<label>Input Date Picker</label>
												<div class="input-group">
													<input type="text" class="form-control" id="datepicker" name="datepicker">
													<div class="input-group-append">
														<span class="input-group-text">
															<i class="fa fa-calendar-check"></i>
														</span>
													</div>
												</div>
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<label>Input Time Picker</label>
												<div class="input-group">
													<input type="text" class="form-control" id="timepicker" name="timepicker">
													<div class="input-group-append">
														<span class="input-group-text">
															<i class="fa fa-clock"></i>
														</span>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-12">
							<div class="card">
								<div class="card-header">
									<h4 class="card-title">Select2</h4>
								</div>
								<div class="card-body">
									<div class="row">
										<div class="col-md-4">
											<div class="form-group">
												<label>Basic</label>
												<div class="select2-input">
													<select id="basic" name="basic" class="form-control">
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
										<div class="col-md-4">
											<div class="form-group">
												<label>Multiple</label>
												<div class="select2-input">
													<select id="multiple" name="multiple[]" class="form-control" multiple="multiple">
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
										<div class="col-md-4">
											<div class="form-group">
												<label>Multiple States</label>
												<div class="select2-input select2-warning">
													<select id="multiple-states" name="multiple2[]" class="form-control" multiple="multiple">
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
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-12">
							<div class="card">
								<div class="card-header">
									<h4 class="card-title">Bootstrap Tagsinput</h4>
								</div>
								<div class="card-body">
									<div class="row">
										<div class="col-md-12">
											<div class="form-group">
												<input type="text" id="tagsinput" class="form-control" value="Amsterdam,Washington,Sydney,Beijing,Cairo" data-role="tagsinput">
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-12">
							<div class="card">
								<div class="card-header">
									<h4 class="card-title">Input File Image</h4>
								</div>
								<div class="card-body">
									<div class="row">
										<div class="col-md-3">
											<div class="input-file input-file-image">
												<img class="img-upload-preview" width="150" src="http://placehold.it/150x150" alt="preview">
												<input type="file" class="form-control form-control-file" id="uploadImg2" name="uploadImg2" accept="image/*" required="">
												<label for="uploadImg2" class="  label-input-file btn btn-black btn-round">
													<span class="btn-label">
														<i class="fa fa-file-image"></i>
													</span>
													Upload a Image
												</label>
											</div>
										</div>
										<div class="col-md-3">
											<div class="input-file input-file-image">
												<img class="img-upload-preview img-circle" width="100" height="100" src="http://placehold.it/100x100" alt="preview">
												<input type="file" class="form-control form-control-file" id="uploadImg1" name="uploadImg1" accept="image/*" required="">
												<label for="uploadImg1" class="  label-input-file btn btn-black btn-round">
													<span class="btn-label">
														<i class="fa fa-file-image"></i>
													</span>
													Upload a Image
												</label>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-12">
							<div class="card">
								<div class="card-header">
									<h4 class="card-title">Checkbox</h4>
								</div>
								<div class="card-body">
									
									<div class="form-check form-check-inline">
										<div class="custom-control custom-checkbox">
											<input type="checkbox" class="custom-control-input" id="customCheck1">
											<label class="custom-control-label" for="customCheck1">Unchecked</label>
										</div>

										<div class="custom-control custom-checkbox">
											<input type="checkbox" class="custom-control-input" id="customCheck2" checked>
											<label class="custom-control-label" for="customCheck1">Checked</label>
										</div>

										<div class="custom-control custom-checkbox">
											<input type="checkbox" class="custom-control-input" id="customCheck3" disabled>
											<label class="custom-control-label" for="customCheck1">Disabled</label>
										</div>

										<div class="custom-control custom-checkbox">
											<input type="checkbox" class="custom-control-input" id="customCheck4" checked disabled>
											<label class="custom-control-label" for="customCheck1">Checked Disabled</label>
										</div>
									</div>
									
								</div>
							</div>
						</div>
						<div class="col-md-12">
							<div class="card">
								<div class="card-header">
									<h4 class="card-title">Radio</h4>
								</div>
								<div class="card-body">
									<div class="form-check form-check-inline">
										<div class="custom-control custom-radio">
											<input type="radio" id="customRadio1" name="customRadio" class="custom-control-input">
											<label class="custom-control-label" for="customRadio1">Unchecked</label>
										</div>
										<div class="custom-control custom-radio">
											<input type="radio" id="customRadio2" name="customRadio" class="custom-control-input" checked>
											<label class="custom-control-label" for="customRadio2">Checked</label>
										</div>
										<div class="custom-control custom-radio">
											<input type="radio" id="customRadio3" name="customRadioDisabled" class="custom-control-input" disabled>
											<label class="custom-control-label" for="customRadio3">Disabled</label>
										</div>
										<div class="custom-control custom-radio">
											<input type="radio" id="customRadio4" name="customRadioDisabled" class="custom-control-input" checked disabled>
											<label class="custom-control-label" for="customRadio4">Checked Disabled</label>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-12">
							<div class="card">
								<div class="card-header">
									<h4 class="card-title">Bootstrap Switch</h4>
								</div>
								<div class="card-body">
									<p class="demo">
										<input type="checkbox" checked data-toggle="toggle" data-onstyle="default">
										<input type="checkbox" checked data-toggle="toggle" data-onstyle="primary">
										<input type="checkbox" checked data-toggle="toggle" data-onstyle="success">
										<input type="checkbox" checked data-toggle="toggle" data-onstyle="info">
										<input type="checkbox" checked data-toggle="toggle" data-onstyle="warning">
										<input type="checkbox" checked data-toggle="toggle" data-onstyle="danger">
									</p>
									<p class="demo">
										<input type="checkbox" checked data-toggle="toggle" data-onstyle="default" data-style="btn-round">
										<input type="checkbox" checked data-toggle="toggle" data-onstyle="primary" data-style="btn-round">
										<input type="checkbox" checked data-toggle="toggle" data-onstyle="success" data-style="btn-round">
										<input type="checkbox" checked data-toggle="toggle" data-onstyle="info" data-style="btn-round">
										<input type="checkbox" checked data-toggle="toggle" data-onstyle="warning" data-style="btn-round">
										<input type="checkbox" checked data-toggle="toggle" data-onstyle="danger" data-style="btn-round">
									</p>
								</div>
							</div>
						</div>
						<div class="col-md-12">
							<div class="card">
								<div class="card-header">
									<h4 class="card-title">Bootstrap Dropdown</h4>
								</div>
								<div class="card-body">
									<div class="demo">
										<div class="btn-group dropdown">
											<button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">
												DropDown
											</button>
											<ul class="dropdown-menu" role="menu">
												<li>
													<a class="dropdown-item" href="#">Action</a>
													<a class="dropdown-item" href="#">Another action</a>
													<div class="dropdown-divider"></div>
													<a class="dropdown-item" href="#">Something else here</a>
												</li>
											</ul>

										</div>

										<div class="btn-group dropup">
											<button class="btn btn-info dropdown-toggle" type="button" data-toggle="dropdown">
												DropUp
											</button>
											<ul class="dropdown-menu" role="menu">
												<li>
													<a class="dropdown-item" href="#">Action</a>
													<a class="dropdown-item" href="#">Another action</a>
													<div class="dropdown-divider"></div>
													<a class="dropdown-item" href="#">Something else here</a>
												</li>
											</ul>
										</div>

										<div class="btn-group dropright">
											<button type="button" class="btn btn-success btn-round dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
												DropRight
											</button>
											<ul class="dropdown-menu" role="menu">
												<li>
													<a class="dropdown-item" href="#">Action</a>
													<a class="dropdown-item" href="#">Another action</a>
													<div class="dropdown-divider"></div>
													<a class="dropdown-item" href="#">Something else here</a>
												</li>
											</ul>
										</div>

										<div class="btn-group dropleft">
											<button type="button" class="btn btn-black btn-border dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
												DropLeft
											</button>
											<ul class="dropdown-menu" role="menu">
												<li>
													<a class="dropdown-item" href="#">Action</a>
													<a class="dropdown-item" href="#">Another action</a>
													<div class="dropdown-divider"></div>
													<a class="dropdown-item" href="#">Something else here</a>
												</li>
											</ul>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-12">
							<div class="card">
								<div class="card-header">
									<h4 class="card-title">Progress Bar</h4>
								</div>
								<div class="card-body">
									<div class="row">
										<div class="col-md-6">
											<div class="demo">
												<div class="progress-card">
													<div class="progress-status">
														<span class="text-muted">Profit</span>
														<span class="text-muted"> $3K</span>
													</div>
													<div class="progress" style="height: 2px;">
														<div class="progress-bar bg-success" role="progressbar" style="width: 78%" aria-valuenow="78" aria-valuemin="0" aria-valuemax="100" data-toggle="tooltip" data-placement="top" title="" data-original-title="78%"></div>
													</div>
												</div>
											</div>
											<div class="demo">
												<div class="progress-card">
													<div class="progress-status">
														<span class="text-muted">Orders</span>
														<span class="text-muted"> 576</span>
													</div>
													<div class="progress" style="height: 4px;">
														<div class="progress-bar bg-info" role="progressbar" style="width: 65%" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" data-toggle="tooltip" data-placement="top" title="" data-original-title="65%"></div>
													</div>
												</div>
											</div>
											<div class="demo">
												<div class="progress-card">
													<div class="progress-status">
														<span class="text-muted">Tasks Complete</span>
														<span class="text-muted fw-bold"> 70%</span>
													</div>
													<div class="progress" style="height: 6px;">
														<div class="progress-bar bg-primary" role="progressbar" style="width: 70%" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" data-toggle="tooltip" data-placement="top" title="" data-original-title="70%"></div>
													</div>
												</div>
											</div>
											<div class="demo">
												<div class="progress-card">
													<div class="progress-status">
														<span class="text-muted">Open Rate</span>
														<span class="text-muted fw-bold"> 60%</span>
													</div>
													<div class="progress">
														<div class="progress-bar progress-bar-striped bg-warning" role="progressbar" style="width: 60%" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" data-toggle="tooltip" data-placement="top" title="" data-original-title="60%"></div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-12">
							<div class="card">
								<div class="card-header">
									<h4 class="card-title">Nav Pills</h4>
								</div>
								<div class="card-body">
									<ul class="nav nav-pills nav-primary">
										<li class="nav-item">
											<a class="nav-link active" href="#">Active</a>
										</li>
										<li class="nav-item">
											<a class="nav-link" href="#">Link</a>
										</li>
										<li class="nav-item">
											<a class="nav-link" href="#">Link</a>
										</li>
										<li class="nav-item">
											<a class="nav-link disabled" href="#">Disabled</a>
										</li>
									</ul>
								</div>
							</div>
						</div>
						<div class="col-md-12">
							<div class="card">
								<div class="card-header">
									<h4 class="card-title">Slider</h4>
								</div>
								<div class="card-body">
									<div class="demo">
										<div class="row">
											<div class="col-md-6">
												<div id="slider" class="slider-primary"></div>

												<div id="slider-range" class="slider-success"></div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-12">
							<div class="card">
								<div class="card-header">
									<h4 class="card-title">Badge</h4>
								</div>
								<div class="card-body">
									<span class="badge badge-count">Count</span>
									<span class="badge badge-black">Default</span>
									<span class="badge badge-primary">Primary</span>
									<span class="badge badge-info">Info</span>
									<span class="badge badge-success">Success</span>
									<span class="badge badge-warning">Warning</span>
									<span class="badge badge-danger">Danger</span>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

<?php
	include_once("footer.php");
?>