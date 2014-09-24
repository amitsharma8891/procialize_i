<html>
    <head>
<script type="text/javascript">
var SITE_URL = '<?php echo SITE_URL?>';
</script>
    <!---agenda -contents-->
    <!--<link rel='stylesheet' type='text/css' href='<?php echo CLIENT_PLUGINS?>scheduler/css/smoothness/jquery-ui-1.8.11.custom.css' />-->
    <link rel="stylesheet" type="text/css" href="<?php echo CLIENT_PLUGINS?>scheduler/css/jquery.weekcalendar.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo CLIENT_PLUGINS?>scheduler/css/custom_style.css" />
  
    <script type='text/javascript' src='<?php echo CLIENT_PLUGINS?>scheduler/jquery-1.4.4.min.js'></script>
    <!--<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>-->
    <script type='text/javascript' src='<?php echo CLIENT_PLUGINS?>scheduler/jquery-ui-1.8.11.custom.min.js'></script>
    <script type='text/javascript' src='<?php echo CLIENT_PLUGINS?>scheduler/jquery-ui-i18n.js'></script>
    <script type="text/javascript" src="<?php echo CLIENT_PLUGINS?>scheduler/date.js"></script>
    <script type="text/javascript" src="<?php echo CLIENT_PLUGINS?>scheduler/jquery.weekcalendar.js"></script>
    <script type="text/javascript" src="<?php echo CLIENT_PLUGINS?>scheduler/jquery.slimscroll.min.js"></script>
	
	
   
    <script type="text/javascript"> 
			/*$(function(){
				/*alert(1231);
			$('.wc-scrollable-grid').slimScroll({
					height:'scrollContainerHeight - 50px'
			});
			});*/
		</script>
    
		<script type="text/javascript">
  (function($) {
        var eventData1 = {
      
            options: {
          //gotoWeek:2014-05-16,
        timeslotsPerHour: 4,
        timeslotHeight: 20,
        defaultFreeBusy: {free: true}
      },
      events : [
        <?php 
                $track                                                          = array();
                $event_date                                                     = date('Y-m-d');
                $track_list                                                     = array();
                $date_list                                                      = array();    
                
                if($agenda_list)
                {
                    //for tracks
                    
                    foreach($agenda_list as $k => $v)
                    {
                        $track_list[]                                           = '"'.$v['track_name'].'"';
                        $date_list[]                                            = date('Y-m-d',strtotime($v['session_start_time']));
                    }
                    $track_list                                                 = array_values(array_unique($track_list));
                    $date_list                                                  = array_values(array_unique($date_list));
                    //display($date_list);exit;
                    foreach($agenda_list as $key=> $value)
                    {
                        foreach ($track_list as $k2 => $v2)
                        {
                            if($v2 === '"'.$value['track_name'].'"')
                            {
                                $track_id = $k2;
                            }
                        }
                        $track[]      = '"'.$value['track_name'].'"';
                        
                        echo "{'id':".$value['session_id'].", 'start': '".$value['session_start_time']."', 'end': '".$value['session_end_time']."', 'title': '".$value['session_name']."', userId: ".$track_id."},";
                        
                    }
                $event_date = date('Y-m-d',strtotime($agenda_list[0]['session_start_time']));
                }
       ?>
        //{'id':2, 'start': new Date(year, month, day, 16), 'end': new Date(year, month, day, 17, 45), 'title': 'Dev Meeting', userId: 1},
      ],
    };
    $(document).ready(function() {
    
      var $calendar = $('#calendar').weekCalendar({ 

        readonly:true,  
        timeslotsPerHour: 4,
        scrollToHourMillis : 0,
        businessHours :{start:7, end: 24, limitDisplay: true },
        height: function($calendar){
          return $(window).height() - $('h1').outerHeight(true);
        },
        eventRender : function(calEvent, $event) {
         
        },
        eventClick: function(calEvent, $event) {
        window.top.location.href   = SITE_URL+'client/event/session_detail/'+calEvent.id;
        return false;
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
        
        users: [<?php echo implode(',',$track_list); ?>],//tracks
        showAsSeparateUser: true,
        displayOddEven: true,
        displayFreeBusys: true,
        daysToShow: 1,//show the how many days to be 
        //switchDisplay: {'1 day': 1, '3 next days': 3, 'work week': 5, 'full week': 7},
        headerSeparator: ' ',
        useShortDayNames: true,
        use24Hour:true,
        
      });
      $('h1.wc-title').remove();
      $('#date_change_data').change(function() {
        //$calendar.weekCalendar('refresh');
        var new_date_value = $('#date_change_data').val()
        //alert(new_date_value);
        $calendar.weekCalendar('gotoWeek',new_date_value);
     });
      $('#get_data').click(function() {
        //$calendar.weekCalendar('gotoWeek',new_date_value);
      });
      
      setTimeout(function() 
      {
          //alert('<?php //echo $event_date?>');
        $calendar.weekCalendar('gotoWeek','<?php echo $event_date?>');
      }, 100);
    });
  })(jQuery);
	
 
  </script>
  <?php 
    if(count($track_list) <= 2 )
    {
  ?>
  
  <style>
     .wc-scrollable-grid{width:100% !important}
     .wc-header table{width:100% !important}
  </style>
  <?php 
    }
  ?>
  <?php include_once 'setting.php';?>
    </head>  
    <body>
        <?php if($agenda_list) {?>
        <div id="calendar">
            <div class="dateSelectrDropd" >
                <label>Select Date:</label>
                <select id="date_change_data">
                    <?php 
                        if($date_list)
                        {
                            foreach($date_list as $ke => $val)
                            {
                                echo '<option value="'.$val.'">'.$val.'</option>';
                            }
                        }
                        
                     ?>
                    
                </select>
                <div class="clear"></div>
            </div>
            <div class="clear"></div>
        </div> 
        <?php }else {?>
        <div><h4>No Session Found for this event</h4></div>
        <?php }?>
    </body>
</html>
  <!--<div id="get_data"><a href="javascript:;">Get Data</a></div>-->
