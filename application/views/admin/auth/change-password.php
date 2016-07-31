
        <div class="row">
              <?php $this->load->view('admin/layouts/sidebar') ?>
            <div class="col-md-9" id="content">
                    <h3> Change Password </h3>
                    <!-- block -->
                        <div class="panel panel-default ">
                            <div class="blue-bg panel-heading ">
                                CHANGE PASSWORD
                            </div>
                            <div class="panel-body">
                               <?php if($this->session->flashdata('msg')){ ?>
                                        <div class="alert alert-danger">
                                            <?php print $this->session->flashdata('msg'); ?>
                                        </div>
                                <?php } ?>
                                <div class="col-md-12">
                                   <?php echo form_open('acesmain/settings/change-password/process',array('class' => 'form-group')) ?>
                                        
                                        <div class="form-group">
                                            <label for="">Old Password</label>
                                            <?php echo form_password('old_pass','',array('type' => 'password','class' => 'form-control')); ?>
                                        </div>

                                        <div class="form-group">
                                            <label for="">Password</label>
                                            <?php echo form_password('new_pass1','',array('type' => 'password','class' => 'form-control')); ?>
                                           
                                        </div>
                                        <div class="form-group">
                                            <label for="">Confirm Password</label>
                                            <?php echo form_password('new_pass2','',array('type' => 'password','class' => 'form-control')); ?>
                                           
                                        </div>
                                       
                                        <br/><br/>
                                        <?php echo form_submit('btn_access ', 'Change Password',array('class' =>  ' blue-bg btn btn-primary','id' => 'btn_submit')); ?>
                                    <?php echo form_close(); ?>
                                </div>
                            </div>
                        </div>
                        <!-- /block -->
               
            </div><!-- /content -->
        </div>    <!-- /row-fluid -->
        <hr>
        <?php $this->load->view('layouts/footer') ?>

    </body>

</html>