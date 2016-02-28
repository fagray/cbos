<div class="container">
  

<p>Opening Balance as of <?php 

  print $params['start_date'].' is '. number_format($params['op_bal'],2); 

  ?></p>
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
             print number_format($transaction->TRAN_AMT,2);
            }
          ?>
      </td>
      <td><?php print number_format($transaction->ACTUAL_BAL_AMT * -1,2) ?></td>
    </tr>

    <?php } ?>

  </tbody>
</table>

<!-- <p>Closing Balance as of <?php print $params['end_date'].' is '. $params['op_bal']; ?></p>
 --></div>
