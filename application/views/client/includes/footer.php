
<script src="<?php echo CLIENT_SCRIPTS?>jquery-ui.min.js"></script>
<script src="<?php echo CLIENT_SCRIPTS?>bootstrap.min.js"></script>
<script src="<?php echo CLIENT_SCRIPTS?>modernizr.min.js"></script>
<script src="<?php echo CLIENT_SCRIPTS?>easing.js"></script>
<script src="<?php echo CLIENT_SCRIPTS?>jquery.cookies.js"></script>
<script src="<?php echo CLIENT_SCRIPTS?>chosen.jquery.min.js"></script>

<script src="<?php echo CLIENT_SCRIPTS?>custom.js"></script>
<?php
    //$page_array = array('login-view','event-detail');
    $page_array = array('login-view');
    if(!in_array($this->uri->segment(2), $page_array))
    {
 ?>
<script src="<?php echo CLIENT_SCRIPTS?>modules/frontend_module.js"></script>

<?php }?>

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



<!---Ajax success message box--->
<div id="ajax_success_message"  class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">New Message</h4>
            </div>
            <div class="modal-body" id="ajax_success_message_body"></div>
    </div>
  </div>
  
</div>


<!---Ajax Success Message Box--->
<?php 

    $page_array = array(
                        'event-detail',
                        'attendee-detail',
                        'exhibitor-detail',
                        'speaker-detail',
                        );
    $url_page       = $this->uri->segment(2);
    if($this->session->userdata('client_attendee_id') && $this->session->userdata('client_event_id') && in_array($url_page, $page_array))
    {
        if($analytic_type && $target_user_id && $target_user_type)
        push_analytics($analytic_type,$target_user_id,$target_user_type);
    }
?>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-53828045-1', 'auto');
  ga('send', 'pageview');

</script>
</body>
</html>

