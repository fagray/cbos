            <footer>
               <span style="color:#09F;">aces EGlobal, Inc.</span>  
                <img style="" src="<?php print base_url('public/assets/img/aces.png') ?>">
            </footer>
        </div><!-- /container -->
          
        </div>
        <!--/.fluid-container-->
        <script src="<?php print base_url('public/assets/js/jquery.js') ?>"></script>
        <script src="<?php print base_url('public/assets/bootstrap/js/bootstrap.js') ?>"></script>
        <script src="<?php print base_url('public/assets/vendors/pace/pace.min.js') ?>"></script>
        <script src="<?php print base_url('public/assets/vendors/data-tables/jquery.dataTables.min.js') ?>"></script>
        <script src="<?php print base_url('public/assets/vendors/data-tables/dataTables.tableTools.js') ?>"></script>
        <script src="<?php print base_url('public/assets/vendors/data-tables/dataTables.bootstrap.js') ?>"></script>
        <script src="<?php print base_url('public/assets/vendors/dialog/dialog.js') ?>"></script>
        <script src="<?php print base_url('public/assets/js/jquery.idle.min.js') ?>"></script>
        <script type="text/javascript">


        $(document).idle({
                  onIdle: function(){

                    showDialog();

                    // if( ! confirm("Your inactive for 30 seconds, do you want to continue ? ")){

                    //     window.location.href="<?php print base_url('auth/session/logout') ?>";

                    // }
                    
                    
                  },
                  idle: 30000 // 30 seconds of inactivity
                })

            function showDialog(){

                var header = 'Inactive';
                var message = 'You are inactive for 30 seconds, do you want to continue ?';
                var options = {
                                  overlay: 'no',
                                  buttons: {

                                    'yes':  'save',
                                    'no': 'alert'
                                  }
                                };

                 $.showQuestionDialog(header, message, options, function(response){
                          // Your code here...
                          // For example to check if the ok button is pressed you could do
                          if (response === 'no') {
                            
                            // logout the user
                            window.location.href="<?php print base_url('auth/session/logout') ?>";

                          }
                          
                        });

            }


            $(document).ready(function(){

                 //data-tables
                $('table.table').DataTable( {
                    dom: 'T<"clear">lfrtip',
                    tableTools: {

                        "sSwfPath": "<?php print base_url('public/assets/vendors/data-tables/swf/copy_csv_xls_pdf.swf') ?>"
                    }
                    }); //end data-tables

            });
        </script>