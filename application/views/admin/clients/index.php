        <!-- /content -->
        <div class="container">
            <div class="row">
              <?php $this->load->view('admin/layouts/sidebar') ?>
            <div class="col-md-9" id="content">

             
                    <!-- block -->
                        <div class="panel panel-default">
                            <div class="blue-bg panel-heading">
                              CLIENTS LIST

                            </div>
                            <div class="panel-body">
                                <div class="col-md-12">
                                Export options
                                  <table class="table table-hover">
                                      <thead>
                                        <tr>
                                          <th>Global Id</th>
                                          <th>Client Name</th>
                                      
                                         
                                          <th>Action</th>
                                        </tr>
                                      </thead>
                                      <tbody>
                                        <?php foreach($clients as $client){ ?>
                                          <tr>
                                            <td>
                                               
                                              <?php print $client->GLOBAL_ID ?>
                                              
                                            </td>
                                            <td><?php print $client->CLIENT_ALIAS ?></td>
                                            
                                            <td>
                                                  <a href="<?php print base_url('acesmain/clients/'.$client->GLOBAL_ID.'/details') ?>">
                                                   View Client
                                                </a>
                                                
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
        <?php $this->load->view('admin/layouts/footer') ?>

        <!-- /External files -->
        <link rel="stylesheet" type="text/css" href="<?php print base_url('public/assets/vendors/autocomplete/jquery.auto-complete.css') ?>">
        <script src="<?php print base_url('public/assets/vendors/autocomplete/jquery.auto-complete.min.js') ?>"></script>
        <script type="text/javascript">

            $(document).ready(function(){

              $('input[name="client_no"]').keyup(function(){
                    $element = $(this);
                    var term = $(this).val();
                        $.getJSON('<?php print base_url("acesmain/clients/find") ?>', { q: term }, 
                            function(data){
                              console.log(data);
                                if ( data[0].response == 500){
                                    $('span#response').html('Client not found.').css("color","#ff0000");
                                    $element.attr("id","inputError");
                                }else{
                                      $('span#response').html('');

                                }
                            });
                    
                });

                $pass_field1 =  $('input[name="accss_pass_field1"]');
                $rand_pass = '';
                $btn_access = $('input[name="btn_access"]');
                $btn_access.attr("disabled","disabled");

                $('a#lnkPasswordGenerator').on('click',function(e){

                    e.preventDefault();
                    $.ajax({

                        url : "<?php print base_url('acesmain/system/misc/accounts/generate-password') ?>",
                        dataType: "json",

                        beforeSend: function(){

                            $('a#lnkPasswordGenerator').html('Generating...');
                        },

                        complete: function(data){

                             $('.form-group span#generated_password').html('<span style="color:#006633;">Password generated ! | <a id="pssShow" href="#">Show</a></span>');

                           $pass_field1.val(data.responseText);
                           $rand_pass = data.responseText;

                            $('a#pssShow').click(function(){
                                $(this).remove();
                                 $pass_field1.attr('type',"text");
                            });
                        }

                    });
                });

                $('input[name="accss_pass_field2"]').keyup(function(){
                    $val = $(this).val();

                    if ( $val != $rand_pass){

                        $('.form-group span#pass2').html("Password do not match.").css('color','red');

                    }else{

                         $('.form-group span#pass2').html("Password matched.").css('color','green');
                         $btn_access.removeAttr("disabled");
                    }
                });

                $('form').submit(function(e){
                    e.preventDefault();

                    var formData = $(this).serialize();

                   //console.log(formData);
                    $('input').attr("disabled","disabled");

                               
                    //return false;
                   
                    $.ajax({

                        url : "<?php print base_url('acesmain/system/clients/acess/process') ?>",
                        method : 'GET',
                        data : formData,

                        beforeSend: function(){

                            $('div#feedback').html('Processing Request...').css("background","blue").css("color","#fff");
                         
                        },

                        success: function(data){

                             $('div#feedback').html('Request has been completed.').css("background","green").css("color","#fff");
                        
                        },

                        error : function(data){

                             $('div#feedback').html('Client has already have an access. Operation aborted.').css("background","red").css("color","#fff");
                             $('div#feedback').append('<a href="<?php print base_url("acesmain") ?>">Go back to main page.</a>');
                             $('.form-group').remove();
                             $('input').remove();
                        }

                    });


                });




               

            }); // document ready

            function handler(request) {
                //responseText is the raw JSON string, you need to convert it to a JS object
                //use var keyword to define new variables inside your function scope
                var obj = JSON.parse(request.responseText);
                //note that indicator is not a valid features property, you should change it!
                alert(obj.features[0].indicator); //return undefined, change it maybe to .type
            }
        </script>
       
    </body>

</html>