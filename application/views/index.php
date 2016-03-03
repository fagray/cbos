        <!-- /content -->
  
          <?php $this->load->view('layouts/main-header') ?>
         
            <div class="row">


              <?php $this->load->view('layouts/sidebar') ?>
            

            <div class="col-md-9" id="content">
                <span class="pull-right">
              
                </span>                    
                <h3>Account Summary</h3>
                    <!-- block -->
                        <div class="panel panel-default">
                            <div class="blue-bg panel-heading">
                                My Accounts
                            </div>
                            <div class="panel-body">
                                <div class="col-md-12">
                                    <table class="table table-hover">
                                      <thead>
                                        <tr>
                                          <th>Branch </th>
                                          <th>Account No.</th>
                                          <th>Description</th>
                                          <th>Currency</th>
                                          <th>Beginning Balance</th>
                                          <th>Available Balance</th>
                                          <th>Action</th>
                                        </tr>
                                      </thead>
                                      <tbody>
                                   <?php foreach ($accounts as $account) { ?>
                                        <tr>
                                          <td><?php print $account->BRANCH; ?></td>
                                          <td><?php print $account->ACCT_NO ?></td>
                                          <td><?php print $account->ACCT_DESC ?></td>
                                          <td><?php print $account->CCY ?></td>
                                          <td><?php print number_format($account->LEDGER_BAL,2) ?></td>
                                          <td><?php print number_format($account->ACTUAL_BAL,2) ?></td>
                                           <td>
                                            <a href="<?php print base_url('accounts/'.$account->ACCT_NO.
                                              '/transfers/new')  ?>">
                                                Make Transfer
                                            </a> | 
                                            <a href="#">View Transaction</a>
                                          </td>
                                        </tr>
                                      <?php } ?>
                                      </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- /paenl -->
                </div><!-- /content -->
            </div>    <!-- /row -->
              <hr>
        <?php $this->load->view('layouts/footer') ?>
       
    </body>

</html>