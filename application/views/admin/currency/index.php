        <!-- /content -->
        <div class="container">
            <div class="row">
              <?php $this->load->view('admin/layouts/sidebar') ?>
            <div class="col-md-9" id="content">
               <a class="blue-bg btn btn-primary pull-right" data-toggle="modal" href='#modal-id'>
                              Add New Rate
                </a><Br/><br/><br/>
             
                    <!-- block -->
                        <div class="panel panel-default">
                         
                            <div class="blue-bg panel-heading">
                              CURRENCY LIST AND RATES

                            </div>

                            <div class="panel-body">
                                <div class="col-md-12">
                                <p>Please define correctly the standard exchange rates for each currency.</p>
                                  <table class="table table-hover">
                                      <thead>
                                        <tr>
                                          <th>FROM</th>
                                          <th>TO</th>
                                          <th>Exchange Rate</th>
                                          <th>Action</th>
                                        </tr>
                                      </thead>
                                      <tbody>
                                        <?php foreach($currencies as $ccy){ ?>
                                          <tr>
                                            <td>
                                               
                                                <?php print $ccy->CCY_FROM;
                                                  
                                                  ?>
                                              
                                            </td>
                                            <td>
                                                <?php print $ccy->CCY_TO;
                                                     
                                                  ?>
                                            <td>
                                                <?php print $ccy->RATE; ?>
                                            </td>
                                           
                                            <td>

                                                <a id="linkChangeRate" 
                                                data-conv-id="<?php print $ccy->CONV_ID ?>" 
                                                data-curr-from="<?php print $ccy->CCY_FROM ?>" 
                                                data-curr-to="<?php print $ccy->CCY_TO ?>" 

                                                href="#">

                                                Change Rate</a>
                                            </td>
                                          
                                          </tr>
                                        <?php } ?>
                                      </tbody>
                                    </table>
                                </div><!-- /span12 -->
                            </div>
                        </div>
                        <!-- /block -->
                </div><!-- /content -->
            </div>    <!-- /row-fluid -->
          <hr>
          <div class="modal fade" id="modal-id">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                  <h4 class="modal-title">New Currency Rate</h4>
                </div>
                <div class="modal-body">
                 <?php echo form_open('acesmain/system/currency/rates/new'); ?>
                    
                    <div class="row">
                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="">From </label>
                          <select name="curr_from" id="inputCurr_from" class="form-control"   required="required">

                          <option value=""></option>
                          <?php foreach($all_currencies as $curr){ ?>

                            <option value="<?php print $curr->CCY ?>">
                              <?php print $curr->CCY.' ( '.$curr->CCY_DESC.')' ?></option>

                            <?php } ?>

                          </select>

                        </div>
                      </div><!-- /col-md-4 -->

                     
                       <div class="col-md-4">
                         <div class="form-group">
                          <label for="">To </label>
                           <select name="curr_to" id="inputCurr_to" class="form-control"   required="required">

                            <option value=""></option>
                            <?php foreach($all_currencies as $curr){ ?>

                              <option value="<?php print $curr->CCY ?>">
                                <?php print $curr->CCY.' ( '.$curr->CCY_DESC.')' ?></option>

                              <?php } ?>

                            </select>

                        </div>
                        
                      </div><!-- /col-md-4 -->

                      <div class="col-md-4">

                        <div class="form-group">
                          <label for="">Rate </label>
                          <input step="0.00001" name="curr_rate" type="number" class="form-control" id="" placeholder="Equivalent">
                        </div>

                        
                      </div><!-- /col-md-4 -->




                    </div><!-- /row -->
                  
                    <button type="submit" class="btn btn-primary blue-bg">Submit</button>

                  <?php print form_close(); ?>


                </div>
                
              </div>
            </div>
          </div><!-- /modal -->


          <div class="modal fade" id="modalUpdateRate">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                
                </div>
                <div id="update_rate_body" class="modal-body">
                    <?php print form_open('acesmain/system/currency/rates/update'); ?>
                    
                      <div class="form-group">
                        <label for="">Change rate to</label>

                        <input step="0.00001" name="curr_rate" type="number" class="form-control" id="" placeholder="Enter new rate">
                        <input type="hidden" name="curr_conv_id">
                      </div>
                    
                      
                    
                      <button type="submit" class="btn btn-primary">Save</button>

                   <?php print form_close(); ?>
                </div>
               
              </div>
            </div>
          </div>

        <?php $this->load->view('admin/layouts/footer') ?>

   

        <script type="text/javascript">

          var from = '';
          var to = '';

            $(document).ready(function(){

             

                $('select[name="curr_from"]').change(function(){

                   from = $(this).val();
                   check();
                });

                $('select[name="curr_to"]').change(function(){

                    to = $(this).val();

                    check();

                });


                $('a#linkChangeRate').click(function(e){
                  e.preventDefault();
                  $conv_id = $(this).attr('data-conv-id');
                  $from = $(this).attr('data-curr-from');
                  $to = $(this).attr('data-curr-to');

                  $('input[name="curr_conv_id"]').val($conv_id);

                  $('#modalUpdateRate .modal-header').html('Change Rate  From ' + $from 
                        + ' to '+ $to
                    );

                  $('#modalUpdateRate').modal({
                      backdrop : false
                  });

                });

               

             });

            function check(){

                if (from == to){

                    alert('Invalid selection !');

                  clearInputs();
                }
            }

            function clearInputs(){
              $('select').val('');
            }

            
              
        </script>
       
    </body>

</html>