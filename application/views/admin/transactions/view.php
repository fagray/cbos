        <!-- /content -->

            <div class="row">
              <?php $this->load->view('admin/layouts/sidebar') ?>
            <div class="col-md-9" id="content">


                        <span class="pull-right">
                           <?php if($account[0]->TRAN_STAT == 'In progress'){ ?>
                          <!--   <button data-choice="Rejected"  
                                type="button" class="btn-choice btn btn-danger blue-bg">Reject
                            </button> -->
                            <button data-choice="Approved"  
                              type="button" class="btn-choice btn btn-success blue-bg ">Approve
                            </button>
                          <?php } ?>
                          </span><!-- /pull-right -->
                          <?php  if( $account[0]->TRAN_STAT == 'Approved'){ ?>

                            <div class="alert alert-success">This transaction has been approved on
                            <?php print $account[0]->CONFIRM_TIMESTAMP . ' by '.$account[0]->CONFIRM_REF; ?>
                            </div>

                           <?php }else if( $account[0]->TRAN_STAT == 'Rejected') { ?>

                            <div class="alert alert-danger">
                              This transaction has been denied on  
                                <?php print $account[0]->CONFIRM_TIMESTAMP . ' by '.$account[0]->CONFIRM_REF; ?>

                            </div>

                            <?php }else{  ?>

                            <div class="alert alert-info">
                              This transaction is pending for approval.
                            </div>
                            <?php } ?>
                        

                        <div style="margin-top:50px;" class="">
                            <div class="panel panel-default">
                               <div class="blue-bg panel-heading"> TRANSACTION DETAILS</div>
                          
                            <div class="panel-body">
                            <p> Transfer Type : <strong>
                              <?php print $account[0]->TYPE_DESC ?>
                            </strong></p>
                             <p> Request Timestamp : <strong>
                              <?php print $account[0]->REQUEST_TIMESTAMP ?>
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
                                            <th> Source Account No.</th>
                                            <th>Source Account Name</th>
                                            <th>Benefactor Account No.</th>
                                            <th>Transfer Amount</th>
                                            <th>Currency</th>
                                            <th></th>
                                          </tr>
                                        </thead>
                                        <tbody>
                                          <tr>
                                            <td><?php print $account[0]->ACCT_NO ?></td>
                                            <td><?php print $account[0]->ACCT_DESC ?></td>
                                            <td><?php print $account[0]->BENEF_ACCT_NO ?></td>
                                            <td id="tdAmt" data-amt="<?php print $account[0]->TRAN_AMT ?>">

                                              <?php print number_format($account[0]->TRAN_AMT,2) ?>

                                              </td>
                                            <td><?php print $account[0]->TRAN_CCY ?></td>

                                            <?php if($account[0]->TRAN_STAT == 'In progress'){ ?>
                                            
                                              <td>
                                                <button data-choice="Rejected"  type="button" class="btn-choice btn-danger blue-bg">Reject</button>
                                                <button data-choice="Approved"  type="button" class="btn-choice btn-success blue-bg">Approve</button>
                                              </td>

                                              <?php } else if( $account[0]->TRAN_STAT == 'Approved'){ ?>

                                              <td>
                                                <span class="label label-success">
                                                  <?php print $account[0]->TRAN_STAT ?>
                                                </span>
                                              </td>

                                            <?php }else{ ?>

                                              <td>
                                                <span class="label label-warning">
                                                  <?php print $account[0]->TRAN_STAT ?>
                                                </span>
                                              </td>

                                            <?php } ?>
                                          </tr>
                                        </tbody>
                                      </table>
                                    <?php } ?><!-- /end of CBOS DETAILS -->

                                    <!-- START OF OTHER BANKS TRANSFER DETAILS -->

                                      <p> Account Name : <?php print $account[0]->ACCT_NAME ?>  </p>
                                      <p> Bank Name : <?php print $account[0]->BANK_NAME ?>  </p>
                                      
                                      <p> Swift Code : 

                                           <?php if($account[0]->SWIFT_CODE == ''){ print "N/A"; }
                                                else {

                                                  print $account[0]->SWIFT_CODE;
                                                }


                                           ?>
                                      
                                      <p> TIBAN # : 

                                          <?php if($account[0]->TIBAN_NUM == ''){ print "N/A"; }
                                                else {

                                                  print $account[0]->TIBAN_NUM;
                                                }


                                           ?>
                                      </p>
                                     <table class="table table-hover">
                                        <thead>
                                          <tr>
                                            <th> Source Account No.</th>
                                            <th>Source Account Name</th>
                                            <th>Benefactor Account No.</th>
                                            <th>Transfer Amount</th>
                                            <th>Currency</th>
                                          </tr>
                                        </thead>
                                        <tbody>
                                          <tr>
                                            <td><?php print $account[0]->ACCT_NO ?></td>
                                            <td><?php print $account[0]->ACCT_DESC ?></td>
                                            <td><?php print $account[0]->BENEF_ACCT_NO ?></td>
                                            <td id="tdAmt" data-amt="<?php print $account[0]->TRAN_AMT ?>">

                                              <?php print number_format($account[0]->TRAN_AMT,2) ?>

                                              </td>
                                            <td><?php print $account[0]->TRAN_CCY ?></td>

                                           

                                              <td>
                                                <span class="label label-warning">
                                                  <?php print $account[0]->TRAN_STAT ?>
                                                </span>
                                              </td>

                                           
                                          </tr>
                                        </tbody>
                                      </table>

                                    </div><!-- /panel-body -->
                                  </div><!-- /panel-default -->

                                  </div><!-- /col -->
                              </div><!-- /row -->
                                
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
                    <h4 style="color:#fff !important;" class="modal-title">Confirmation Required </h4>
                  </div>
                 
                  <div class="modal-body">
                 

                  </div>
                  <div class="modal-footer">
                    <?php print form_hidden('tran_id', $account[0]->TRAN_ID ); ?>
                      <?php print form_hidden('tran_status', ''); ?>
                      <?php print form_hidden('benef_acct_no',$account[0]->BENEF_ACCT_NO) ?>
                      <?php print form_hidden('_trans_amt') ?>
                   <?php print form_submit('confirm', 'Confirm',array('class' => 'btn_confirm btn btn-primary blue-bg')); ?>
                    <button type="button" class="btn btn-default blue-bg" data-dismiss="modal">Cancel</button>
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
              $trans_amt = $('#tdAmt').attr("data-amt");
               $('.btn-choice').attr("disabled","disabled");
              $('input[name="_trans_amt"]').val($trans_amt);
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
                   setTimeout("function(){'"+ window.location.href +"'}",5000);
                   
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