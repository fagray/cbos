<div class="container">
  
 <p >Current Time : <?php print date('D, M d, Y G:i:s'); ?></p>
 
 <div class="well well-default">
   <p>Welcome <strong><?php print $this->session->userdata('client_name'); ?> </strong>  to CBOS Online Banking Application.
       Your last login was last <?php print $this->session->userdata('last_login'); ?>
   </p>
</div>


</div><!-- /container -->

<div class="col-md-3" id="sidebar">
    <div class="list-group">


        <a class="list-group-item 
        <?php 
        if($page == 'AS')

            { print 'active'; } ?>"

        href = "<?php print base_url(); ?>">
        <i class="icon-chevron-right"></i> Account Summary
    </a>


    <a class="list-group-item 

    <?php 
    if($page == 'TH')

        { print 'active'; } ?>"

    href ="<?php print base_url('accounts/transactions/history'); ?>">


    <i class="icon-chevron-right"></i> Transaction History



</a>
<a class="list-group-item

<?php 
if($page == 'ES')

    { print 'active'; } ?>" 

href ="<?php print base_url('accounts/e-statements   '); ?>">
<i class="icon-chevron-right"></i> Download eStatement
</a> 
<a class="list-group-item

<?php 
if($page == 'FT')

    { print 'active'; } ?>"


href ="<?php print base_url('accounts/transactions/transfer'); ?>">
<i class="icon-chevron-right"></i> Fund Transfer
</a> 

<a class="list-group-item

<?php 
if($page == 'CP')

    { print 'active'; } ?>" 

href ="<?php print base_url('accounts/settings/change-password'); ?>">
<i class="icon-chevron-right"></i> Change Password
</a> 
<a class="list-group-item" href ="<?php print base_url('auth/session/logout'); ?>">
    <i class="icon-chevron-right"></i> Signout
</a>
</div>

</div><!-- //col-md-3 -->
