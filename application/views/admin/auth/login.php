<!DOCTYPE html>
<html class="no-js">
    
    <head>
        <title>acesglobal | Main Panel </title>
        <!-- Bootstrap -->
        <link href="<?php print base_url('public/assets/bootstrap/css/bootstrap.css') ?>" rel="stylesheet" media="screen">
        <link href="<?php print base_url('public/assets/css/styles.css') ?>" rel="stylesheet" media="screen">
        <link href="<?php print base_url('public/assets/css/font-awesome.css') ?>" rel="stylesheet" media="screen">
        <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
        <!--[if lt IE 9]>
            <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
    </head>
    
    <body>
         <div class="navbar navbar-default navbar-fixed-top">
          <div class="container">
            <div class="navbar-header">
              <a href="<?php print base_url('acesmain/home') ?>" class="navbar-brand">aceseb online banking</a>
              <button class="navbar-toggle" type="button" data-toggle="collapse" data-target="#navbar-main">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>
            </div>
            <div class="navbar-collapse collapse" id="navbar-main">
              <ul class="nav navbar-nav">
        
              </ul>

              <ul class="nav navbar-nav navbar-right">
            
            </div>
          </div>
        </div>

        <!-- /content -->
        <div class="container">

            <div class=" row">
             <?php print hash('sha1', 'raymund') ?>
                <div class="col-md-offset-3 col-md-6">
                     <div class="panel panel-default">
                                <div class="panel-heading blue-bg ">
                                    <i class="fa fa-lock"></i> Authorized Login
                                </div>
                                <div class="panel-body">
                                    <?php if($this->session->flashdata('msg')){ ?>
                                        <div class="alert alert-danger">
                                            <?php print $this->session->flashdata('msg'); ?>
                                        </div>
                                    <?php } ?>
                                    <?php echo form_open('acesmain/auth/validate') ?>
                                        <div class="form-group">
                                            <label for="">Username</label>
                                            <?php echo form_input('usr_id','',array('type' => 'text','class' => 'form-control span3')); ?>
                                        </div>

                                         <div class="form-group">
                                            <label for="">Password</label>
                                            <?php echo form_password('usr_password','',array('type' => 'password','class' => 'span3 form-control')); ?>
                                        </div>
                                        <?php echo form_submit('', 'Login',array('class' =>  'btn btn-default')); ?>
                                    <?php echo form_close(); ?>
                                </div>
                            </div>
                            <!-- /block -->
                </div><!-- /span6 -->
            </div>
             <hr>
            <footer>
                <p>&copy; Aces Global Online Banking System</p>
            </footer>
        </div>    <!-- /container -->
        
     
        <!--/.fluid-container-->
        <script src="<?php print base_url('public/assets/js/jquery.js') ?>"></script>
        <script src="<?php print base_url('public/assets/bootstrap/js/bootstrap.js') ?>"></script>
        <script type="text/javascript">

             $('div.alert').delay(5000).slideUp();

        </script>

       
    </body>

</html>