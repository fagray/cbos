        <!-- /content -->
        <?php $this->load->view('layouts/main-header') ?>
        
            <div class="row">

              <?php $this->load->view('layouts/sidebar') ?>
            
              <div class="col-md-9" id="content">
                      
                        <div class="">
                            <div class="panel panel-default">
                               <div class="blue-bg panel-heading"> TRANSACTION DETAILS </div>
                          
                            <div class="panel-body">
                            <p> Transfer Type : <strong>
                              <?php print $account[0]->TYPE_DESC ?>
                            </strong></p>
                             <p> Request Timestamp : <strong>
                              <?php print $account[0]->TRAN_DATE ?>
                            </strong></p>
                            <p> Transfer Status : <strong>
                              <?php print $account[0]->TRAN_STAT ?>
                            </strong></p>
                            <p> Transfer Description : <strong>
                              <?php print $account[0]->TRAN_DESC ?>
                            </strong></p>

                              <hr/>
                              <div class="row">
                                <div class="col-md-12">
                                   <div class="panel panel-default">
                               
                                    <div class="blue-bg  panel-heading">
                                        TRANSFER DETAILS
                                    </div>
                                    <div class="panel-body">
                                    <?php if($account[0]->TRAN_TYPE == 111111){ ?>

                                      <table class="table table-hover">
                                        <thead>
                                          <tr>
                                            <th>Source Account No.</th>
                                            <th>Source Account Name</th>
                                            <th>Benefactor Account No.</th>
                                            <th>Transfer Amount</th>
                                            <th>Currency</th>
                                            <th>Status</th>
                                          </tr>
                                        </thead>
                                        <tbody>
                                          <tr>
                                            <td><?php print $account[0]->ACCT_NO ?></td>
                                            <td><?php print $account[0]->ACCT_DESC ?></td>
                                            <td><?php print $account[0]->BENEF_ACCT_NO ?></td>
                                            <td><?php print number_format($account[0]->TRAN_AMT,2) ?></td>
                                            <td><?php print $account[0]->TRAN_CCY ?></td>
                                            <td><?php print $account[0]->TRAN_STAT  ?></td>
                                           
                                          </tr>
                                        </tbody>
                                      </table>
                                   <?php } ?>
                                    </div><!-- /block-content -->
                                  </div><!-- /block -->

                                  </div><!-- /span6 -->
                              </div><!-- /row-fluid -->
                                
                            </div>
                        </div>
                        <!-- /block -->

                    
                </div><!-- /content -->
            </div>    <!-- /row-fluid -->
            <div class="modal fade" id="modal_confirm">
              <div class="modal-dialog">
               <?php print form_open('',array('name' => 'frmSubmit')); ?>
                <div class="modal-content">
                  <div  class="blue-bg modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Confirmation Required </h4>
                  </div>
                 
                  <div class="modal-body">
                 

                  </div>
                  <div class="modal-footer">
                    <?php print form_hidden('tran_id', $account[0]->TRAN_ID ); ?>
                      <?php print form_hidden('tran_status', ''); ?>
                   <?php print form_submit('confirm', 'Confirm',array('class' => 'btn_confirm btn btn-primary')); ?>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <!-- <button type="submit" class="btn_confirm btn btn-primary">Confirm</button> -->
                 
                  </div>
                </div>
                 <?php print form_close(); ?>
              </div>
            </div>
              <hr>
        <?php $this->load->view('layouts/footer') ?>

        <script type="text/javascript">

          $choice = '';
          $('.btn-choice').click(function(){

            $choice = $(this).attr('data-choice');

            $('input[name="tran_status"]').val($choice);

            if ( $choice == 'Rejected'){

                $('.modal-body').html('Are you sure you want to <strong>reject</strong> this transfer ? This cannot be undone.');
                // $('input[name="tran_status"]').val('Rejected');
                show_modal();

            }else{

               $('.modal-body').html('Are you sure you want to  <strong>approve</strong> this transfer ? This cannot be undone.');
                // $('input[name="tran_status"]').val('Completed');
                show_modal();

            }

          });

          $('form[name="frmSubmit"]').submit(function(e){

              e.preventDefault();
               $('.btn-choice').attr("disabled","disabled");
              $formData = $(this).serialize();

              process_request($formData);
           

          });

          function process_request(formData){

           
               $.ajax({

                  url : "<?php print base_url('acesmain/transactions/process') ?>",
                  data :formData,
                  method : 'GET',
                  dataType : 'json',

                  beforeSend : function(){
                     
                    $('.modal-footer').html("<h4>Processing Request...</h4>");
                  },

                  success : function(data){

                    if(data.response == 200){

                      $('.modal-body').html("<h4>Request has been completed.</h4>");
                       $('.modal-footer').remove();

                    }else{

                        $('.modal-body').html("<h4>An error occured.</h4>");
                    }

                  },

                  complete : function(){

                    location = window.location.href;
                   // setTimeout("function(){'"+ window.location.href +"'}",5000);
                   
                  },

                  error : function(){

                      $('.modal-body').html("<h4>An error occured.Please try again.</h4>");

                  }

              });
          }

          
          function show_modal(){

            $('#modal_confirm').modal({

              backdrop : false

            });
          }
        </script>
       
    </body>

</html>