    <footer>
                <p>Aces eGlobal Online Banking System &copy;  <?php print date('Y'); ?></p>
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

        <script type="text/javascript">

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