
<div style="font-family: 'BankPrinter';font-size: 12px;" class="container">

<img  style="margin-left:230pt;" src="<?php print base_url('public/assets/img/cbos.png') ?>">
<div style="clear:both; position:relative;">
    <div style="position:absolute; left:0pt; width:192pt;">
      <p><?php print $statement->CLIENT_NAME ?></p>
      <p>STATEMENT OF ACCOUNT FOR </p><br/>
      <p><?php print $statement->ACCT_DESC ?></p>
      <p><?php print $statement->ADDR1 ?></p>
      <p><?php print $statement->ADDR2 ?></p>
    </div>
    <div style="margin-left:350pt;">
         <p>STATEMENT DATE   : <?php print date('d-m-Y g:i:s' ) ?></p>
        <p>STATEMENT PERIOD : 
          <?php 
            $d_start  = new DateTime($statement->START_DATE);
            $d_end    = new DateTime($statement->END_DATE);
            print   $d_start->format('d-M-y'). ' - '.$d_end->format('d-M-y');
         
          ?>
        </p><br/><br/><br/>
        <p>A/C NO. TYPE/CCY :
          <?php print $statement->ACCT_NO.' '.$statement->ACCT_TYPE.'/'.$statement->CCY ?>
        </p>
    </div><!-- /right-column -->

</div>

<div  class="stmt-transactions"><br/>
  <strong><?php print $statement->ACCT_NO ?></strong>
    
    <table cellspacing="5" cellpadding="5" style="margin-top:30pt;font-size:12px !important;font-family: 'BankPrinter !important';" >
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
          
           <?php if($transaction->CR_DR_MAINT_IND == 'D'){

              print number_format($transaction->TRAN_AMT,2); }

            ?>
              
            
          </td>

          <td>
            <?php
            
                   if($transaction->CR_DR_MAINT_IND == 'C'){

                    print number_format($transaction->TRAN_AMT,2);

                  }
                
                
              ?>
          </td>
         

          <td>
            <?php 

             

                print number_format( -1 * $transaction->ACTUAL_BAL_AMT,2);
              
              
              
             ?>
          </td>
        </tr>

        <?php } ?>

      </tbody>
    </table>
    <p>Closing Balance as of <?php print $end_date.' is '; ?>
    <?php 

   
        print number_format( $statement->END_BALANCE,2);
     ?>
  </p>

  <p>Total number of transactions : <?php print count($transactions); ?></p>
</div>


</div><!-- /container -->
</div><!-- /transactions -->



 
