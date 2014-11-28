<html>
    <head>
	<link rel='stylesheet' type='text/css' href='<?php echo CLIENT_PLUGINS?>scheduler/css/smoothness/jquery-ui-1.8.11.custom.css' />
    <link rel="stylesheet" type="text/css" href="<?php echo CLIENT_PLUGINS?>scheduler/css/jquery.weekcalendar.css" />
    <link rel='stylesheet' type='text/css' href='<?php echo CLIENT_PLUGINS?>scheduler/css/demo.css' />
    <link rel='stylesheet' type='text/css' href='<?php echo CLIENT_PLUGINS?>scheduler/css/reset.css' />
	<link rel="stylesheet" type="text/css" href="<?php echo CLIENT_PLUGINS?>scheduler/css/setmeeting.css" />
	<!--<link rel="stylesheet" type="text/css" href="<?php echo CLIENT_PLUGINS?>scheduler/css/custom_style.css" />-->

	<script type="text/javascript">
	var SITE_URL = '<?php echo SITE_URL?>';
	</script>
    <!---agenda -contents-->
    <!--<link rel='stylesheet' type='text/css' href='libs/css/smoothness/jquery-ui-1.8.11.custom.css' />-->
<!--    <link rel="stylesheet" type="text/css" href="<?php echo CLIENT_PLUGINS?>scheduler/css/jquery.weekcalendar.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo CLIENT_PLUGINS?>scheduler/css/custom_style.css" />-->
  
    <script type='text/javascript' src='<?php echo CLIENT_PLUGINS?>scheduler/jquery-1.4.4.min.js'></script>
    <!--<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>-->
    <script type='text/javascript' src='<?php echo CLIENT_PLUGINS?>scheduler/jquery-ui-1.8.11.custom.min.js'></script>
    <script type='text/javascript' src='<?php echo CLIENT_PLUGINS?>scheduler/jquery-ui-i18n.js'></script>
    <script type="text/javascript" src="<?php echo CLIENT_PLUGINS?>scheduler/date.js"></script>
    <script type="text/javascript" src="<?php echo CLIENT_PLUGINS?>scheduler/jquery.weekcalendar.js"></script>
   
    <script type="text/javascript">
  (function($) {
        var eventData1 = {
      
            options: {
          //gotoWeek:2014-05-16,
        timeslotsPerHour: 4,
        timeslotHeight: 15,
//readonly:true,
        //defaultFreeBusy: {free: true}
      },
      events : [
        <?php 
                $track                                                          = array();
                $event_date                                                     = date('Y-m-d');
                $track_list                                                     = array();
                $date_list                                                      = array();
                if($agenda_list)
                {
                    
                    foreach($agenda_list as $key=> $value)
                    {
                        
                        if($from_id ==  $value['object_id'])
                        {
                            $track_list                                         = 'track1';
                        }
                        elseif($from_id ==  @$value['subject_id'])
                        {
                            $track_list                                         = 'track1';
                        }
                        
                        if($to_id ==  $value['object_id'])
                        {
                            $track_list                                         = 'track2';
                        }
                        elseif($to_id ==  @$value['subject_id'])
                        {
                            $track_list                                         = 'track2';
                        }
                        $agenda_list[$key]['track_name']                                    = $track_list;
                        $date_list[]                                            = date('Y-m-d',strtotime($value['session_start_time']));
                        
                    }
                    $track_list                                                 = array('track1','track2');//array_values(array_unique($track_list)); 
                    $date_list                                                  = array_values(array_unique($date_list));
                    //display($date_list);
                    $track_id   = '';
                    foreach($agenda_list as $key1=> $value1)
                    {
                        foreach ($track_list as $k2 => $v2)
                        {
                            if($v2 === $value1['track_name'])
                            {
                                $track_id = $k2;
                            }
                        }
                        $session_name = $value1['session_name']; 
                        if($value1['data_type'] == 'meeting')
                            $session_name = 'Already have confirmed meeting'; 
                        
                        if($value1['track_id'] == 1 )
                        {
                            $session_name   = 'Slot not available';
                        }
                        else
                        {
                            
                        }
                        $track[]      = '"'.$value1['track_name'].'"';
                        echo "{'id':".$key1.", readOnly : true,'start': '".$value1['session_start_time']."', 'end': '".$value1['session_end_time']."', 'title': '".  addslashes($session_name)."', userId: ".$value1['track_id']."},";
                        
                    }
                    $event_date                                                     = $agenda_list[0]['session_start_time'];
                }
       ?>
        //{'id':2, 'start': new Date(year, month, day, 16), 'end': new Date(year, month, day, 17, 45), 'title': 'Dev Meeting', userId: 1},
      ],
    };
    
    $(document).ready(function() {
    var id = 10;
      var $calendar = $('#calendar').weekCalendar({ 
          
        //readonly:true,  
        timeslotsPerHour: 4,
        scrollToHourMillis : 0,
        
        height: function($calendar){
          return $(window).height() - $('h1').outerHeight(true);
        },
        eventRender : function(calEvent, $event) {
         if (calEvent.end.getTime() < new Date().getTime()) {
            //$event.css("backgroundColor", "#aaa");
            $event.find(".wc-time").css({
               //"backgroundColor" : "#999",
               //"border" : "1px solid #888"
            });
         }
      },
      draggable : function(calEvent, $event) {
         return calEvent.readOnly != true;
      },
      resizable : function(calEvent, $event) {
         return calEvent.readOnly != true;
      },
        eventNew : function(calEvent, $event) {
            //return;
            
         if(calEvent.userId == 0)
         {
            $('#calendar').weekCalendar("removeUnsavedEvents");
            return;
         }
            //if(!titleField)
                      //return false;
         
         var $dialogContent = $("#event_edit_container");
         resetForm($dialogContent);
         var startField = $dialogContent.find("select[name='start']").val(calEvent.start);
         var endField = $dialogContent.find("select[name='end']").val(calEvent.end);
         var titleField = $dialogContent.find("input[name='title']");
         var bodyField = $dialogContent.find("textarea[name='body']");
         
         
         $dialogContent.dialog({
            modal: true,
            title: "New Calendar Event",
            close: function() {
               $dialogContent.dialog("destroy");
               $dialogContent.hide();
               $('#calendar').weekCalendar("removeUnsavedEvents");
            },
            buttons: {
               Send : function() {
                  calEvent.id = id;
                  id++;
                  var start_date = calEvent.start = new Date(startField.val());
                  var end_date= calEvent.end = new Date(endField.val());
                  calEvent.title = titleField.val();
                  if(!calEvent.title)
                      return false;
                  $calendar.weekCalendar("removeUnsavedEvents");
                  $calendar.weekCalendar("updateEvent", calEvent);
                  $dialogContent.dialog("close");
                  
               //make ajax call to insert meeting#############################################################################################
                 start_date = start_date.toString().replace('GMT+0530 (India Standard Time)','');
                 end_date   = end_date.toString().replace('GMT+0530 (India Standard Time)','');
                 
                  set_meeting((start_date),(end_date),calEvent.title,$("#target_id").val(),$("#target_type").val());
               },
               Cancel : function() {
                  $dialogContent.dialog("close");
                  //return;
               }
            }
         }).show();

         $dialogContent.find(".date_holder").text($calendar.weekCalendar("formatDate", calEvent.start));
         setupStartAndEndTimeFields(startField, endField, calEvent, $calendar.weekCalendar("getTimeslotTimes", calEvent.start));

      },
      eventClick : function(calEvent, $event) {
         if (calEvent.readOnly ) {
            return;
         }
         
         if(calEvent.userId == 0)
             return;
         
         var $dialogContent = $("#event_edit_container");
         resetForm($dialogContent);
         var startField = $dialogContent.find("select[name='start']").val(calEvent.start);
         var endField = $dialogContent.find("select[name='end']").val(calEvent.end);
         var titleField = $dialogContent.find("input[name='title']").val(calEvent.title);
         var target_id = $dialogContent.find("input[name='target_id']").val('<?php echo $to_id?>');
         var bodyField = $dialogContent.find("textarea[name='body']");
         bodyField.val(calEvent.body);
         //alert(target_id);
         
                  
         $dialogContent.dialog({
            modal: true,
            title: "Edit - " + calEvent.title,
            close: function() {
               $dialogContent.dialog("destroy");
               $dialogContent.hide();
               $('#calendar').weekCalendar("removeUnsavedEvents");
            },
            buttons: {
               Send : function() {
                   //alert(startField.val());
                  calEvent.start = new Date(startField.val());
                  calEvent.end = new Date(endField.val());
                  calEvent.title = titleField.val();
                  calEvent.body = bodyField.val();

                  $calendar.weekCalendar("updateEvent", calEvent);
                  $dialogContent.dialog("close");
                
                  
               },
               /*"delete" : function() {
                  $calendar.weekCalendar("removeEvent", calEvent.id);
                  $dialogContent.dialog("close");
               },*/
               Cancel : function() {
                  $dialogContent.dialog("close");
               }
            }
         }).show();

         var startField = $dialogContent.find("select[name='start']").val(calEvent.start);
         var endField = $dialogContent.find("select[name='end']").val(calEvent.end);
         $dialogContent.find(".date_holder").text($calendar.weekCalendar("formatDate", calEvent.start));
         setupStartAndEndTimeFields(startField, endField, calEvent, $calendar.weekCalendar("getTimeslotTimes", calEvent.start));
         $(window).resize().resize(); //fixes a bug in modal overlay size ??

      },
        data: function(start, end, callback) {
          var dataSource = '1';//$('#data_source').val();
          if (dataSource === '1') {
            callback(eventData1);
          } else if(dataSource === '2') {
            //callback(eventData2);
          } else {
            callback({
              options: {
                  
                defaultFreeBusy: {
                  free:true
                }
              },
              events: []
            });
          }
        },
        
        users: ['My Calender',"<?php echo $to_name?>'s Calender"],//tracks
        showAsSeparateUser: true,
        displayOddEven: true,
        displayFreeBusys: true,
        daysToShow: 1,//show the how many days to be 
        //switchDisplay: {'1 day': 1, '3 next days': 3, 'work week': 5, 'full week': 7},
        headerSeparator: ' ',
        useShortDayNames: true,
        allowCalEventOverlap:false,
        use24Hour:true,
        
        
      });
      
      function resetForm($dialogContent) {
      $dialogContent.find("input").val("");
      $dialogContent.find("textarea").val("");
   }
   
    /*
    * Sets up the start and end time fields in the calendar event
    * form for editing based on the calendar event being edited
    */
   function setupStartAndEndTimeFields($startTimeField, $endTimeField, calEvent, timeslotTimes) {

      $startTimeField.empty();
      $endTimeField.empty();

      for (var i = 0; i < timeslotTimes.length; i++) {
         var startTime = timeslotTimes[i].start;
         var endTime = timeslotTimes[i].end;
         var startSelected = "";
         if (startTime.getTime() === calEvent.start.getTime()) {
            startSelected = "selected=\"selected\"";
         }
         var endSelected = "";
         if (endTime.getTime() === calEvent.end.getTime()) {
            endSelected = "selected=\"selected\"";
         }
         $startTimeField.append("<option value=\"" + startTime + "\" " + startSelected + ">" + timeslotTimes[i].startFormatted + "</option>");
         $endTimeField.append("<option value=\"" + endTime + "\" " + endSelected + ">" + timeslotTimes[i].endFormatted + "</option>");

         $timestampsOfOptions.start[timeslotTimes[i].startFormatted] = startTime.getTime();
         $timestampsOfOptions.end[timeslotTimes[i].endFormatted] = endTime.getTime();

      }
      $endTimeOptions = $endTimeField.find("option");
      $startTimeField.trigger("change");
   }

   var $endTimeField = $("select[name='end']");
   var $endTimeOptions = $endTimeField.find("option");
   var $timestampsOfOptions = {start:[],end:[]};

   //reduces the end time options to be only after the start time options.
   $("select[name='start']").change(function() {
      var startTime = $timestampsOfOptions.start[$(this).find(":selected").text()];
      var currentEndTime = $endTimeField.find("option:selected").val();
      $endTimeField.html(
            $endTimeOptions.filter(function() {
               return startTime < $timestampsOfOptions.end[$(this).text()];
            })
            );

      var endTimeSelected = false;
      $endTimeField.find("option").each(function() {
         if ($(this).val() === currentEndTime) {
            $(this).attr("selected", "selected");
            endTimeSelected = true;
            return false;
         }
      });

      if (!endTimeSelected) {
         //automatically select an end date 2 slots away.
         $endTimeField.find("option:eq(1)").attr("selected", "selected");
      }

   });
      
      $('h1.wc-title').remove();
      $('#date_change_data').change(function() {
        //$calendar.weekCalendar('refresh');
        var new_date_value = $('#date_change_data').val()
        //alert(new_date_value);
        $calendar.weekCalendar('gotoWeek',new_date_value);
     });
      $('#data_source').change(function() {
        $calendar.weekCalendar('refresh');
     });
      $('#get_data').click(function() {
        $calendar.weekCalendar('gotoWeek','<?php echo $event_date?>');
      });
      
      setTimeout(function() 
      {
        $calendar.weekCalendar('gotoWeek','<?php echo date('Y-m-d',  @strtotime($event_date_list->event_start))?>');
      }, 100);
    });
  })(jQuery);
  
 function set_meeting(start,end,content,target_id,target_type)
{
//    /alert('test'+start+end+'target'+$("#target_id").val());
    

    $.ajax({
                        type                                                            : 'POST',
                        url                                                             : SITE_URL+"client/event/set_meeting",
                        dataType                                                        : 'json',
                        data                                                            : {start:start,end:end,'title':content,'target_id':target_id,'target_type':target_type},
                        success: function(msg)
                        {
                            var data                                                    = eval(msg);
                            if(data.error == 'success')
                            {
                                alert(data.msg);
                                location.reload();
                            }
                            else
                            {
                                alert(data.msg);
                                location.reload();
                            }

                        }
                    });
}
  </script>
  <?php include_once 'setting.php';?>
    </head>
    <body>
	<style type="text/css">
            .ui-dialog {top: 10% !important;width: 275px !important;}
            .dateSelectrDropd{z-index: 999999 !important;}
            .dateSelectrDropd select {position: relative;z-index: 999999}
        </style> 
	
 	<input type="hidden" name="target_id" id="target_id" value="<?php echo $to_id?>">
  		<div class="dateSelectrDropd" >
            
                <label>Select Date:</label>
                 
                <select id="date_change_data">
                    <?php 
                    if($event_date_list)
                    {
                        $date_list  = createDateRangeArray(date('Y-m-d',  strtotime($event_date_list->event_start)),date('Y-m-d',  strtotime($event_date_list->event_end)));
                        foreach ($date_list as $key => $value)
                        {
                            echo '<option value="'.date('Y-m-d',strtotime($value)).'">'.date('Y-m-d',strtotime($value)).'</option>';
                        } 
                    }
                    
                        
                        
                     ?>
                    
                </select>
                <div class="clear"></div>
            </div>
	<div id="calendar"></div>
	<div id="event_edit_container">
            
		<form>
            <input type="hidden" name="target_id">
			<input type="hidden" />
			<ul>
				<li>
					<span>Date: </span><span class="date_holder"></span> 
				</li>
				<li>
					<label for="start">Start Time: </label><select name="start"><option value="">Select Start Time</option></select>
				</li>
				<li>
					<label for="end">End Time: </label><select name="end"><option value="">Select End Time</option></select>
				</li>
				<li>
					<label for="title">Message*: </label><input type="text" name="title" />
				</li>
				<li>
					<!--<label for="body">Body: </label><textarea name="body"></textarea>-->
                                        
                                        
                                        
				</li>
			</ul>
		</form>
	</div>
  
  
  <!--<div id="get_data"><a href="javascript:;">Get Data</a></div>-->
    </body>
</html>
