        <!-- /content -->
        <?php $this->load->view('layouts/main-header') ?>
        
            <div class="row">

              <?php $this->load->view('layouts/sidebar') ?>
            
              <div class="col-md-9" id="content">
                        
                    
                          <?php  if( $account[0]->TRAN_STAT == 'COMPLETED'){ ?>

                            <div class="alert alert-success">This transaction has been COMPLETED on
                            <?php print $account[0]->CONFIRM_TIMESTAMP; ?>
                            </div>

                           <?php }else if( $account[0]->TRAN_STAT == 'Rejected') { ?>

                            <div class="alert alert-danger">
                              This transaction has been denied on  
                                <?php print $account[0]->CONFIRM_TIMESTAMP; ?>

                            </div>

                            <?php }else{ ?>

                            <div class="alert alert-info blue-bg">
                              This transaction is still in progress.
                               

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

                                              <td>
                                                <span class="label label-success">
                                                  <?php print $account[0]->TRAN_STAT ?>
                                                </span>
                                              </td>

                                           
                                          </tr>
                                        </tbody>
                                      </table>
                                    <?php }else{ ?><!-- /end of CBOS DETAILS -->

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
                                    <?php } ?>
                                    </div><!-- /panel-body -->
                                  </div><!-- /panel-default -->
                                  </div><!-- /col -->
                              </div><!-- /row -->
                                
                            </div>
                        </div>
                        <!-- /block -->

                    
                </div><!-- /content -->
            </div>    <!-- /row-fluid -->
            
              <hr>
        <?php $this->load->view('layouts/footer') ?>

      
       
    </body>

</html>