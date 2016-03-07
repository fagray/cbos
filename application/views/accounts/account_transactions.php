        <!-- /content -->
            <?php $this->load->view('layouts/main-header') ?>
            <div class="row">
              <?php $this->load->view('layouts/sidebar') ?>
            
              <div class="col-md-9" id="content">
                      <?php if(count($transactions) < 1){ ?>
                        <h3>No available transactions for this account.</h3>
                      <?php }else{ ?>

                            <div class="panel panel-default">
                               <div class="blue-bg panel-heading"> ACCOUNT INFORMATION</div>
                          
                            <div class="panel-body">
                            <p> Account No. : <strong>
                              <?php print $transactions[0]->ACCT_NO ?>
                            </strong></p>
                             <p> Client Name : <strong>
                              <?php print $transactions[0]->CLIENT_NAME ?>
                            </strong></p>
                             <p> Client No : <strong>
                              <?php print $transactions[0]->CLIENT_NO ?>
                            </strong></p>
                            <p> Branch : <strong>
                              <?php print $transactions[0]->BRANCH ?>
                            </strong></p>
                          
                              <hr/>
                              <div class="row">
                                <div class="col-md-12">
                                <?php foreach($transactions as $transaction){ ?>
                                   <div class="panel panel-default">
                               
                                    <div class="blue-bg  panel-heading">
                                        TRANSACTION DETAILS - Request Date : <?php print $transaction->TRAN_DATE ?>
                                    </div>
                                    <div class="panel-body">
                                    <p>Transacion Description : <?php print $transaction->TRAN_DESC ?></p>
                                    <span class="pull-right"><?php  

                                    if($transaction->TRAN_TYPE == '111111'){ print "<p>Type :  CBOS Fund Transfer</p>"; }
                                      else {
                                       print 
                                        "Other Banks Transfer";} ?></span>
                                      
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
                                            <td><?php print $transaction->ACCT_NO ?></td>
                                            <td><?php print $transaction->ACCT_DESC ?></td>
                                            <td><?php print $transaction->BENEF_ACCT_NO ?></td>
                                            <td><?php print number_format($transaction->TRAN_AMT,2) ?></td>
                                            <td><?php print $transaction->TRAN_CCY ?></td>
                                            <td><?php print $transaction->TRAN_STAT ?></td>
                                          
                                          </tr>
                                        </tbody>
                                      </table>
                                  
                                    </div><!-- /panel-content -->
                                  </div><!-- /panel-default -->
                                <?php } ?>
                                  </div><!-- /span6 -->
                              </div><!-- /row-fluid -->
                                
                            </div><!-- /panel-body -->
                        </div>
                       
                        <!-- /block -->

                    
                </div><!-- /content -->
            </div>    <!-- /row-fluid -->
          
              <hr>
        <?php $this->load->view('layouts/footer') ?>

       <?php } ?>
    </body>

</html>