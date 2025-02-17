<?php
require_once("../main_function.php");
$obj= new operation;    
require_once("class/inistitute.php");
require_once("class/organization.php");
if (isset($_GET['status'])) {
  if(session_destroy()){
  header("Location: index.php");
}
}

$inst=new Innistitute;
$org=new Organization;
$date=date("Y-m-d");


include_once("header.php");
include_once("menu.php");
?>	
<div class="main-panel dashboard">
	<div class="container">
		<center><b><?php $flash->display(); ?></b></center>
		<div class="panel-header bg-primary-gradient">
			<div class="page-inner py-5">
				<div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
					<div>
						<h2 class="text-white pb-2 fw-bold">Dashboard</h2>

					</div>
					<!-- <div class="ml-md-auto py-2 py-md-0">
						<a href="#" class="btn btn-white btn-border btn-round mr-2">Manage</a>
						<a href="#" class="btn btn-secondary btn-round">Add Customer</a>
					</div> -->
				</div>
			</div>
		</div>
		
		</div>
	</div>
<?php include_once("footer.php"); ?>	

<script>
		//Witty Todays Request
		Circles.create({
			id:'circles-1',
			radius:45,
			value:<?php echo ($todays_witty_req->num*5) ;?>,
			maxValue:100,
			width:7,
			text: <?php echo $todays_witty_req->num ;?>,
			colors:['#f1f1f1', '#FF9E27'],
			duration:400,
			wrpClass:'circles-wrp',
			textClass:'circles-text',
			styleWrapper:true,
			styleText:true
		})

		Circles.create({
			id:'circles-2',
			radius:45,
			value: <?php echo ($todays_witty_price_req->num*5) ; ?>,
			maxValue:100,
			width:7,
			text: <?php echo $todays_witty_price_req->num ; ?>,
			colors:['#f1f1f1', '#2BB930'],
			duration:400,
			wrpClass:'circles-wrp',
			textClass:'circles-text',
			styleWrapper:true,
			styleText:true
		})

		Circles.create({
			id:'circles-3',
			radius:45,
			value:<?php echo ($todays_witty_demo_req->num*5) ; ?>,
			maxValue:100,
			width:7,
			text: <?php echo $todays_witty_demo_req->num ; ?>,
			colors:['#f1f1f1', '#F25961'],
			duration:400,
			wrpClass:'circles-wrp',
			textClass:'circles-text',
			styleWrapper:true,
			styleText:true
		})
		//Arch Todays Request
		Circles.create({
			id:'circles-4',
			radius:45,
			value:<?php echo ($todays_arch_req->num*5) ; ?>,
			maxValue:100,
			width:7,
			text: <?php echo $todays_arch_req->num ; ?>,
			colors:['#f1f1f1', '#FF9E27'],
			duration:400,
			wrpClass:'circles-wrp',
			textClass:'circles-text',
			styleWrapper:true,
			styleText:true
		})

		Circles.create({
			id:'circles-5',
			radius:45,
			value:<?php echo ($todays_arch_price_req->num*5) ; ?>,
			maxValue:100,
			width:7,
			text: <?php echo $todays_arch_price_req->num ; ?>,
			colors:['#f1f1f1', '#2BB930'],
			duration:400,
			wrpClass:'circles-wrp',
			textClass:'circles-text',
			styleWrapper:true,
			styleText:true
		})

		Circles.create({
			id:'circles-6',
			radius:45,
			value:<?php echo ($todays_arch_demo_req->num*5) ; ?>,
			maxValue:100,
			width:7,
			text: <?php echo $todays_arch_demo_req->num ; ?>,
			colors:['#f1f1f1', '#F25961'],
			duration:400,
			wrpClass:'circles-wrp',
			textClass:'circles-text',
			styleWrapper:true,
			styleText:true
		})
	</script>