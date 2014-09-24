<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN""http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
    <head>
        <script type="text/javascript">
    var SITE_URL = '<?php echo SITE_URL?>';
    </script>
        <!---agenda -contents-->
        <link rel='stylesheet' type='text/css' href='<?php echo CLIENT_PLUGINS?>scheduler/css/smoothness/jquery-ui-1.8.11.custom.css' />
        <link rel="stylesheet" type="text/css" href="<?php echo CLIENT_PLUGINS?>scheduler/css/jquery.weekcalendar.css" />
        <link rel='stylesheet' type='text/css' href='<?php echo CLIENT_PLUGINS?>scheduler/css/demo.css' />
        <link rel='stylesheet' type='text/css' href='<?php echo CLIENT_PLUGINS?>scheduler/css/reset.css' />
        <link rel="stylesheet" type="text/css" href="<?php echo CLIENT_PLUGINS?>scheduler/css/custom_style_target.css" />


        <script type='text/javascript' src='<?php echo CLIENT_PLUGINS?>scheduler/jquery-1.4.4.min.js'></script>
        <!--<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>-->
        <script type='text/javascript' src='<?php echo CLIENT_PLUGINS?>scheduler/jquery-ui-1.8.11.custom.min.js'></script>
        <!--<script type='text/javascript' src='<?php echo CLIENT_PLUGINS?>scheduler/jquery-ui-i18n.js'></script>-->
        <script type="text/javascript" src="<?php echo CLIENT_PLUGINS?>scheduler/date.js"></script>
    <script type="text/javascript" src="<?php echo CLIENT_PLUGINS?>scheduler/jquery.weekcalendar.js"></script>
    <!--<script type="text/javascript" src="<?php echo CLIENT_PLUGINS?>scheduler/meeting.js"></script>-->
    <?php $this->load->view('client/agenda/client_meeting_js')?>
   
    <script type="text/javascript">
   </script>
    </head>
    <body>
        <div id="calendar"></div>
        <div id="event_edit_container">
		<form>
			<input type="hidden" />
			<ul>
				<li>
					<span>Date: </span><span class="date_holder"></span> 
				</li>
				<li>
					<label for="start">Start Time: </label>
                                        <select name="start">
                                            <option value="">Select Start Time</option>
                                        </select>
				</li>
				<li>
					<label for="end">End Time: </label>
                                        <select name="end">
                                            <option value="">Select End Time</option>
                                        </select>
				</li>
				<li>
					<label for="title">Title: </label>
                                        <input type="text" name="title" />
				</li>
				<li>
					<label for="body">Body: </label>
                                        <textarea name="body"></textarea>
                                        <input type="hidden" name="target_id" id="target_id" value="<?php $to_id?>">
				</li>
			</ul>
		</form>
	</div>
    </body>
</html>

 
  
  
  
  <!--<div id="get_data"><a href="javascript:;">Get Data</a></div>-->
