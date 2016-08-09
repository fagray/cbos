        <!-- /content -->

        <?php $this->load->view('layouts/main-header') ?>
        <div class="row">

          <?php $this->load->view('layouts/sidebar') ?>

          <div class="col-md-9" id="content">

            <h3 class="heading">Transfer Transactions</h3>
             <?php if( $this->session->flashdata('msg')){ ?>
                                        <div class="alert alert-danger">
                                            <?php print $this->session->flashdata('msg'); ?>
                                        </div>
                                    <?php } ?>
                                    <?php if( $this->session->flashdata('msg-success')){ ?>
                                        <div class="alert alert-success">
                                            <?php print $this->session->flashdata('msg-success'); ?>
                                        </div>
                                    <?php } ?>
            <!-- block -->
            <div class="panel panel-default">
              <div class="panel-heading blue-bg">

               TRANSACTIONS LIST
             </div>
             <div class="panel-body ">

              <div class="col-md-12">

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

                    <td>CBOS FUND TRANSFER</td>
                    <td><?php print $transaction->TRAN_STAT ?></td>
                    <td>
                      <a href="<?php print base_url('accounts/transactions/'.$transaction->TRAN_ID.'/details') ?>">

                        View Transaction</a>
                      </td>
                    </tr>
                    <?php } ?>


                  </tbody>
                </table>
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
          $('table.table').DataTable({
              "order": [[ 1, "asc" ]]
            });
          
        }); 
      </script>

    </body>

    </html>