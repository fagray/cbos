        <!-- /content -->
            <div class="row">
              <?php $this->load->view('admin/layouts/sidebar') ?>
            <div class="col-md-9" id="content">
               <?php if($this->session->flashdata('msg')){ ?>
                                        <div class="alert alert-danger">
                                            <?php print $this->session->flashdata('msg'); ?>
                                        </div>
                                    <?php } ?>
                <h3> Client Transactions : #<?php print $transactions[0]->CLIENT_NO; ?> |
                  Client Name : <?php print $transactions[0]->CLIENT_NAME; ?>
                 </h3>
                 Search Transactions <input placeholder="Enter transaction number" class="form-control" name="keyword">    
                    <button id="btn_clear" class="btn btn-default blue-bg">Clear search</button>
                   <hr/>
                        
                                <div class="col-md-12">
                                  
                                    <?php foreach($transactions as $transaction){ ?>
                                      <div class="panel panel-default">
                                          <div class="blue-bg  panel-heading">
                                              TRANSACTION NO.  <span data-value="<?php print $transaction->TRAN_ID ?>" class="tran_id">
                                                <?php print $transaction->TRAN_ID ?> </span>
                                          </div>
                                          <div class="panel-body">
                                              <div class="col-md-12">
                                                <span class="pull-right">
                                                </span>
                                                <div class="label label-primary">
                                                   Type:  <?php print $transaction->TYPE_DESC ?>
                                                 
                                                </div>
                                                <p class="pull-right"> Transaction Date :  <?php print $transaction->TRAN_DATE ?></p>
                                                <table class="table table-hover">
                                                  <thead>
                                                    <tr>
                                                       <th>Account No.</th>
                                                      <th>Benefactor Account No.</th>
                                                      <th>CCY</th>
                                                      <th>Transfer Amount</th>
                                                      <th>Status</th>
                                                     
                                                    </tr>
                                                  </thead>
                                                  <tbody>
                                                    <tr>
                                                      <td><?php print $transaction->ACCT_NO ?></td>
                                                      <td><?php print $transaction->BENEF_ACCT_NO ?></td>
                                                      <td><?php print $transaction->CCY ?></td>
                                                      <td><?php print $transaction->TRAN_AMT ?></td>
                                                      <td>
                                                        <label class="label label-success"><?php print $transaction->TRAN_STAT ?></label>
                                                        </td>
                                                    </tr>
                                                  </tbody>
                                                </table>
                                              </div><!-- /span12 -->
                                          </div><!-- /block-content -->
                                      </div><!-- /block -->
                                    <?php } ?>


                </div><!-- /content -->
            </div>    <!-- /row-fluid -->
          
              <hr>
        <?php $this->load->view('layouts/footer') ?>
        <script type="text/javascript">
          $(document).ready(function(){
              $input = $('input[name="keyword"]');
              $input.keyup(function(){

                $keyword = $(this).val();
                $element = findTransaction($keyword);
                $element ? highlight($element) : clear();
              });

              $('button#btn_clear').click(function(){
                    clear();
                    $input.val('');
              });
          }); 

          function findTransaction(keyword){

            return $('.panel').find('span[data-value="'+keyword+'"]');


          } 

          function clear(){

            $('span.tran_id').css('background','#0C6A99');
          }

          function highlight(element){

            element.css("background",'red');
          }
        </script>
     
       
    </body>

</html>