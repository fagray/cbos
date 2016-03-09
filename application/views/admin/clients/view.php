        <!-- /content -->
            <div class="row">
              <?php $this->load->view('admin/layouts/sidebar') ?>
            <div class="col-md-9" id="content">
               <?php if($this->session->flashdata('msg')){ ?>
                                        <div class="alert alert-danger">
                                            <?php print $this->session->flashdata('msg'); ?>
                                        </div>
                                    <?php } ?>

                <h3> Client Details : #<?php print $client[0]->CLIENT_NO; ?> </h3>
                <button data-client="<?php print $client[0]->CLIENT_NAME; ?>" 
                  data-client-no="<?php print $client[0]->CLIENT_NO; ?>"
                  id="btn-changepassword" type="button" class="btn btn-default"><i class="fa fa-lock"></i> Change Password</button> 
                 <!-- <button type="button" class="btn btn-danger">Deactivate access</button>  -->
                   <hr/>
                        <div class="panel panel-default">
                            <div class="blue-bg  panel-heading">
                                CLIENT DETAILS
                            </div>
                            <div class="panel-body">
                                <div class="col-md-12">
                              
                                <p><strong>Basic Information</strong></p><hr/>

                                  <p>Client Number : <?php print $client[0]->CLIENT_NO; ?></p><br/>
                                  <p>Client Name : <?php print $client[0]->CLIENT_NAME; ?></p><br/>

                                   <p><strong>Accounts</strong> </p><hr/>

                                    <?php if(count($accounts) < 1 ){ ?>
                                      <h4>This client has no available accounts.</h4>
                                    <?php } ?>

                                      <!-- /accounts block -->
                                    <?php foreach($accounts as $account){ ?>
                                      <div class="panel panel-default">
                                          <div class="blue-bg  panel-heading">
                                              ACCT NO.  <?php print $account->ACCT_NO ?> 
                                          </div>
                                          <div class="panel-body">
                                              <div class="col-md-12">
                                                <span class="pull-right">
                                                <p><strong>Ledger Balance : 
                                                <?php print number_format(-1 * $account->LEDGER_BAL,2) ?></strong></p><br/>
                                                </span>
                                                <p>Currency :  <?php print $account->CCY ?></p>
                                                <p>Account Description : <?php print $account->ACCT_DESC ?></p>
                                                <p>Account Type : <?php print $account->ACCT_TYPE ?></p>
                                              </div><!-- /span12 -->
                                          </div><!-- /block-content -->
                                      </div><!-- /block -->
                                    <?php } ?>

                                
                                   
                                </div><!-- /span12 -->
                            </div>
                        </div>
                        <!-- /block -->



                </div><!-- /content -->
            </div>    <!-- /row-fluid -->
            <div class="modal fade" id="modal-changepass">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="blue-bg modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 style="color:#fff;">Change Client Password</h4>
                  </div>
                  <div class="modal-body">
                      <div id="response"></div>
                      <div id="client-info"></div>
                      <?php echo form_open('',array('id' => 'frmChangePass')) ?>

                         <div class="form-group">
                            <label for="">New Password</label>

                            <?php echo form_password('new_pass1','',array('type' => 'password','class' => 'span5 form-control')); ?>
                        </div>
                        <div class="form-group">
                            <label for="">Confirm New Password</label>
                            <?php echo form_password('new_pass2','',array('type' => 'password','class' => 'span5 form-control')); ?>
                            <span id="msg"></span>
                        </div><hr/>
                         <div class="form-group">
                            <strong>For security purposes. Please provide your password for confirmation.</strong>
                            <label for="">Your password</label>
                            <?php echo form_password('usr_password','',array('type' => 'password','class' => 'span5 form-control')); ?>
                            
                        </div>
                        <?php echo form_hidden('client_no', $client[0]->CLIENT_NO ); ?>
                        <?php echo form_submit('btn_change_password', 'Change Password',array('class' =>  'btn btn-default')); ?>
                    <?php echo form_close(); ?>
                   
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                  </div>
                </div>
              </div>
            </div>
              <hr>
        <?php $this->load->view('layouts/footer') ?>

        <script type="text/javascript">

                $btn_submit = $('input[type="submit"]');
                $pass_field1 =  $('input[name="new_pass1"]');
                $pass_field2 =  $('input[name="new_pass2"]');

                $btn_submit.attr("disabled","disabled");

                $('input[name="new_pass2"]').keyup(function(){

                    $pass1_value = $pass_field1.val();
                    $value = $(this).val();

                    if ( $value != $pass1_value || $pass1_value != $value ){

                        $('span#msg').html('Password do not match.').css("color","#ff0000");
                         $btn_submit.attr("disabled","disabled");
                    
                    }else{

                         $('span#msg').html("Password matched.").css("color","#006633");
                         $btn_submit.removeAttr("disabled");
                    }
                });


            $('button#btn-changepassword').click(function(){

                $client_no = $(this).attr('data-client-no');
                $client_name = $(this).attr('data-client');

                $("#modal-changepass .modal-body #client-info").html('<h4>Client Name : '+$client_name+'</h4>'+
                  '<h4>Client No : '+$client_no+'</h4>'
                  );
                $('#modal-changepass').modal({

                  backdrop : false
                });
            });

            $('form#frmChangePass').submit(function(e){

              e.preventDefault();
              $formData = $(this).serialize();
              handleRequest($formData);
            });

            function handleRequest(formData){

              $.ajax({

                  method : 'GET',
                  data : formData,
                  url : "<?php print base_url('acesmain/accounts/change_password') ?>",
                  dataType : 'json',

                  beforeSend : function(){

                    $btn_submit.attr('disabled','disabled');
                    $btn_submit.attr('value','Processing...')
                    $('.modal').css('opactiy',".2");

                  },

                  complete : function(data){

                    $.each(data,function(key,val){

                       if ( val.response == 500){

                        showMessage(val.msg);

                        }else if ( val.response == 200){

                            showMessage(val.msg);
                        }
                        $btn_submit.removeAttr('disabled');
                        
                        clearInputs();
                        $btn_submit.attr('value','Change Password');
                        $('.modal').css('opactiy',"1");
                    });
                  
                   
                    

                  }

              }); 
            }

            function showMessage(msg){

               $('#response').html(msg);
            }

            function clearInputs(){

              $('input').val('');

            }

        </script>
       
    </body>

</html>