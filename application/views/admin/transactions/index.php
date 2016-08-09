        <!-- /content -->
            <div class="row">

              <?php $this->load->view('admin/layouts/sidebar') ?>
            
            <div class="col-md-9" id="content">
              
                    <!-- block -->
                        <div class="panel panel-default">
                            <div class="blue-bg panel-heading">
                              CLIENT TRANSACTIONS 
                            </div>
                            <div class="panel-body">
                                <div class="col-md-12">
                                  Export options
                                    <table class="table table-hover">
                                      <thead>
                                        <tr>
                                          <th>Request Timestamp </th>
                                          <th>From </th>
                                          <th>Benefactor Acct No.</th>
                                          <th>Amount</th>
                                          <th>Type</th>
                                          <th>Status</th>
                                          <th>Action</th>
                                        </tr>
                                      </thead>
                                      <tbody>
                                    
                                   <?php foreach ($transactions as $transaction) { ?>
                                        <tr>
                                          <td><?php print $transaction->REQUEST_TIMESTAMP; ?></td>
                                          <td><?php print $transaction->ACCT_NO ?></td>
                                          <td><?php print $transaction->BENEF_ACCT_NO ?></td>
                                          <td><?php print $transaction->TRAN_CCY.' '.number_format($transaction->TRAN_AMT,2) ?></td>
                                          <td><?php print $transaction->TYPE_DESC ?></td>
                                          <td><?php print $transaction->TRAN_STAT ?></td>
                                          <td>
                                            <a href="<?php print base_url('acesmain/transactions/'.
                                              $transaction->TRAN_ID.'/details') ?>">View Transaction</a>
                                          </td>
                                        </tr>
                                      <?php } ?>
                                       
                                    
                                      </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- /block -->
                </div><!-- /content -->
            </div>    <!-- /row-fluid -->
              <hr>
        <?php $this->load->view('admin/layouts/footer') ?>
        
       
    </body>

</html>