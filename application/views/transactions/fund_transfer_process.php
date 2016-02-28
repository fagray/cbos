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
                            <div class="panel-body">

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
                                          <td><?php print number_format($account[0]->LEDGER_BAL,2) ?></td>
                                          <td><?php print number_format($account[0]->ACTUAL_BAL,2) ?></td>
                                        </tr>
                                      </tbody>
                                    </table>
                                    <div role="tabpanel">
                                      <!-- Nav tabs -->
                                      <ul class="nav nav-tabs" role="tablist">
                                        <li role="presentation" class="active">
                                          <a href="#cbos" aria-controls="cbos" role="tab" data-toggle="tab">CBOS Account</a>
                                        </li>
                                        <li role="presentation">
                                          <a href="#others" aria-controls="others" role="tab" data-toggle="tab">Other Banks Account</a>
                                        </li>
                                      </ul>
                                    
                                      <!-- Tab panes -->
                                      <div class="tab-content">

                                        <div role="tabpanel" class="tab-pane active" id="cbos">
                                          <table class="table table-bordered">
                                           
                                            <tbody>
                                              <tr >
                                                <td>Transfer To : </td>
                                                <td class="blue-bg"> 
                                                  CBOS Account
                                                </td>
                                              </tr>
                                              <tr>
                                                <td>Account Number </td>
                                                <td> 
                                                  <select name="cbos_acct_no"  class="form-control" >
                                                    <option value=""></option>
                                                    <?php foreach($user_accounts as $acct){ ?>
                                                      <option value="<?php print $acct->ACCT_NO; ?>">
                                                        <?php print $acct->ACCT_NO; ?>
                                                      </option>
                                                    <?php  } ?>
                                                  </select>
                                                </td>
                                              </tr>
                                              <tr>
                                                <td>Account Name </td>
                                                <td class="requiredValues" id="acct_name"> </td>
                                              </tr>
                                               <tr>
                                                <td >Branch / Currency </td>
                                                <td  class="requiredValues"  id="branch_ccy"> </td>
                                              </tr>
                                               <tr>
                                                <td>Beginning Balance </td>
                                                <td  class="requiredValues"  id="beginning_bal"> </td>
                                              </tr>
                                               <tr>
                                                <td>Available Balance </td>
                                                <td  class="requiredValues"  id="avail_bal"> </td>
                                              </tr>
                                               <tr>
                                                <td>Transfer Currency </td>
                                                <td class="requiredValues"  id="trans_ccy"> </td>
                                              </tr>
                                               <tr>
                                                <td>Transfer Amount </td>
                                                <td> <input required="required" type="text" name="trans_amount" id="input" class="form-control" value="" required="required" pattern="" title=""></td>
                                              </tr>
                                               <tr>
                                                <td>Transfer Description </td>
                                                <td> 
                                                  <textarea required="required" name="trans_desc" id="inputTrans_desc" class="form-control" style="width:230px;" rows="3" required="required"></textarea>
                                                </td>
                                              </tr>

                                            </tbody>

                                          </table>  
                                          <span class="pull-right">
                                             <a id="cbos_send" href="#" class="btn btn-primary">Send</a>
                                             <button type="button" class="btn-clear btn btn-default">Clear</button>
                                          </span>
                                         
                                        </div><!-- /cbos-tab -->
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
                                                  <select name="other_acct_no"  class="form-control" >
                                                  
                                                    <?php foreach($user_accounts as $account){ ?>
                                                      <option value="<?php print $account->ACCT_NO; ?>">
                                                        <?php print $account->ACCT_NO; ?>
                                                      </option>
                                                    <?php  } ?>
                                                  </select>
                                                </td>
                                              </tr>
                                              <tr>
                                                <td>Account Name </td>
                                                <td id="other_acct_name"> </td>
                                              </tr>
                                              <tr>
                                                <td>Bank Name </td>
                                                <td id="other_bank_name"> </td>
                                              </tr>
                                               <tr>
                                                <td >Transfer Currency </td>
                                                <td id="other_ccy"> </td>
                                              </tr>
                                              
                                               <tr>
                                                <td>Transfer Amount </td>
                                                <td> <input type="text" name="other_trans_amount" id="input" class="form-control" value="" required="required" pattern="" title=""></td>
                                              </tr>
                                               <tr>
                                                <td>Transfer Description </td>
                                                <td> 
                                                  <textarea name="other_trans_desc" id="inputTrans_desc" class="form-control" style="width:230px;" rows="3" required="required"></textarea>
                                                </td>
                                              </tr>

                                            </tbody>

                                          </table>  
                                          <span class="pull-right">
                                             <a id="others_send" href="#" class="btn btn-primary">Send</a>
                                             <button type="button" class="btn btn-default">Clear</button>
                                          </span>
                                          
                                        </div><!-- /others tab -->
                                      </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /panel -->
                </div><!-- /content -->
            </div>    <!-- /row -->
            <div class="modal fade" id="modalConfirmCbos">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Transaction Confirmation for Fund Transfer for CBOS Account</h4>
                  </div>
                <?php print form_open('',array('id' => 'frmConfirmCBOS')) ?>
                  <div class="modal-body">
                    <div id="response"></div>
                    <table class="table table-bordered table-hover">
                      <tbody>
                        <tr>
                          <td>Account Number </td>
                          <td id="confirm_acct_no"> </td>
                        </tr>
                        <tr>
                          <td>Account Name </td>
                          <td id="acct_name"> </td>
                        </tr>
                         <tr>
                          <td >Branch / Currency </td>
                          <td  id="branch_ccy"> </td>
                        </tr>
                         <tr>
                          <td>Beginning Balance </td>
                          <td   id="beginning_bal"> </td>
                        </tr>
                         <tr>
                          <td>Available Balance </td>
                          <td   id="avail_bal"> </td>
                        </tr>
                         <tr>
                          <td>Transfer Currency </td>
                          <td  id="trans_ccy"> </td>
                        </tr>
                         <tr>
                          <td>Transfer Amount </td>
                          <td  id="confirm_trans_amount"> </td>
                         </tr>
                         <tr>
                          <td>Transfer Description </td>
                          <td  id="confirm_trans_desc"> </td>
                        
                        </tr>
                      </tbody>
                    </table>

                  </div>
                  <input type="hidden" name="acct_name">
                  <input type="hidden" name="branch">
                  <input type="hidden" name="ccy">
                  <input type="hidden" name="tran_type">
                  <input type="hidden" name="tran_amount">
                  <input type="hidden" name="benef_acct_no">
                  <input type="hidden" name="source_acct_no">
                  <input type="hidden" name="trans_desc">

                  <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button id="btn_confirm"  type="submit" class="btn btn-primary">Confirm</button>
                  </div>
                  <?php print form_close(); ?>
                </div>
              </div>
            </div><!-- /modal-cbos -->

            <div class="modal fade" id="modalConfirmOthers">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Transaction Confirmation for Fund Transfer for Others Bank Account</h4>
                  </div>
                <?php print form_open('',array('id' => 'frmConfirmOthers')) ?>

                  <div class="modal-body">
                    <div id="response-error"></div>
                    <table class="table table-bordered">
                      <tbody>
                        <tr >
                          <td>Transfer To : </td>
                          <td style="background:#ccc;"> 
                           Other Banks Account
                          </td>
                        </tr>
                        <tr>
                          <td>Account Number </td>
                          <td id="other_acct_no"> 
                           
                          </td>
                        </tr>
                        <tr>
                          <td>Account Name </td>
                          <td id="other_acct_name"> </td>
                        </tr>
                        <tr>
                          <td  >Bank Name </td>
                          <td id="other_bank_name"> </td>
                        </tr>
                         <tr>
                          <td >Transfer Currency </td>
                          <td id="other_ccy"> </td>
                        </tr>
                        
                         <tr>
                          <td>Transfer Amount </td>
                          <td id="other_trans_amount"> </td>
                        </tr>
                         <tr>
                          <td>Transfer Description </td>
                          <td id="other_trans_desc"> 
                           
                          </td>
                        </tr>

                      </tbody>

                    </table>  

                  </div>
                  <input type="hidden" name="other_acct_name">
                  <input type="hidden" name="other_account_no">
                  <input type="hidden" name="other_bank_name">
                  <input type="hidden" name="other_tran_type">
                  <input type="hidden" name="other_trans_amount">
                  <input type="hidden" name="other_benef_acct_no">
                  <input type="hidden" name="other_source_acct_no">
                  <input type="hidden" name="other_trans_desc">
                  <input type="hidden" name="other_ccy">



                          

                  <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button id="btn_confirm_others"  type="submit" class="btn btn-primary">Confirm</button>
                  </div>
                  <?php print form_close(); ?>
                </div>
              </div>
            </div><!-- /modal-others -->

          <hr>

          <?php $this->load->view('layouts/footer') ?>
          <script src="<?php print base_url('public/assets/vendors/num-seperator/jquery.number.min.js') ?>"></script>
          <script type="text/javascript">

             

            $('#myTab a').click(function (e) {
                e.preventDefault();
                $(this).tab('show');
              })
              $(document).ready(function(){
                validateInput('cbos');
                // validateInput('others');

                $('#cbos_send').attr("disabled","disabled");

                 $('input[name="trans_amount"]').number(true,2);
                 $('input[name="other_trans_amount"]').number(true,2);
               $current_account = $('#tdAcctNo').attr('data-account-no');

               if( $('input[name="trans_amount"]').val() < 0 ) {

                   $('#btn_confirm').attr("disabled","disabled");
              }

              $('input[name="trans_amount"]').keyup(function(){

                  validateInput('cbos');
              });

              $('textarea[name="trans_desc"]').keyup(function(){
                 validateInput('cbos');
              });

              $('input[name="trans_amount"]').keyup(function(){
                 validateInput('cbos');
              });

               $('input[name="others_trans_amount"]').keyup(function(){
                 validateInput('others');
              });
              
              $('input[name="others_trans_desc"]').keyup(function(){
                 validateInput('others');
              });
              $('input[name="others_trans_amount"]').keyup(function(){
                 validateInput('others');
              });


                $('.btn-clear').click(function(){
                  clearAllInputs();
                });

                $modal_cbos = $('#modalConfirmCbos');

                $modal_container = $('.modal-body');

                $('a#cbos_send').click(function(e){

                  e.preventDefault();
                  showCBOSConfirmation();
                });

                // handle transfer
                $('form[id="frmConfirmCBOS"]').submit(function(e){

                  e.preventDefault();
                  $formData = $(this).serialize();
                  // alert($formData);

                  $('#btn_confirm').attr("disabled","disabled");

                  $.ajax({

                    dataType : 'json',
                    method : 'GET',
                    data : $formData,
                    url : '<?php print base_url("accounts/async_cbos_process_transfer") ?>',

                    beforeSend : function(){

                      $('#response').html("<h3>Transferring Funds...</h3>");
                      clearAllInputs();
                    },

                    success : function(data){

                      console.log(data);
                      if ( data.response == 200){

                        $('.modal-body').append("<a href='<?php print current_url(); ?>' class='btn-reload btn btn-default'>Click here to reload</a>");
                         $('.modal-footer').remove();
                         $('.modal-title').html("<h4>Transfer request has been received.</h4>").css("color","#006633");
                        $('#response').html("<h4>Transfer request has been received for Fund Transfer for CBOS Account.</h4>").css("color","#006633");
                         clearAllInputs();
                         clearPage();

                      }else if(data.response == 500){
                       
                        $('.modal-footer').remove();
                        $('.modal-title').html("<h4>Transfer Error</h4>").css("color","#ff0000");
                        $('#response').html("<h4>"+ data.msg +"</h4>");
                        $('.modal-body table').remove();
                        $('.modal-body').html("Please try again.<br/><br/><a href='<?php print current_url(); ?>' class='btn btn-primary'>Reload Page</a>");

                      }

                    },

                    complete : function(){

                      clearPage();

                    }



                  }); 


                });



              function validateInput(open_tab){

                switch(open_tab){

                  case 'cbos' :

                    if(
                          $('select[name="cbos_acct_no"]').val() == ''

                           ||  $('input[name="trans_amount"]').val() == ''

                           || $('textarea[name="trans_desc"]').val() == ''
                        ) {

                        $('button#cbos_send').attr("disabled","disabled");

                      }else{

                         $('#cbos_send').removeAttr("disabled");

                        }
                  break;

                  case 'others' : 

                    if ( $('select[name="other_acct_no"]').val() == ''

                        || $('input[name="other_trans_amount"]').val() == ''

                        || $('select[name="other_trans_desc"]').val() == '' )

                     {

                      $('#others_send').attr("disabled","disabled");
                    
                    }else{

                       $('#others_send').removeAttr("disabled");
                    }
                 

                  break;
                }
                 
            }

                $('a#cbos_send').click(function(){

                  if ( $('input[name="trans_amount"]').val() == 0){

                    alert("Transfer amount cannot be zero!");
                    $('#modalConfirmCbos').hide();
                    return false;
                  }
                  $('td#confirm_acct_no').html($('select[name="cbos_acct_no"]').val());
                  $('td#confirm_trans_amount').html($('input[name="trans_amount"]').val());
                  $('td#confirm_trans_desc').html($('textarea[name="trans_desc"]').val());
                  $('input[ name="tran_amount"]').val($('input[name="trans_amount"]').val());
                  $('input[ name="trans_desc"]').val($('textarea[name="trans_desc"]').val());
                   $('#modalConfirmCbos').show();
                });

                  

                  $('select[name="cbos_acct_no"]').change(function(){

                      $acct_no = $(this).val();

                      if ($acct_no == $current_account){

                        alert("Cannot transfer to the same account!");
                        validateInput('cbos');
                        clearAllInputs();
                        return false;

                      }else if ( $acct_no == ''){

                        clearAllInputs();
                        validateInput('cbos');
                        return false;
                      }

                      getAccountDetails($acct_no,'cbos');
                     return false;
                      
                  });
              });

        /* End of CBOS handlers */

        /* Start Other Banks handlers */

        $('a#others_send').click(function(){

                 if ( $('input[name="others_trans_amount"]').val() == 0){

                    alert("Transfer amount cannot be zero!");
                    $('#modalConfirmOthers').hide();
                    return false;
                  }

                  $('td#other_acct_no').html($('select[name="other_acct_no"]').val());
                  $('td#other_trans_amount').html($('input[name="other_trans_amount"]').val());
                  $('td#other_trans_desc').html($('textarea[name="other_trans_desc').val());
                  $('input[name="other_trans_amount"]').val($('input[name="other_trans_amount"]').val());
                  $('input[name="other_trans_desc"]').val($('textarea[name="other_trans_desc"]').val());
                 $('#modalConfirmOthers').show();
                  showOthersConfirmation();

                });


         $('select[name="other_acct_no"]').change(function(){

                      $acct_no = $(this).val();

                      if ($acct_no == $current_account){

                        alert("Cannot transfer to the same account!");

                        clearAllInputs();
                        validateInput('others');
                        return false;

                      }else if ( $acct_no == ''){

                        clearAllInputs();
                        validateInput('others');
                        return false;
                      }

                      getAccountDetails($acct_no,'others');
                     return false;
                      
                  });
                 // handle other  transfer
                $('form[id="frmConfirmOthers"]').submit(function(e){

                  e.preventDefault();
                 
                  $formData = $(this).serialize();
                  // alert($formData);

                  $('#btn_confirm_others').attr("disabled","disabled");

                  handleOtherTransfer($formData);

                });

        function handleOtherTransfer(formData){

                  $.ajax({

                    dataType : 'json',
                    method : 'GET',
                    data : formData,
                    url : '<?php print base_url("accounts/async_other_process_transfer") ?>',

                    beforeSend : function(){

                      $('#response').html("<h3>Transferring Funds...</h3>");
                      clearAllInputs();
                    },

                    success : function(data){

                      console.log(data);
                      if ( data.response == 200){

                        $('#modalConfirmOthers.modal-body').append("<a href='<?php print current_url(); ?>' class='btn-reload btn btn-default'>Click here to reload</a>");
                         $('#modalConfirmOthers .modal-footer').remove();
                         $('#modalConfirmOthers .modal-title').html("<h4>Transfer Completed.</h4>").css("color","#006633");
                        $('#modalConfirmOthers #response').html("<h4>Transfer successfully completed for Fund Transfer for CBOS Account.</h4>").css("color","#006633");
                         clearAllInputs();
                         clearPage();

                      }else if(data.response == 500){
                       
                        $('#modalConfirmOthers.modal-footer').remove();
                        $('#modalConfirmOthers.modal-title').html("<h4>Transfer Error</h4>").css("color","#ff0000");
                        $('#modalConfirmOthers#response-error').html("<h4>"+ data.msg +"</h4>.");
                        $('#modalConfirmOthers.modal-body table').remove();
                        $('#modalConfirmOthers.modal-body').append("Please try again.<br/><br/><a href='<?php print current_url(); ?>' class='btn btn-primary'>Reload Page</a>");

                      }

                    },

                    complete : function(){

                      clearPage();

                    }
                  }); 
        }

        function getAccountDetails(acct_no,tran_type){
                   $.ajax({

                        dataType : 'json',
                        url : "<?php print base_url('accounts/async_get_details') ?>"+'/'+acct_no,

                      beforeSend : function(){


                      },

                      success : function(data){

                        if  (tran_type == 'cbos'){

                         displayAccountValuesForCBOSTransfer(data,acct_no);

                        }else if( tran_type == 'others'){

                          displayAccountValuesForOtherBanksTransfer(data,acct_no);
                        }
                         
                      },

                      complete : function(){


                      }
                        

                    });
         }

         function displayAccountValuesForCBOSTransfer(data,benef_acct_no){

                   $.each(data,function(key,val){
                            
                            $('td#acct_name').html(val.ACCT_DESC);
                            $('td#branch_ccy').html(val.BRANCH+' / '+ val.CCY);
                            $('td#beginning_bal').html(val.LEDGER_BAL * -1);
                            $('td#avail_bal').html(val.ACTUAL_BAL * -1);
                            $('td#trans_ccy').html(val.CCY);

                            $('input[name="acct_name"]').val(val.ACCT_DESC);
                            $('input[name="benef_acct_no"]').val(benef_acct_no);
                            $('input[name="branch"]').val(val.BRANCH);
                            $('input[name="ccy"]').val(val.CCY);
                            $('input[name="source_acct_no"]').val($current_account);
                            $('input[name="tran_type"]').val('111111');

                          });
         }

         function displayAccountValuesForOtherBanksTransfer(data,benef_acct_no){

               $.each(data,function(key,val){
                            
                            $('td#other_acct_name').html(val.ACCT_DESC);
                            $('td#other_ccy').html(val.CCY);
                            $('td#other_bank_name').html(val.BANK_NO);
                            $('td#other_trans_ccy').html(val.CCY);

                            $('input[name="other_acct_name"]').val(val.ACCT_DESC);
                            $('input[name="other_benef_acct_no"]').val(benef_acct_no);
                            $('input[name="other_ccy"]').val(val.CCY);
                            $('input[name="other_source_acct_no"]').val($current_account);
                            $('input[name="other_tran_type"]').val('111112');

                          });
          }




        function clearAllInputs(){

            $('input').val('');
            $('select').val('');
            $('.requiredValues').html('');
        }

        function showCBOSConfirmation(){

          $('#modalConfirmCbos').modal({

            backdrop : false
          });
        }

        function showOthersConfirmation(){

          $('#modalConfirmOthers').modal({

            backdrop : false
          });
        }


       

        function clearPage(){

          $('.span12').html("<h3>Plase reload the page to initiate another transactions.</h3>"+
            "<br/><a href='<?php print current_url(); ?>' class='btn btn-primary'>Reload Page</a>");
        }

          </script>
       
    </body>

</html>