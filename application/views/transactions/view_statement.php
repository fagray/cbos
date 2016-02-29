<div style="font-family: 'BankPrinter';font-size: 12px;" class="container">
  <div class="row" >
  

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
  <?php print 'OPENING BALANCE AS OF '. $d_start->format('d-M-y'). ' is '.$statement->START_BALANCE ?>
   <Br/><br/><strong><?php print $statement->ACCT_NO ?></strong>
    <table class="table table-hover">
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
        <?php foreach($transactions as $transaction){ 

            $d = new DateTime($transaction->TRAN_DATE);
         ?>

        <tr>
          <td><?php print $d->format('M d, Y') ?></td>
          <td><?php print $transaction->TRAN_DESC ?></td>
          <td><?php print $transaction->SEQ_NO ?></td>
          <td>
            <?php
              if($transaction->CR_DR_MAINT_IND == 'D'){
                 print $transaction->TRAN_AMT;
                }
              ?>
          </td>
          <td>
            <?php
              if($transaction->CR_DR_MAINT_IND == 'C'){
                 print number_format($transaction->TRAN_AMT *-1,2);
                }
              ?>
          </td>
          <td><?php print number_format($transaction->ACTUAL_BAL_AMT * -1,2) ?></td>
        </tr>

        <?php } ?>

      </tbody>
    </table>
    </div><!-- /col-md-12 -->

<p>Closing Balance as of <?php print $end_date.' is '. $statement->END_BALANCE; ?></p>
</div>


<div class="container">
  <a href="
  <?php print base_url('accounts/transactions/estatement/'.$statement->SEQ_NO.'/download/pdf') ?>"
   class="btn ">Download in PDF
  </a>
  <a href="
  <?php print base_url('accounts/transactions/estatement/'.$statement->SEQ_NO.'/download/csv') ?>"
   class="btn ">Download in CSV
  </a>
</div>
