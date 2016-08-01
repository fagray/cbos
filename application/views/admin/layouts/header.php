<!DOCTYPE html>
<html>
    
    <head>
        <title>CBOS Online Banking| Admin Dashboard</title>
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

     <div style="padding:10px;margin-right:0px;background-image:url('<?php print base_url('public/assets/img/cbos-header.jpg') ?>');height:320px;position:relative;bottom:60px !important;" class="row">
        <div class="container">
          <div class="col-md-12">

         

      

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
                   
                  </div>
                </div><!-- /row -->
    