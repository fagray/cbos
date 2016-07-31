        <!-- /content -->
       
            <div class="row">
              <?php $this->load->view('admin/layouts/sidebar') ?>
            <div class="col-md-9" id="content">
                <div role="tabpanel">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active">
                            <a href="#new-access" aria-controls="new-access" role="tab" data-toggle="tab">New Client Access</a>
                        </li>
                        <li role="presentation">
                            <a href="#access" aria-controls="access" role="tab" data-toggle="tab">List of Access</a>
                        </li>
                    </ul>
                
                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="new-access">
                             <h3> New Client Access </h3>
                    <!-- block -->
                        <div class="panel panel-default ">
                            <div class="blue-bg panel-heading ">
                                Account Details
                            </div>
                            <div class="panel-body">
                                <div class="col-md-12">
                                   <div style="display:none;" class="alert alert-info" id="feedback"></div>
                                   <?php echo form_open('',array('name' => 'frmAccess','class' => 'form-group')) ?>
                                        <div class="form-group">
                                            <label for="">Client No.</label>
                                            <select name="global_id" id="input" class="form-control" required="required">
                                                <option value=""></option>
                                                <?php foreach($clients as $client){?>
                                                    <option value="<?php print $client->GLOBAL_ID ?>">
                                                    <?php 
                                                        print $client->GLOBAL_ID .' - '. $client->GLOBAL_ID;
                                                    ?>
                                                    </option>
                                                <?php } ?>
                                                    
                                               
                                            </select>
                                            <span id="response"></span>
                                            <div style="display: none;"   class="chkbox_account checkbox  ">
                                                <div class="account_container">
                                                   
                                                </div>
                                            </div>
                                            
                                        </div>

                                        <div class="form-group">
                                            <label for="">Client Email</label>
                                            <?php echo form_input('client_email','',array('required' => 'required','type' => 'email','class' => 'form-control')); ?>
                                        </div> 

                                         <div class="form-group">
                                            <label for="">Username</label>
                                            <?php echo form_input('user_name','',array('required' => 'required','type' => 'text','class' => 'form-control')); ?>
                                        </div>


                                        <div class="form-group">
                                            <label for="">Password</label>
                                            <input id="inpt_accss_pass_field1" type="password" name="accss_pass_field1"  class="form-control" value="" required="required" title="">
                                            <span id="generated_password">
                                                 <a id="lnkPasswordGenerator" href="#">Generate Password</a>
                                            </span>
                                            
                                        </div>
                                     
                                        <br/><br/>
                                        <?php echo form_submit('btn_access ', 'Grant Access',array('class' =>  ' blue-bg btn btn-primary','id' => 'btn_submit')); ?>
                                    <?php echo form_close(); ?>
                                </div>
                            </div>
                        </div>
                        <!-- /block -->

                        </div><!-- /new-client-access -->

                        <div role="tabpanel" class="tab-pane" id="access">
                             <h3> List of Access</h3>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Client No</th>
                                        <th>Username</th>
                                        <th>Date Granted</th>
                                        <th>Last Login</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($clients_access as $client){?>
                                        <tr>
                                            <td><?php print $client->GLOBAL_ID ?></td>
                                            <td><?php print $client->USR_NAME ?></td>
                                            <td><?php print $client->DATE_ADDED ?></td>
                                            <td><?php print $client->LAST_LOGIN ?></td>
                                            <td>
                                                <a data-id="<?php print $client->USR_ID ?>" class="lnk-remove-access" href="#">Remove access</a>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>

                        </div><!-- /client-access -->
                    </div>
                </div><!-- /tabpanel -->
               
                </div><!-- /content -->
            </div>    <!-- /row-fluid -->
              <hr>
        <?php $this->load->view('layouts/footer') ?>

        <!-- /External files -->

       
        <script type="text/javascript">

            $(document).ready(function(){

                
                // list all accounts after client selection
                $('select[name="global_id"]').change(function(){

                    $global_id  = $(this).val();

                    $.ajax({

                        url : "<?php print base_url('acesmain/clients/accounts/list') ?>",
                        dataType: 'json',
                        method : 'GET',
                        data : { global_id : $global_id},

                        beforeSend: function(){

                            $('select').append('Retrieving accounts...');
                        },

                        success: function(data){

                            display_accounts(data);
                            
                          
                        },

                        error : function (data) {
                            
                            console.log(data);
                            console.log('error');
                        }

                    });

                });

                function display_accounts (data) {

                    $('div.account_container').html('');
                    $('div.chkbox_account').css('display','block');

                    $.each(data,function(key,val){

                        $('div.account_container')
                            .append('<div>'+
                                        '<label>'+
                                            '<input name="accounts[]" type="checkbox" value="'+ val.ACCT_NO+'">'+
                                            '<p>'+ val.ACCT_DESC +'</p>'+
                                        '</label>'+
                                    +'</div>');    
                    });
                }

                $pass_field1 =  $('input[name="accss_pass_field1"]');
                $rand_pass = '';
                $btn_access = $('input[id="btn_submit"]');
             
                $term = '';
              

                $('a.lnk-remove-access').click(function(e){

                    e.preventDefault();
                   $id =  $(this).attr('data-id');
                   if ( confirm('Are you sure you want to remove access from this user ? ')){

                        $.getJSON('<?php print base_url("acesmain/clients/access/remove") ?>', { id: $id },function(data){
                            alert('Access has been removed successfully.');
                            location.reload(true);
                        });
                   }
                })


              $('input[name="client_no"]').keyup(function(){

                    $element = $(this);
                    $term = $(this).val();

                        if($term > 7){

                            $.getJSON('<?php print base_url("acesmain/clients/find") ?>', { q: $term }, 
                            
                            function(data){

                              console.log(data);

                                if ( data[0].response == 500){

                                    $('span#response').html('Client not found.').css("color","#ff0000");
                                    $element.attr("id","inputError");
                                    $btn_access.attr("disabled","disabled");

                                }else{

                                    $('input[name="user_name"]').removeAttr("disabled");
                                    $('input[name="accss_pass_field2"]').removeAttr("disabled");                                    
                                    $('span#response').html('');

                                }
                            });

                            return false;
                        }

                        $('span#response').html('Minimum input is 8 characters.');

                    
                });

               

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
                                 $('form').find("#inpt_accss_pass_field1").focus();
                            });
                        }

                    });
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
                            console.log(data);

                             $('div#feedback').html('Request has been completed. Access has been created.')
                                    .css("background","green")
                                    .css("color","#fff")
                                    .css("display","block");
                             $('div#feedback').append('<br/><a href="<?php print base_url("acesmain") ?>">Go back to main page.</a>');
                             $('.form-group').remove();
                             $('input').remove();
                        },

                        error : function(data){
                            console.log(data);
                             $('div#feedback').html('The requested client had already have an access.Operation aborted.')
                                .css("background","red")
                                .css("color","#fff")
                                .addClass('alert alert-danger')
                                .css("display","block");

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