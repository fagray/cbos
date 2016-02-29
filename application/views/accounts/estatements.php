        <!-- /content -->
  
          <?php $this->load->view('layouts/main-header') ?>
         
            <div class="row">


              <?php $this->load->view('layouts/sidebar') ?>
            

            <div class="col-md-9" id="content">
                <span class="pull-right">
              
                </span>                    
                <h3>e-Statements</h3>
                    <!-- block -->  
                        <div class="panel panel-default">
                            <div class="blue-bg panel-heading">
                                e-Statement List
                            </div>
                            <div class="panel-body">
                                <div class="col-md-12">
                                    <table class="table table-hover">
                                      <thead>
                                        <tr>
                                          <th>Account No.</th>
                                          <th>SEQ_NO</th>
                                          <th>Staement as of</th>
                                        
                                          <th>Action</th>
                                        </tr>
                                      </thead>
                                      <tbody>
                                   <?php foreach ($estatements as $estatement) { ?>
                                        <tr>
                                          <td><?php print $estatement->ACCT_NO ?></td>
                                          <td><?php print $estatement->SEQ_NO; ?></td>
                                          <td>
                                            <?php 
                                              $d_start = new DateTime($estatement->START_DATE);
                                              $d_end = new DateTime($estatement->START_DATE);
                                              print 
                                                $d_start->format('d-M-y'). ' - ' 
                                                .$d_end->format('d-M-y');
                                            ?>
                                          </td>
                                        
                                           <td>
                                            <a href="<?php print base_url('accounts/transactions/estatement/'.$estatement->SEQ_NO.'/download/pdf') ?>">
                                                Download in PDF
                                            </a> | 
                                             <a href="<?php print base_url('accounts/transactions/estatement/'.$estatement->SEQ_NO.'/download/csv') ?>">
                                                Download in CSV
                                            </a>
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