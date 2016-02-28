        <!-- /content -->
       
            <div class="row">
              <?php $this->load->view('admin/layouts/sidebar') ?>
            <div class="col-md-9" id="content">
             <?php if($this->session->flashdata('msg')){ ?>
                                        <div class="alert alert-danger">
                                            <?php print $this->session->flashdata('msg'); ?>
                                        </div>
                                    <?php } ?>
                <span class="pull-right">
              
                </span>                    
            
                    <!-- panel -->
                     <span id="loader"></span>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="panel panel-default">
                                    <div class="blue-bg panel-heading">
                                        Search for account details
                                    </div>
                                    <div class="panel-body">
                                        <?php print form_open('',array('name' => 'frmAcctNo')); ?>
                                          
                                            <div class="form-group">
                                                <label for="">Account No.</label>
                                                <?php print form_input('acct_no', '',array('class' => 'form-control','placeholder'  => 'Enter account number')); ?>
                                            </div>
                                        
                                            
                                            <?php print form_submit('btn_acct_no_submit','Search',array('class' => 'btn btn-primary')) ?>
                                       <?php print form_close(); ?>
                                    </div><!-- /panel-body -->
                                </div><!-- /panel default -->
                            </div><!-- /col-md-6 -->
                              <div class="col-md-6">
                                <div class="panel panel-default">
                                    <div class="blue-bg panel-heading">
                                        Search for transactions
                                    </div>
                                    <div class="panel-body">
                                        <form action="" method="POST" role="form">
                                          
                                            <div class="form-group">
                                                <label for="">Transaction Start Date</label>
                                                <input type="text" class="col-md-6 form-control" id="trans_start_date" placeholder="Input field">
                                            </div>

                                            <div class="form-group">
                                               <label for="">Transaction End Date</label>
                                                <input type="text" class="form-control" id="trans_end_date" placeholder="Input field">
                                            </div>
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                        </form>
                                    </div><!-- /panel-body -->
                                </div><!-- /panel default -->
                            </div><!-- /col-md-6 -->

                        </div><!-- /row -->
                     
                        <div class="panel panel-default">
                            <div class="blue-bg panel-heading">
                                Statistics 
                            </div>
                            <div class="panel-body ">
                                <div class="col-md-12">
                                    <div class="row" align="center">
                                        <div class="col-md-4">
                                            <img src="<?php print base_url('public/assets/img/dashboard/clients.png') ?>">
                                             <p style="font-size: 28px;"> <?php print $client_count; ?></p>
                                             <p>Total Clients</p>
                                        </div><!-- /col-md-4 -->
                                         <div class="col-md-4">
                                            <img src="<?php print base_url('public/assets/img/dashboard/accounts.png') ?>">
                                             <p style="font-size: 28px;">  <?php print $accounts_count; ?></p>
                                             <p>Total Accounts</p>
                                        </div><!-- /col-md-4 -->

                                         <div class="col-md-4">
                                             <img src="<?php print base_url('public/assets/img/dashboard/transfers.png') ?>">
                                             <p style="font-size: 28px;">  <?php print $transfers_count; ?></p>
                                             <p>Successful Tranfers</p>
                                        </div><!-- /col-md-4 -->
                                    </div><!-- /row -->
                             
                                  
                                </div>
                            </div>
                        </div>
                        <!-- /block -->
                </div><!-- /content -->
                </div>    <!-- /row -->

                <div class="modal fade" id="modalError">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="blue-bg modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h4 class="modal-title"> Account Not found.</h4>
                            </div>
                            <div class="modal-body">
                                <p style="color:red;">Sorry, no results found for your query. Account not found.</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
                 <div class="modal fade" id="modalSuccess">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="blue-bg modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h4 class="modal-title"> </h4>
                            </div>
                            <div class="modal-body">
                                <div class="panel panel-default">
                                    <div class="panel-heading blue-bg">ACCOUNT HOLDER DETAILS</div>
                                        <div  id="acctDetails" class="panel-body">
                                            
                                        </div><!-- /panel-body -->

                                </div><!-- /panel-default -->    
                                <div style="max-height: 150px;overflow:hidden;" class="panel panel-default">
                                    <div class="panel-heading blue-bg">Recent Transactions
                                
                                    </div>
                                    <table  class="table table-hovered">
                                        <thead>
                                            <tr>
                                                <th>Transaction ID</th>
                                                <th>Request Tiemstamp</th>
                                                <th>Type</th>
                                            </tr>
                                        </thead>
                                        <tbody id="trans_tbody">
                                           
                                        </tbody>
                                    </table>
                                    <button type="button" class="btn btn-default">View all</button>
                                </div><!-- /panel-default -->
                                
                            </div>
                            <div class="modal-footer">
                                <!-- <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> -->
                                <a id="linkTransaction" class="btn btn-default">View all transactions</a>
                                <a  id="linkClientAccount" class="btn btn-default">Go to client account</a>
                            </div>
                        </div>
                    </div>
                </div>

              <hr>
        <?php $this->load->view('admin/layouts/footer') ?>
        <script type="text/javascript" src="<?php print base_url('public/assets/vendors/datepicker/jquery.datetimepicker.js') ?>"></script>

        <script type="text/javascript">
            $(document).ready(function(){

                $('.modal').find('button.close').click(function(){
                    $('input[name="acct_no"]').val('');
                    enableInputs();
                });


                $base_url = getBaseUrl();
                setDatePicker();
           
                $tr  = '<tr>';
                $('form[name="frmAcctNo"]').submit(function(e){

                    e.preventDefault();
                    $formData = $(this).serialize();
                    $acct_no = $(this).find('input[name="acct_no"]').val();
                    handle_request($formData,$acct_no);
                });
            });

            function handle_request(formdata,acct_no){

                $.ajax({

                    url : "<?php print base_url('acesmain/accounts/search') ?>",
                    method : 'GET',
                   
                    data : formdata,
                    dataType : 'json',

                    beforeSend : function(){

                        $('span#loader').html('<div class="progress progress-striped active">'+
                            '<div class="progress-bar" style="width: 100%"></div></div>');
                        
                       disableInputs();
                    },

                    success : function(data){

                        $('a#linkTransaction').attr('href',$base_url+'acesmain/clients/'+data[0].CLIENT_NO+'/transactions');
                        $('a#linkClientAccount').attr('href',$base_url+'acesmain/clients/'+data[0].CLIENT_NO+'/details');
                        console.log(data);
                        removeLoader();
                        showAccountDetails(data,acct_no);
                        showAccountHolderDetails(data);
                    },

                    error : function(){
                        handleError();
                        enableInputs();
                        removeLoader();
                    }
                });
            }

            function disableInputs(){

                $('input').attr("disabled","disabled");
            }

            function enableInputs(){
                $('input').removeAttr("disabled");
                $('span#loader').html('');
            }

            function handleError() {
               $('#modalError').modal({
                backdrop : false
               });
            }

            function showAccountHolderDetails(data){

                 $modal =  $('#modalSuccess');
               $modal.find('#acctDetails').html('<p>Client Name :' + data[0].CLIENT_NAME
                         +'  | Client No. ' + data[0].CLIENT_NO+'</p>'
                         +'<p>Client Grp. : ' + data[0].CLIENT_GRP+'</p>'
                         +'<p>Bank No. :  ' + data[0].BANK_NO+'</p>'
                         +'<p>Alias :' + data[0].CLIENT_ALIAS+'</p>'

                         );
            }

            function showAccountDetails(data,acct_no){

                $modal =  $('#modalSuccess');
             
                $modal.find('.modal-title').html('Account Details.Account No. '+acct_no );
                $.each(data,function(key,val){

                    showTransactionData(val);
                }); 
              
                $modal.find('tbody#trans_tbody').append($tr);
                removeDataTableComponents($modal);

                $modal.modal({

                    backdrop : false
                });
            }

            function removeDataTableComponents(element){

                element.find('tr.odd').remove();
                element.find('.btn-group').remove();
                element.find('div.dataTables_length').remove();
                element.find('div.dataTables_length').remove();
                element.find('div.dataTables_filter').remove();
                element.find('div.dataTables_info').remove();
                element.find('.pagination').remove();

            }


            function showTransactionData(val){

                $tr +=   '<td>'+  val.TRAN_ID +'</td>';
                $tr +=   '<td>'+  val.TRAN_DATE  +'</td>';
                $tr +=   '<td>'+  val.TYPE_DESC +'</td>';
                $tr +=   '</tr>';    

            }
            
             function setDatePicker(){

             $('#trans_start_date').datetimepicker({
                    format:'Y-m-d',
                    timepicker:false,
                    mask:true,
                });

                $('#trans_end_date').datetimepicker({
                    format:'Y-m-d',
                    timepicker:false,
                    mask:true,
                });
            }

            function removeLoader(){
                $('span#loader').html('');
            }

            function getBaseUrl(){

                return $('.container span#base_url').attr("data-value");
            }


        </script>
       
    </body>

</html>