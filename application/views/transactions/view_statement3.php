<style type="text/css">
  
@font-face{

  src:url('<?php print base_url("public/assets/font/F25_Bank_Printer.ttf")  ?>');
  font-family: 'BankPrinter';
}


</style>

<div style="font-size: 12px;position: relative;bottom:50px;" class="container">
  <div class="pull-right">
  <a href="<?php print base_url('accounts/transactions/history') ?>">
    Back to previous page
  </a> | 
  <a href="<?php print base_url() ?>">
    Back to Main
  </a> | 
  <a href="
  <?php print base_url('accounts/transactions/estatement/'.$statement->SEQ_NO.'/download/pdf') ?>"
  >Download in PDF
  </a> | 
  <a href="
  <?php print base_url('accounts/transactions/estatement/'.$statement->SEQ_NO.'/download/csv') ?>"
   >Download in CSV
  </a>
</div>
</div><!-- /container -->

<div style="font-family: 'BankPrinter';font-size: 12px;" class="container">
  <div class="row" style=" font-family: 'BankPrinter';font-size: 12px;" >
 

    <div class="col-md-4">
      <p><?php print $statement->CLIENT_NAME ?></p>
      <p>STATEMENT OF ACCOUNT FOR </p><br/>
      <p><?php print $statement->ACCT_DESC ?></p>
      <p><?php print $statement->ADDR1 ?></p>
      <p><?php print $statement->ADDR2 ?></p>
    </div><!-- /col-md-4 -->

     <div class="col-md-offset-3 col-md-5">
        <br/><br/>
        <p>STATEMENT DATE   : <?php print date('d-m-Y g:i:s' ) ?></p>
        <p>STATEMENT PERIOD : 
          <?php 
            $d_start  = new DateTime($statement->START_DATE);
            $d_end    = new DateTime($statement->END_DATE);
            print   $d_start->format('d-M-y'). ' - '.$d_end->format('d-M-y');
            // print_r($statement);
          ?>
        </p>
        <p>A/C NO. TYPE/CCY :
          <?php print $statement->ACCT_NO.' '.$statement->ACCT_TYPE.'/'.$statement->CCY ?>
        </p>
    </div><!-- /col-md-4 -->
  </div><!-- /row -->
  <div class="row">
 
   <strong><?php print $statement->ACCT_NO ?></strong>
    
    <table  class="table table-hover">
      <thead>
        <tr>
          <th>Tran Date</th>
          <th>Transaction Desc</th>
          <th>Cheque /  Seq. No.</th>
          <th>Withrawal</th>
          <th>Deposit</th>
          <th>Balance</th>
        </tr>
      </thead>
      <tbody>
      <tr>
          <td colspan="2">Opening Balance as of</td>
          <td><?php print $statement->START_DATE; ?></td>
          <td></td>
          <td></td>
          <td> <?php print number_format($statement->START_BALANCE,2) ?></td>
          
      </tr>
        <?php foreach($transactions as $transaction){ 

            $d = new DateTime($transaction->TRAN_DATE);
         ?>

        <tr>
          <td><?php print $d->format('M d, Y') ?></td>
          <td>
            <?php 

              if(isset($transaction->TRAN_ID)){

                  print $transaction->trans_desc;
              }else{

                print $transaction->TRAN_DESC;
              }

            ?>
          </td>

          <td>
            <?php 

              if(isset($transaction->TRAN_ID)){

                print "----";
              }else{

                print $transaction->SEQ_NO;
              }
            ?>
          </td>
          <td>

           

          </td>

          <td>
            <?php
                if(isset($transaction->TRAN_ID)){

                    print number_format($transaction->trans_amt,2);
                }else{

                  print number_format($transaction->TRAN_AMT,2);
                }
                
              ?>
          </td>
         

          <td>
            <?php 

              if(isset($transaction->TRAN_ID)){

                  print number_format(-1* $transaction->trans_bal,2);
                  
              }else{

                 print number_format(-1* $transaction->ACTUAL_BAL_AMT,2);
              }
              
              
             ?>
          </td>
        </tr>

        <?php } ?>

      </tbody>
    </table>

    </div><!-- /col-md-12 -->

<p>Closing Balance as of <?php print $end_date.' is '; ?>
<?php 

  if($statement->END_BALANCE < 0 ) { print number_format(-1 * $statement->END_BALANCE,2); } 
    else {
        print number_format( $statement->END_BALANCE,2);
     } ?>
  </p>
  <p>Total number of transactions : <?php print count($transactions); ?></p>
</div>
<hr/>
<div class="container">
  <?php $this->load->view('layouts/footer') ?>
</div>

