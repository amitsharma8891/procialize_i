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
					
					<div class="omb_login">
						<!--<h3 class="omb_authTitle">Login / Sign up</h3>-->
						<h3 class="text-center" style="color:#58595b">Reset Password</h3>
                        <h4 class="text-center" style="color:#58595b; margin-bottom:10px;" >Please follow one single step to reset password</h4>
                        
                        <div class="row omb_row-sm-offset-3 mb10">
                            <div class="col-xs-12 col-sm-6">	
                                <!--<form class="omb_loginForm" action="" autocomplete="off" method="POST">-->
                                     
									 
						<div class="form-group">
                            <input type="password" name="" id="" placeholder="New Password" value="" class="form-control">
                            <label for="mobile" class="error" id="phone_err" style="display:none;">This field is required.</label>
                        </div>
						<div class="form-group">
                            <input type="password" name="" id="" placeholder="Re-type New Password" value="" class="form-control">
                            <label for="mobile" class="error" id="phone_err" style="display:none;">This field is required.</label>
                        </div>
						<div class="form-group">
                            <input type="hidden" name="type_of_attendee" id="type_of_attendee" value="A">
                            <button class="btn btn-success btn-block center-block mb10" type="submit">Reset Password</button>
                        </div>
                                <!--</form>-->
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

<div id="new_msg" class="modal fade">
	<div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">New Message</h4>
      </div>
      
      <div class="modal-body">
      	<form class="form-horizontal" role="form">
         <div class="col-sm-8">
         		<div class="form-group">
            	<p>To, Naitik Vyas</p>
            	<input type="text" class="form-control"  placeholder="Add Attendee">
            <div class="addattendies" style="width:100%;">
            
            </div>
            </div>
           
            <div class="form-group">
           	<input type="button" class="btn btn-success input-sm btn-block" value="Add" id="addmoreat">
            </div>
            <div class="form-group">
            <textarea class="form-control" rows="3" placeholder="Write your message here"></textarea>
            </div>
            <div class="form-group">
             <button type="button" class="btn btn-success input-sm btn-block">Send</button>
            </div>
          </div>
          <div class="clearfix"></div>
        </div>
        
      </form>
    </div>
  </div>
  
</div>

<div id="compose" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
    <div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			<h4 class="modal-title" id="myModalLabel">Compose</h4>
		</div>
      
		<div class="modal-body">
      	<form class="form-horizontal" role="form">
			<div class="form-group">
				<input type="text" class="form-control"  placeholder="Add Attendee, Speaker, Exhibitor">
            </div>
			
            <div class="form-group">
				<input type="button" class="btn btn-success input-sm btn-block" value="Add" id="addmoreat">
            </div>
			<div class="form-group">
				<div class="checkbox-inline">
					<label> <input type="checkbox" checked> All Attendees, Speakers, Exhibitors</label>
				</div>
			</div>
            <div class="form-group">
				<textarea class="form-control" rows="3" placeholder="Write your message here"></textarea>
            </div>
            <div class="form-group">
				<button type="button" class="btn btn-success input-sm btn-block">Send</button>
            </div>
		</form>
        </div>
    </div>
	</div>
</div>
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
  </script>

