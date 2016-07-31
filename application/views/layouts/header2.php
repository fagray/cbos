<!DOCTYPE html>
<html>
    
    <head>
        <title>CBOS Online Banking | User Dashboard</title>
        <!-- Bootstrap -->
        <link href="<?php print base_url('public/assets/bootstrap/css/bootstrap.css') ?>" rel="stylesheet" media="screen">
        <link href="<?php print base_url('public/assets/css/styles.css') ?>" rel="stylesheet" media="screen">
        <link href="<?php print base_url('public/assets/css/font-awesome.css') ?>" rel="stylesheet" media="screen">
        <link href="<?php print base_url('public/assets/vendors/chosen/chosen.min.css') ?>" rel="stylesheet" media="screen">
 		<link rel="stylesheet" type="text/css" href="<?php print base_url('public/assets/vendors/datepicker/jquery.datetimepicker.css') ?>">    
        <link href="<?php print base_url('public/assets/vendors/pace/flash-theme.css') ?>" rel="stylesheet" media="screen">
        
 		</head>
     <body>
     	<span id="base" data-value="<?php print base_url(); ?>"></span>
	        <div  class="navbar navbar-default">
		      <div class="container">
		        <div class="navbar-header">

			        <div class="cbos-logo" >
			    		<img  src="<?php print base_url('public/assets/img/cbos.png') ?>">
			    		<h4>Online Banking Application</h4>
			    	</div>

			    	<div class="client-info">
	          			<h5>Welcome : <?php print $this->session->userdata('client_name'); ?> 
		              	</h5><br/>
		               <p>Last Logged in : <?php print $this->session->userdata('last_login'); ?></p>
	          		</div><!-- /client-info -->


		         <!--  <a href="<?php print base_url('acesmain/home') ?>" class="navbar-brand">CBOS Online Banking Application</a> -->
		          <!-- <button class="navbar-toggle" type="button" data-toggle="collapse" data-target="#navbar-main"> -->
		           <!--  <span class="icon-bar"></span>
		            <span class="icon-bar"></span>
		            <span class="icon-bar"></span> -->
		          </button>

		        </div> <!-- /navbar-header -->
		       <div class="navbar-collapse collapse" id="navbar-main">
		          <ul class="nav navbar-nav">
		    			
		          </ul>

		          <ul class="nav navbar-nav navbar-right">
		          	<!-- <img  src="<?php print base_url('public/assets/img/cbos.png') ?>"> -->
		          </ul>

		        </div> <!-- /navbar-main -->
		      </div>
		    </div> <!-- /navbar -->

		    <div class="container">
		    <div class="row">

	          	<div class="col-md-offset-1 col-md-4">

	          	<!-- 	<div class="clsient-info">
	          			<h5>Welcome : <?php print $this->session->userdata('client_name'); ?> 
		              	</h5>
		               <p>Last Logged in : <?php print $this->session->userdata('last_login'); ?></p>
	          		</div> --><!-- /client-info -->
		           
	            </div><!-- /span3 -->
				 </div><!-- /row -->

		    	<div class="cbdos-logo" >
		    		<!-- <img  src="<?php print base_url('public/assets/img/cbos.png') ?>"> -->
		    	</div>

		    </div>
			<!-- <div style="position: relative;top:90px;"></div> -->