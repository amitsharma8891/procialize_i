  <!---client header view--->
    <?php $this->load->view(CLIENT_HEADER)?>
    
    <!---client header view--->
    <?php if($this->session->userdata('client_user_id') && $this->session->userdata('client_event_id')) {?>
    <!----event top navigation---->
    <?php //$this->load->view(EVENT_TOP_NAVIGATION)?>
    <!----event top navigation---->
     
    </div>
    <?php }?>
    
    
    <div class="contentpanel">
    <div class="panel panel-default panel-stat">
		<div class="panel-heading panel-heading-alt">
		
		  <div class="row">
			
			<div class="col-xs-12">
				<div class="stat">
					
                                    <div class="omb_login" id="reset_password_success">
						<!--<h3 class="omb_authTitle">Login / Sign up</h3>-->
						<h3 class="text-center" style="color:#58595b">Reset Password</h3>
                                            <h4 class="text-center" style="color:#58595b; margin-bottom:10px;" >Please follow one single step to reset password</h4>

                                            <div class="row omb_row-sm-offset-3 mb10">
                                                <div class="col-xs-12 col-sm-6">	
                                                    <form class="omb_loginForm" onsubmit="return false" id="reset_password_form">
                                                        <div class="form-group">
                                                            <input type="password" name="password" id="password" placeholder="New Password" value="" class="form-control">
                                                            <label for="mobile" class="error" id="password_err" style="display:none;">This field is required.</label>
                                                        </div>
                                                        <div class="form-group">
                                                            <input type="password" name="conf_password" id="conf_password" placeholder="Re-type New Password" value="" class="form-control">
                                                            <label for="mobile" class="error" id="conf_password_err" style="display:none;">This field is required.</label>
                                                        </div>
                                                        <div class="form-group">
                                                            <input type="hidden" name="password_key" value="<?php echo $password_key;?>">
                                                            <button class="btn btn-success btn-block center-block mb10" type="submit">Reset Password</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
					</div>
                                    
					
				</div><!-- stat -->
			</div><!-- col-sm-6 -->
			
		  </div><!-- row -->
      </div>
	</div>
    </div><!-- contentpanel -->
    
  </div><!-- mainpanel -->
  
  <div class="rightpanel">
      <!--Right panel view--->
      <?php  $this->load->view(CLIENT_RIGHT_PANEL)?>
      <!--Right panel view--->
  </div><!-- rightpanel -->




</section>
<?php $this->load->view(CLIENT_FOOTER)?>
 <script>
$(function(){
    $('#addmoreat').click(function(){
    $('.addattendies').append('<div class="form-group" style="position:relative; width:100%; margin:0px;"> <input type="text" class="form-control"  placeholder="Add Attendee"><span class="closeAttende">�</span> </div>');
    })

    $(document).on('click', '.closeAttende',function(){
            $(this).parent('.form-group').remove();
    })

})
                        
$(document).ready(function ()
{
    $("#reset_password_form").submit(function ()
    {
        var form_data                                                           = $("#reset_password_form").serialize();
       $.ajax({
                type                                                            : "POST",
                url                                                             : SITE_URL+"client/user/change_password",
                dataType                                                        : "json",
                data                                                            : form_data,
                success : function(msg)
                {
                    var val                                                     = eval(msg);
                    if(val.error == 'error')
                    {
                        $.each(val, function(index, value)
                        {
                            $("#"+index).show();
                            $("#"+index).html(value);
                        });
                    }

                    if(val.error == 'success' )
                    {
                        $("#reset_password_success").html('');
                        $("#reset_password_success").html('<h3>Your Password has been changed successfully.<h3><h4><a href="'+SITE_URL+'user/login-view">Click here to Login</h4>'); 
                    }

                }
            });
    });
});                        
  </script>

