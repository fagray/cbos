
        <!-- /content -->
          <?php $this->load->view('layouts/main-header') ?>
            <div class="row">
            
              <?php $this->load->view('layouts/sidebar') ?>

            <div class="col-md-9" id="content">
                 
                <h3>eStatements</h3>
                          
                                
                
            </div><!-- /col-md-9 -->
            <div class="modal fade" id="modalFilter">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Filter Transactions</h4>
                  </div>
                  <div  class="panel panel-default">
                        <div class="heading-status panel-heading blue-bg">
                          Prepare an eStatement
                           
                        </div>
                        <div class="panel-body">
                            <div class="col-md-12">
                            <span id="loader"></span>
                               <?php print form_open(); ?>
                                <div class="row">
                                  <div class="col-md-4">
                                    <div class="form-group">
                                    <label for="">Client No.</label>
                                    <input value="<?php print $this->session->userdata('client_no') ?>" disabled type="text" name="client_no" class=" form-control"   title="">
                                  </div>
                                  </div><!-- /col-md-4 -->
                                <!--   <div class="col-md-4">
                                    <div class="form-group">
                                      <label for="">Currency</label>
                                     <select class="form-control">
                                       <option></option>
                                       <?php foreach($currencies as $ccy){ ?>
                                        <option value="<?php print $ccy->CCY ?>">
                                          <?php print $ccy->CCY. ' - '. $ccy->CCY_DESC ?>
                                         </option>
                                       <?php } ?>
                                     </select>
                                    </div>
                                  </div> --><!-- /col-md-4 -->
                                  <div class="col-md-8">
                                    <div class="form-group">
                                      <label for="">Account Number</label>
                                      <select style="font-size: 15px !important;" name="acct_no" id="inputAcct_no" class="form-control" required="required">
                                        <option value=""></option>
                                        <?php foreach($accounts as $account){ ?>
                                          <option value="<?php print $account->ACCT_NO ?>">
                                            <?php print $account->ACCT_NO ?>
                                          </option>
                                        <?php } ?>
                                      </select>
                                    </div>
                                  </div><!-- /col-md-4 -->
                                </div><!-- /row -->
                                 <div class="row">
                                 <!--  <div class="col-md-6">
                                     <div class="form-group">
                                      
                                      <label for="">Account Type</label>
                                      <select name="acct_type" id="inputAcct_type" class="form-control" required="required">
                                        <option value=""></option>
                                        <option value="GBT">GBT</option>
                                        <option value="GVT">GVT</option>
                                        <option value="CSR">CSR</option>
                                      </select>
                                    </div>
                                  </div> --><!-- /col-md-6 -->
                                  <div class="col-md-6">
                                    <div class="form-group">
                                      <label for=""> Start Date</label>
                                      <input type="text" name="start_date" id="tbFrom" class="form-control" value=""   title="">
                                    </div>
                                  </div><!-- /col-md-3 -->
                                  <div class="col-md-6">
                                    <div class="form-group">
                                      <label for="">  End Date </label>
                                     <input type="text" name="end_date" id="tbTo" class="form-control" value=""  title="">
                                    </div>
                                  </div><!-- /col-md-3 -->
                                </div><!-- /row -->

                                  <?php print form_submit('btn_filter', 'Prepare/ Display eStatement',
                                    array('class' => ' blue-bg btn btn-primary')); ?>
                                  
                              <?php print form_close(); ?>                             
                            </div><!-- /span12 -->
                        </div><!-- /panel-content -->
                      </div><!-- /panel -->
           
                </div><!-- /modal-content -->
              </div><!-- /modal-dialog -->
            </div><!-- /modal-filter -->
            </div>
            <hr>

      <?php $this->load->view('layouts/footer') ?>
      <script type="text/javascript" src="<?php print base_url('public/assets/vendors/datepicker/jquery.datetimepicker.js') ?>"></script>
      <script type="text/javascript">

        $(document).ready(function(){

          $base_url = $('span#base').attr('data-value');
          setDatePicker();
          showFilterModal();

          $('form').submit(function(e){

              e.preventDefault();
              $formData = $(this).serialize();
              handleRequest($formData);

          });
        });// document ready end

        function handleRequest(data){
          console.log(data);

          $.ajax({

              method  : 'GET',
              url     :  $base_url+'accounts/transactions/aysnc_get_transactions',
              data : data,
              dataType: 'json',
              

              beforeSend : function(){

                disableInputs();
                 $('span#loader').html('<div class="progress progress-striped active">'+
                            '<div class="progress-bar" style="width: 100%"></div></div>'+
                            '<p>Processing request...</p>');

              
              },

              success : function(response_data){
                console.log(response_data);
                console.log(response_data.seq_no);

                    if(response_data.response == '200'){
                        alert("eStatement has been generated ! ");
                        base = $base_url;
                      //success 
                      // $updatedText = "<a class='btn btn-primary' href='"+base_url+"accounts/transactions/estatement/+data.seq_no">View transaction+'</a>';
                       $('.heading-status').html('eStatement has been successfully generated').css("background","#006633");
                       $('#modalFilter .panel-body .col-md-12').html('<a href="'+base+'accounts/'+'transactions/estatement/'+response_data.seq_no+'">View eStatement</a>');

                        // $('#modalFilter .modal-body .col-md-12').html('<h3>'+data.msg+'</h3>')

                      // console.log(data);
                    return false;

                  }else if(response_data.response == '500'){
                        alert("error");
                    alert("An error occured.Operation aborted.Please try again.");
                    return false;
                  }

                // console.log(data.response);
               
            }

          });
        }


          function setDatePicker(){

             $('#tbFrom').datetimepicker({
                    format:'Y-m-d',
                    timepicker:false,
                    mask:true,
                });

                $('#tbTo').datetimepicker({
                    format:'Y-m-d',
                    timepicker:false,
                    mask:true,
                });
            }

            function showFilterModal(){

                $('.modal#modalFilter').modal({

                  backdrop :false
                  
                });
              
            }

            function disableInputs(){

              $('input').attr("disabled","disabled");
            }
        

        </script>
    </body>

</html>