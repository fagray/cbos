<!DOCTYPE html>
<html>
    
    <head>
        <title>aces eGlobal | Admin Dashboard</title>
        <!-- Bootstrap -->
        <link href="<?php print base_url('public/assets/bootstrap/css/bootstrap.css') ?>" rel="stylesheet" media="screen">
        <link href="<?php print base_url('public/assets/css/styles.css') ?>" rel="stylesheet" media="screen">
        <link href="<?php print base_url('public/assets/css/font-awesome.css') ?>" rel="stylesheet" media="screen">
        <link href="<?php print base_url('public/assets/vendors/pace/flash-theme.css') ?>" rel="stylesheet" media="screen">
        <link href="<?php print base_url('public/assets/vendors/data-tables/jquery.dataTables.min.css') ?>" rel="stylesheet" media="screen">
        <link href="<?php print base_url('public/assets/vendors/data-tables/dataTables.tableTools.css') ?>" rel="stylesheet" media="screen">
        <link href="<?php print base_url('public/assets/vendors/data-tables/dataTables.bootstrap.css') ?>" rel="stylesheet" media="screen">
        <link rel="stylesheet" type="text/css" href="<?php print base_url('public/assets/vendors/datepicker/jquery.datetimepicker.css') ?>">
        <link rel="stylesheet" type="text/css" href="<?php print base_url('public/assets/vendors/dialog/dialog.css') ?> ">    
    </head>
     <body>

     <div style="padding:10px;margin-right:0px;background: #0099FF;position:relative;bottom:60px !important;" class="row">
        <div class="container">
          <div class="col-md-12">

          <div style="margin-top:60px;" class="col-md-4">
            <?php if($this->session->has_userdata('panel_access_token')){ 
              ?>
              
            <h3 style="color:#fff !important;" >Welcome : <?php print $this->session->userdata('usrname'); ?> 
                  </h3><br/><br/>
                 <p style="color:#fff !important" class="text-left">Last Logged in : <?php print $this->session->userdata('last_login'); ?></p>
                 <p style="color:#fff !important;">Current Time : <?php print date('D, M d, Y G:i:s'); ?></p>
                 <p style="color:#fff !important" class="text-left">Administrator Panel </p>
            <?php } ?>

            <?php if( ! $this->session->has_userdata('panel_access_token')){ ?>
              <h4 style="color:#fff !important;" >Welcome to CBOS Online Banking
                  </h4><br/><br/>
                 <p style="color:#fff !important" class="text-left">Administrator Panel </p>


            <?php } ?>
          </div><!-- /col-md-6 -->  


          <div style="margin-top:60px;" class="col-md-offset-5 col-md-3  ">
            <img class="img-responsive"  src="<?php print base_url('public/assets/img/cbos.png') ?>">
            <h4 style="color:#fff !important" class="text-left">Online Banking Application</h4>
          </div><!-- /col-md-6 -->

        </div><!-- /col-md-12 -->
        </div>
        
       </div><!-- /row -->

    <!-- content -->
     <div class="container">  
                <span id="base_url" data-value="<?php print base_url(); ?>"></span>
                <div class="row">
                  <div class="col-lg-8 col-md-7 col-sm-6">
                    <?php 

                        if($this->session->has_userdata('msg')){ ?>

                        <div class="alert alert-info">
                          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                          <?php print $this->session->userdata('msg'); ?>
                        </div>



                     <?php } ?>
                    <h4>welcome to aces eGlobal online banking application</h4>
                  </div>
                </div><!-- /row -->
            <hr/>