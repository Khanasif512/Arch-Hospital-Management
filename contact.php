<?php
	include_once("header.php");
?>		

<section id="page_wrapper">
	<div class="bg-color">
		<div class="container">
			<div class="page_title pull-left">
				<h1>Contact Us</h1>
			</div>
			<ol class="breadcrumb pull-right">
				<li><a href="http://esteemsoftbd.com">Home</a></li>
				<li class="active">Contact Us</li>
			</ol>
		</div>
	</div>
</section>
<!---------- Contact Us Starts ---------->
<section class="gmap">
	<!----------  Google Maps Starts ---------->
	<div id="map" style="width:100%;height:400px">
		<iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d7300.366943704463!2d90.430143!3d23.812074!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x50da43ea369fbaa4!2sEsteem+Soft+Limited!5e0!3m2!1sen!2sbd!4v1562136013787!5m2!1sen!2sbd" width="" height="" frameborder="0" style="border:0" allowfullscreen></iframe>
	</div>						
	<!----------  Google Maps Ends ---------->
</section>
<section id="contact-us">
	<div class="contact-info">
		<div class="container">
			<!----- Write To Us Starts ----->
			<!-- <div class="col-md-6 wow zoomIn" data-wow-duration="1.5s" data-wow-delay=".5s">
				<div class="contact-form-wrapper">
					<h3 class="text-center">WRITE TO US</h3>
					<div class="form-wrapper">
						<form action="" id="requestCallback" method="post">
							<div class="col-md-12">
								<div class="form-group">
									<select class="form-control" name="type">
										<option value="Subject">Subject</option>
										<option value="Inquiry">Inquiry</option>
										<option value="Complaint">Complaint</option>
										<option value="Suggestion">Suggestion</option>
										<option value="Other">Other</option>
									</select>
								</div>
							</div>
							<div class="col-md-12">
								<div class="form-group">
									<input type="text" required="" name="fname" class="form-control" id="FirstName" placeholder="First Name">
								</div>
							</div>
							<div class="col-md-12">
								<div class="form-group">
									<input type="text" required="" name="lname" class="form-control" id="LastName" placeholder="Last Name">
								</div>
							</div>
							<div class="col-md-12">
								<div class="form-group">
									<input type="email" required="" name="mail" class="form-control" id="email" placeholder="Email">
								</div>
							</div>
							<div class="col-md-12">
								<div class="form-group">
									<input type="number" required="" name="number" class="form-control" placeholder="Phone Number">
								</div>
							</div>
							<div class="col-md-12">
								<div class="form-group">
									<textarea type="text" required="" name="text" class="form-control" rows="10" placeholder="Enter Your Message"></textarea>
								</div>
							</div>
							<div class="col-md-4 text-center col-md-offset-4">
								<input type="submit" class="btn btn-default btn-lg" name="send_mail">
							</div>
						</form>
					</div>
				</div>
			</div> -->
			<!----- Write To Us Ends ----->
			<!----- Get In Touch With Us Starts ----->
			<div class="col-md-12 col-sm-12 get-touch wow zoomIn" data-wow-duration="1.5s" data-wow-delay=".5s">
				<div class="touch-title mr-bottom-30">
					<h2>GET IN TOUCH WITH US</h2>
				</div>
				<div class="col-md-4">
					<div class="contact-item">
						<div class="icon pull-left">
							<i aria-hidden="true" class="fa fa-phone fa-fw fa-3x"></i>
						</div>
						<div class="contact-no">
							<h3>Give us a ring</h3>
							<p><strong>Mobile:</strong> +88018 4400 4911, +88018 4400 4901<br><strong>Phone:</strong> +88 02 843 1595-6, +88 02 843 1946</p>
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="contact-item">
						<div class="icon pull-left">
							<i aria-hidden="true" class="fa fa-map-marker fa-fw fa-3x"></i>
						</div>
						<div class="contact-address">
							<h3>Find us at the office</h3>
							<p>House # 77, Level # 2&amp;3, Road # 02, Block # A,<br> Bashundhara R/A, Dhaka-1229, Bangladesh</p>
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="contact-item">
						<div class="icon pull-left">
							<i aria-hidden="true" class="fa fa-map-marker fa-fw fa-3x"></i>
						</div>
						<div class="contact-address">
							<h3>USA Office</h3>
							<p>37-38 73RD Street, Jackson Heights,<br> NY 11372, USA</p>
						</div>
					</div>
				</div>
			</div>
			<!----- Get In Touch With Us Starts Starts ----->
		</div>
	</div>
</section>
<!---------- Contact Us Ends ---------->
<!----- Google Maps ----->
<!-- <script>
	function initMap() {
		var esteem = {lat: 23.812079, lng: 90.430155};
		var map = new google.maps.Map(document.getElementById('map'), {
		  zoom: 18,
		  center: esteem
		});
		var marker = new google.maps.Marker({
		  position: esteem,
		  map: map,
		  animation: google.maps.Animation.BOUNCE
		});
	}
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCCYjVP4dFYnqgJijBDCDYLI_shd5R1P9I&callback=initMap"></script> -->
<!----- Google Maps ----->
<style type="text/css">
	#contact-us {
	    padding: 100px 0 200px;
	}
	@media (max-width: 480px){
		.contact-item .icon {
		    float: none!important;
		    margin: 1em 0;
		    text-align: center;
		}
		.get-touch .contact-item h3 {
		    text-align: center;
		}
	}
	@media (min-width: 1024px) and (max-width: 1200px){
		.contact-item {
		    min-height: 18em;
		}
	}
	@media (min-width: 1024px) {		
		.contact-item .icon {
		    float: none!important;
		    margin: 1em 0 0;
		    text-align: center;
		}
		.get-touch .contact-item h3 {
		    text-align: center;
		}
	}
	@media (min-width: 1366px){
		.contact-item {
		    min-height: 15em;
		}
	}
</style>
<?php
	include_once("footer.php");
?>