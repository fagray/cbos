<!DOCTYPE html>
<html class="no-js">
    
    <head>
        <title>acesglobal | User Dashboard</title>
        <!-- Bootstrap -->
        <link href="<?php print base_url('public/assets/bootstrap/css/bootstrap.min.css') ?>" rel="stylesheet" media="screen">
        <link href="<?php print base_url('public/assets/bootstrap/css/bootstrap-responsive.min.css') ?>" rel="stylesheet" media="screen">
        <link href="<?php print base_url('public/assets/css/styles.css') ?>" rel="stylesheet" media="screen">
        <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
        <!--[if lt IE 9]>
            <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
        <script src="vendors/modernizr-2.6.2-respond-1.1.0.min.js"></script>
    </head>
    
    <body>
     <div class="navbar navbar-fixed-top">
            <div class="navbar-inner">
                <div class="container-fluid">
                    <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse"> <span class="icon-bar"></span>
                     <span class="icon-bar"></span>
                     <span class="icon-bar"></span>
                    </a>
                    <a style="color:gray;font-size:18px;letter-spacing: 5px;" class="brand" href="#">acesglobal </a>
                    
                    <!--/.nav-collapse -->
                </div>
            </div>
        </div>

        <!-- /content -->
        <div class="container-fluid">

            <div class="row-fluid">

                <div class="span3" id="sidebar">
                    <ul class="nav nav-list bs-docs-sidenav nav-collapse collapse">
                        <li class="active">
                            <a href="<?php print base_url(); ?>"><i class="icon-chevron-right"></i> Account Summary</a>
                        </li>
                         <li>
                            <a href="<?php print base_url(); ?>"><i class="icon-chevron-right"></i> Transaction History</a>
                        </li>
                        <li>
                            <a href="<?php print base_url(); ?>"><i class="icon-chevron-right"></i> Download eStatement</a>
                        </li>
                        <li>
                            <a href="<?php print base_url(); ?>"><i class="icon-chevron-right"></i> Fund Transfer</a>
                        </li>
                        <li>
                            <a href="<?php print base_url(); ?>"><i class="icon-chevron-right"></i> Change Password</a>
                        </li>

                       
                    </ul>
                </div><!-- /sidebar -->
                <div class="span9" id="content">
                <span class="pull-right">
                    <p>Logged in as : <?php print $this->session->userdata('usrname'); ?> | <a href="auth/session/logout">Logout </a></p>
                </span>                    
                <h3>Account Summary</h3>
                    <!-- block -->
                        <div class="block">
                            <div class="navbar navbar-inner block-header">
                                <div class="muted pull-left">My Accounts </div>
                            </div>
                            <div class="block-content collapse in">
                                <div class="span12">
                                    <table class="table table-hover">
                                      <thead>
                                        <tr>
                                          <th>Branch Name</th>
                                          <th>Account No.</th>
                                          <th>Description</th>
                                          <th>Currency</th>
                                          <th>Beginning Balance</th>
                                          <th>Available Balance</th>
                                        </tr>
                                      </thead>
                                      <tbody>
                                      <?php foreach ($accounts as $account) { ?>
                                        <tr>
                                          <td><?php print $account->branch; ?></td>
                                          <td><?php print $account->acct_no ?></td>
                                          <td><?php print $account->acct_desc ?></td>
                                          <td><?php print $account->ccy ?></td>
                                          <td><?php print number_format($account->ledger_bal,2) ?></td>
                                          <td><?php print number_format($account->actual_bal,2) ?></td>
                                        </tr>
                                      <?php } ?>
                                       
                                     
                                      </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- /block -->
                </div><!-- /content -->
            </div>    <!-- /row-fluid -->
              <hr>
            <footer>
                <p>Aces Global Online Banking System &copy;  <?php print date('Y'); ?></p>
            </footer>
        </div><!-- /container -->
          
        </div>
        <!--/.fluid-container-->
        <script src="<?php print base_url('public/assets/vendors/jquery-1.9.1.min.js') ?>"></script>
        <script src="<?php print base_url('public/assets/bootstrap/js/bootstrap.min.js') ?>"></script>
        <script src="assets/scripts.js"></script>
       
    </body>

</html>