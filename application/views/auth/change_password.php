        <!-- /content -->
        <div class="container">
            <?php $this->load->view('layouts/main-header') ?>
            <div class="row">
              <?php $this->load->view('layouts/sidebar') ?>
            <div class="col-md-9" id="content">
                <h3>Change  Password</h3>
                    <!-- panel -->
                        <div class="panel panel-default">
                            <div class="blue-bg panel-heading">
                               Password Details
                            </div>

                            <div class="panel-body ">
                            <p>You will be redirected back to the login page once your password is successfully changed.</p>
                              <?php if($this->session->flashdata('msg')){ ?>
                                        <div class="alert alert-danger">
                                            <?php print $this->session->flashdata('msg'); ?>
                                        </div>
                                    <?php } ?>
                                <div class="col-md-12">
                                   <?php echo form_open('accounts/post_change_password') ?>
                                        <div class="form-group">
                                            <label for="">Old Password</label>
                                            <?php echo form_password('old_password','',array('type' => 'password','class' => 'form-control span3')); ?>
                                        </div>

                                         <div class="form-group">
                                            <label for="">New Password</label>
                                            <?php echo form_password('new_pass1','',array('type' => 'password','class' => 'span3 form-control')); ?>
                                        </div>
                                         <div class="form-group">
                                            <label for="">Confirm New Password</label>
                                            <?php echo form_password('new_pass2','',array('type' => 'password','class' => 'span3 form-control')); ?>
                                            <span id="msg"></span>
                                        </div>
                                        <?php echo form_hidden('_exst_token',random_string('md5',12)); ?>
                                        <?php echo form_hidden('_origin',uri_string()); ?>
                                        <?php echo form_submit('', 'Change Password',array('class' =>  'btn btn-default')); ?>
                                    <?php echo form_close(); ?>
                                </div>
                            </div>
                        </div>
                        <!-- /panel -->
                </div><!-- /content -->
            </div>    <!-- /row -->
        <hr>
        <?php $this->load->view('layouts/footer') ?>
          <script type="text/javascript">
            $(document).ready(function(){

                $btn_submit = $('input[type="submit"]');
                $pass_field1 =  $('input[name="new_pass1"]');
                $pass_field2 =  $('input[name="new_pass2"]');

                $btn_submit.attr("disabled","disabled");

                $('input[name="new_pass2"]').keyup(function(){

                    $pass1_value = $pass_field1.val();
                    $value = $(this).val();

                    if ( $value != $pass1_value  ){

                        $('span#msg').html('Password do not match.').css("color","#ff0000");

                    
                    }else{

                         $('span#msg').html("Password matched.").css("color","#006633");
                         $btn_submit.removeAttr("disabled");
                    }

                });
            });
        </script>
    </body>

</html>