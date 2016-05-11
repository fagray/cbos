        <!-- /content -->
        <div class="container">
          <?php $this->load->view('layouts/main-header') ?>
            <div class="row">

              <?php $this->load->view('layouts/sidebar') ?>

            <div class="col-md-9" id="content">
                   

                <h3>New Fund Transfer from ACCT.NO # <?php print $account[0]->ACCT_NO; ?> </h3>
                    <!-- block -->
                        <div class="panel panel-default">
                            <div class="blue-bg panel-heading">
                               My Accounts 
                            </div>
                            <div  class="transfer-content panel-body">

                                <div class="col-md-12">
                                 
                                    <table class="table table-hover">
                                      <thead>
                                        <tr>
                                          <th>Transfer</th>
                                          <th>Account Number</th>
                                          <th>Branch</th>
                                          <th>Account Name</th>
                                          <th>Currency</th>
                                          <th>Beginning Balance</th>
                                          <th>Available Balance</th>
                                        </tr>
                                      </thead>
                                      <tbody>
                                       <tr>
                                         
                                          <td>From</td>
                                          <td id="tdAcctNo" data-account-no="<?php print $account[0]->ACCT_NO ?>">
                                            <?php print $account[0]->ACCT_NO ?>
                                          </td>
                                          <td><?php print $account[0]->BRANCH; ?></td>
                                          <td><?php print $account[0]->ACCT_DESC ?></td>
                                          <td><?php print $account[0]->CCY ?></td>
                                          <td><?php print number_format( -1 * $account[0]->LEDGER_BAL,2) ?></td>
                                          <td data-bal="<?php print -1 * $account[0]->ACTUAL_BAL ?>" id="source_beginning_bal"><?php print number_format(-1 * $account[0]->ACTUAL_BAL,2) ?></td>
                                        </tr>
                                      </tbody>
                                    </table>
                                    <div role="tabpanel" class="transfer-tab">
                                    
                                    
                                      <!-- Tab panes -->
                                      <div class="tab-content">

                                        
                                        <div role="tabpanel" class="tab-pane" id="others">
                                          <table class="table table-bordered">
                                           
                                            <tbody>
                                              <tr >
                                                <td>Transfer To : </td>
                                                <td class="blue-bg"> 
                                                 Other Banks Account
                                                </td>
                                              </tr>
                                              <tr>
                                                <td>Account Number </td>
                                                <td> 

                                                  <input type="number" name="other_acct_no" id="input" class="form-control" value=""  required="required" >
                                                 <!--  <select name="other_acct_no"  class="form-control" >
                                                  <option></option>
                                                  <?php foreach($other_accounts as $account){?>
                                                    <option 
                                                    value="<?php print $account->ACCT_NO ?>">
                                                    <?php print $account->ACCT_NO ?>
                                                    </option>
                                                    <?php } ?>
                                                  </select> -->
                                                  <span id="other_acct_feedback"></span>
                                                </td>
                                              </tr>
                                              <tr>
                                                <td>Account Name </td>

                                                <td>
                                                  <input type="text" name="other_acct_name" id="input" class="form-control" value=""  required="required" >
                                                 </td>

                                              </tr>
                                              <tr>
                                                <td>Bank Name </td>
                                                <td>
                                                     <input type="text" name="other_bank_name" id="input" class="form-control" value=""  required="required" >
                                                 </td>
                                              </tr>
                                               <tr>
                                                <td >Transfer Currency </td>
                                                <td>

                                                  <select name="other_ccy"  class="form-control" >
                                                  <option></option>
                                                  <?php foreach($currencies as $curr){?>
                                                    <option 
                                                    value="<?php print $curr->CCY ?>">
                                                    <?php print $curr->CCY_DESC.' ( '.$curr->CCY.')'; ?>
                                                    </option>
                                                    <?php } ?>
                                                  </select>

                                                
                                                </td>
                                              </tr>
                                              
                                               <tr>
                                                <td>Transfer Amount </td>
                                                <td> <input type="text" name="other_trans_amount" id="input" class="form-control" value="" required="required" pattern="" title="">
                                                <span id="feedback_other_trans_amount"></span>
                                                </td>
                                              </tr>
                                               <tr>
                                                <td>Transfer Description </td>
                                                <td> 
                                                  <input name="other_trans_desc" id="inputTrans_desc" class="form-control"  required="required">
                                                </td>
                                              </tr>

                                            </tbody>

                                          </table>  
                                          <br/><br/>
                                          <span class="pull-right">
                                             <a id="others_send" href="#" class="blue-bg btn btn-primary">Send</a>
                                             <button type="button" class="blue-bg btn btn-default">Clear</button>
                                          </span>
                                          
                                        </div><!-- /others tab -->
                                      </div>

                                    </div><!-- /transfer-tab -->

                                    <div class="added_tabs"></div>
                                    <br/>
                                    <span class="pull-left">
                                      <div class="btn-group">
                                        <button type="button" class="blue-bg btn btn-default dropdown-toggle" data-toggle="dropdown">
                                          Add New Transfer
                                          <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu">
                                          <li><a class="linkCBOS" href="#">CBOS Transfer</a></li>
                                          <li><a class="linkOther" href="#">Other Banks Transfer</a></li>
                                        </ul>
                                      </div>
                                    </span><!-- /pull-left -->
                                </div>
                            </div>
                        </div>

                        <div class="records-container">
                          
                        </div><!-- /record-container -->

                        <!-- /panel -->
                      <div class="panel panel-default">
                        <div class="panel-heading">Test</div>

                        <div class="panel-body">
                            
                        </div><!-- /panel-body -->

                      </div><!-- /panel-default -->
                </div><!-- /content -->
            </div>    <!-- /row -->
          <?php print form_open(); ?>
            <!-- START OF MODAL CBOS TRANSFER -->

            <div class="modal fade" id="modal-cbos-transfer">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">CBOS Transfer</h4>
                  </div>
                  <div class="modal-body">
                    
                      <!-- START CBOS TRANSFER -->
                       <table class="table table-bordered">
                        <tbody>
                          <tr >
                            <td>Transfer To : </td>
                            <td class="blue-bg"> 
                              CBOS Account
                            </td>
                          </tr>
                          <tr>
                            <td>Account Number* </td>
                            <td> 
                              <select name="cbos_acct_no"  class="form-control" >
                                <option value=""></option>
                                <?php foreach($user_accounts as $acct){ ?>
                                  <option value="<?php print $acct->ACCT_NO; ?>">
                                    <?php print $acct->ACCT_NO .'/ '.$acct->BRANCH .' / ' . $acct->ACCT_DESC; ?>
                                  </option>
                                <?php  } ?>
                              </select>
                            </td>
                          </tr>
                          <tr>
                            <td>Account Name </td>
                            <td class="requiredValues" id="td_acct_name"> </td>
                          </tr>
                           <tr>
                            <td >Branch / Currency </td>
                            <td  class="requiredValues"  id="td_branch_ccy"> </td>
                          </tr>
                           <tr>
                            <td>Beginning Balance </td>
                            <td  class="requiredValues"  id="td_beginning_bal"> </td>
                          </tr>
                           <tr>
                            <td>Available Balance </td>
                            <td  class="requiredValues"  id="td_avail_bal"> </td>
                          </tr>
                           <tr>
                            <td>Transfer Currency </td>
                            <td class="requiredValues"  id="td_trans_ccy"> </td>
                          </tr>
                           <tr>
                            <td>Transfer Amount* </td>
                            <td> <input required="required" type="text" name="cbos_trans_amount" id="input" class="form-control" value="" required="required" pattern="" title="">
                            <span id="feedback_trans_amount"></span>
                            </td>
                          </tr>
                           <tr>
                            <td>Transfer Description* </td>
                            <td> 
                              <input required="required" name="cbos_trans_desc" id="inputTrans_desc" class="form-control" >
                            </td>
                          </tr>
                        </tbody>
                      </table>
                      <span class="pull-left">
                        <span style="color:#0099FF;">* Fields are required.</span>
                       </span>  

                  </div>
                  <div class="modal-footer">
                   <a href="#" class="cbos_insert blue-bg btn btn-primary">Add Transaction</a>
                   <button type="button" class="btn-clear btn btn-default blue-bg">Clear</button>
                  </div>
                </div>
              </div>
            </div><!-- /END OF CBOS MODAL -->

            <?php print form_hidden('cbos_acct_name[]', ''); ?>
            <?php print form_hidden('cbos_acct_currency[]', ''); ?>
            <?php print form_hidden('cbos_trans_amount[]', ''); ?>
            <?php print form_hidden('cbos_trans_desc[]', ''); ?>

          <?php print form_close(); ?>

          <hr>

          <?php $this->load->view('layouts/footer') ?>

            <script src="<?php print base_url('public/assets/js/autonumeric.min.js') ?>"></script>

          <script type="text/javascript">

              $(document).ready(function(){

                $('.linkCBOS').click(function(){

                    showCBOSModal();

                });


                // CBOS MODAL 
              
                $('a.cbos_insert').click(function(e){

                  e.preventDefault();

                  $acct_number        = $('select[name="cbos_acct_no"]').val();
                  $acct_name          = $('input[name="td_acct_name"]').val();
                  $cbos_trans_amount  = $('input[name="cbos_trans_amount"]').val();

                  $('.records-container').append('<div class="panel panel-default">'+
                      '<div class="panel-heading">Test</div>'+

                        '<div class="panel-body">'+
                        '<p>Account Number'+ $acct_number  +'</p>'+
                        '<p>Transfer Amount '+ $cbos_trans_amount  +'</p>'+
                            
                        '</div>'+

                      '</div>'
                 );

               

                });

              });

              function showCBOSModal(){

                $('#modal-cbos-transfer').modal({

                  backdrop :false

                });
              }



          </script>
       
    </body>

</html>