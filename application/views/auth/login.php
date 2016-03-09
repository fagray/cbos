<?php $this->load->view('layouts/header') ?>

        <!-- /content -->
        <div class="container">
            <div class=" row">
                <div class="col-md-offset-1 col-md-4">
                    <span id="banking-tips">
                        <p style="font-size:12px;padding:20px;margin-top:0px;">
                        <img class="img-responsive" src="<?php print base_url('public/assets/img/lock.png') ?>">
                        <h4>Online Banking Security Tips</h4>
                            <ul>
                                <li> 1. Securely manage your password.</li>
                                <li> 2. Protect your computer against viruses, 
                                        malicious programs, and hacking attacks</li>
                                <li> 3. Do not become a victim of Phishing 
                                        attacks.
                                </li>
                                <li>
                                     4. Logoff and close the browser after 
                                    completing your transactions.
                                </li>
                            </ul>
                          
                            </p>
                    </span>
                  
                   
                </div><!-- /col-md-4 -->

                <div class="col-md-offset-1 col-md-6">
                    <p align="center">
                        <i class="fa fa-lock "></i> Access your CBOS Account Online
                    </p><hr/>
                     <div class="panel panel-default">
                                <div class="blue-bg panel-heading">
                                  Account Login
                                </div>
                                <div class="panel-body">
                                    <?php if( $this->session->flashdata('msg')){ ?>
                                        <div class="alert alert-danger">
                                            <?php print $this->session->flashdata('msg'); ?>
                                        </div>
                                    <?php } ?>
                                    <?php if( $this->session->flashdata('msg-success')){ ?>
                                        <div class="alert alert-success">
                                            <?php print $this->session->flashdata('msg-success'); ?>
                                        </div>
                                    <?php } ?>

                                    <?php echo form_open('auth/validate') ?>
                                        <div class="form-group">
                                            <label for="">Username</label>
                                            <?php echo form_input('usr_id','',array('type' => 'text','class' => 'form-control ')); ?>
                                        </div>

                                         <div class="form-group">
                                            <label for="">Password</label>
                                            <?php echo form_password('usr_password','',array('type' => 'password','class' => ' form-control')); ?>
                                        </div>
                                        <?php echo form_submit('', 'Login to my account',array('class' =>  'btn btn-default')); ?>
                                    <?php echo form_close(); ?>
                                </div>
                            </div>
                            <!-- /block -->
                </div><!-- /col-md-6 -->
                
            </div>
             <hr>
           <footer>
               <span style="color:#09F;">aces EGlobal, Inc.</span>  
                <img style="" src="<?php print base_url('public/assets/img/aces.png') ?>">
            </footer>
        </div>    <!-- /container -->
        
     
        <!--/.fluid-container-->
        <script src="<?php print base_url('public/assets/js/jquery.js') ?>"></script>
        <script src="<?php print base_url('public/assets/bootstrap/js/bootstrap.js') ?>"></script>
        <script src="<?php print base_url('public/assets/vendors/pace/pace.min.js') ?>"></script>

        <script type="text/javascript">

             $('div.alert').delay(5000).slideUp();

        </script>

       
    </body>

</html>   
        