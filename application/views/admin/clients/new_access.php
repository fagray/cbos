        <!-- /content -->
       
            <div class="row">
              <?php $this->load->view('admin/layouts/sidebar') ?>
            <div class="col-md-9" id="content">
                <h3> New Client Access </h3>
                    <!-- block -->
                        <div class="panel panel-default ">
                            <div class="blue-bg panel-heading ">
                                Account Details
                            </div>
                            <div class="panel-body">
                                <div class="col-md-12">
                                   <div id="feedback"></div>
                                   <?php echo form_open('',array('name' => 'frmAccess','class' => 'form-group')) ?>
                                        <div class="form-group">
                                            <label for="">Client No.</label>
                                            <?php echo form_input('client_no','',array('required' => 'required','type' => 'text','class' => 'form-control error')); ?>
                                            <span id="response"></span>
                                        </div>

                                         <div class="form-group">
                                            <label for="">Username</label>
                                            <?php echo form_input('user_name','',array('required' => 'required','type' => 'text','class' => 'form-control')); ?>
                                        </div> 

                                        <div class="form-group">
                                            <label for="">Password</label>
                                            <?php echo form_password('accss_pass_field1','',array('disabled' => 'disabled','type' => 'text','class' => 'form-control')); ?>
                                            <span id="generated_password">
                                                 <a id="lnkPasswordGenerator" href="#">Generate Password</a>
                                            </span>
                                            
                                        </div>
                                        <div class="form-group">
                                            <label for="">Re-type the password above </label>
                                            <?php echo form_input('accss_pass_field2','',array('type' => 'text','class' => 'col-md-3 form-control')); ?>
                                            <span id="pass2">
                                                
                                            </span>
                                        </div>
                                        <br/><br/>
                                        <?php echo form_submit('btn_access', 'Grant Access',array('class' =>  'btn btn-primary')); ?>
                                    <?php echo form_close(); ?>
                                </div>
                            </div>
                        </div>
                        <!-- /block -->
                </div><!-- /content -->
            </div>    <!-- /row-fluid -->
              <hr>
        <?php $this->load->view('layouts/footer') ?>

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

                    // console.log(formData);
                    $('input').attr("disabled","disabled");

                               
                    //return false;
                   
                    $.ajax({

                        url : "<?php print base_url('acesmain/system/clients/access/process') ?>",
                        method : 'GET',
                        data : formData,

                        beforeSend: function(){

                            $('div#feedback').html('Processing Request...').css("background","blue").css("color","#fff");
                         
                        },

                        success: function(data){

                             $('div#feedback').html('Request has been completed. Access has been created.').css("background","green").css("color","#fff");
                             $('div#feedback').append('<br/><a href="<?php print base_url("acesmain") ?>">Go back to main page.</a>');
                             $('.form-group').remove();
                             $('input').remove();
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