
        <!-- /content -->
        <div class="container-fluid">

            <div class="row-fluid">
            
              <?php $this->load->view('layouts/sidebar') ?>

            
                <div class="span9" id="content">
                <span class="pull-right">
                    <p>Logged in as : <?php print $this->session->userdata('usrname'); ?> | <a href="<?php print base_url('auth/session/logout') ?>">Logout </a></p>
                </span>                    
                <h3>Account Summary</h3>
                    <!-- block -->
                        <div class="block">
                            <div class="navbar navbar-inner block-header">
                                <div class="muted pull-left">My Accounts </div>
                            </div>
                            <div class="block-content collapse in">
                                <div class="span12">
                                    <table class="table table-hover">
                                      <thead>
                                        <tr>
                                          <th>Branch Name</th>
                                          <th>Account No.</th>
                                          <th>Description</th>
                                          <th>Currency</th>
                                          <th>Beginning Balance</th>
                                          <th>Available Balance</th>
                                        </tr>
                                      </thead>
                                      <tbody>
                                      <?php foreach ($accounts as $account) { ?>
                                        <tr>
                                          <td><?php print $account->branch; ?></td>
                                          <td><?php print $account->acct_no ?></td>
                                          <td><?php print $account->acct_desc ?></td>
                                          <td><?php print $account->ccy ?></td>
                                          <td><?php print number_format($account->ledger_bal,2) ?></td>
                                          <td><?php print number_format($account->actual_bal,2) ?></td>
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
       <?php $this->load->view('layouts/footer') ?>
       
    </body>

</html>