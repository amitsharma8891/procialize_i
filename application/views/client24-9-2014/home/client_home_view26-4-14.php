<html>
    <head>
        
        <title>Procialize</title>
        <link href="<?php echo CLIENT_CSS?>jquery-ui.css" rel="stylesheet">
  <script src="<?php echo CLIENT_SCRIPTS?>jquery-1.10.2.min.js"></script>
  <script src="<?php echo CLIENT_SCRIPTS?>jquery-migrate-1.2.1.min.js"></script>
  <script src="<?php echo CLIENT_SCRIPTS?>jquery-ui.min.js"></script>
    </head>
    <body>
        <form id="search_form" action="<?php echo SITE_URL?>events" method="get">
        <label></label>
        <input type="text" name="search_event" id="search_" placeholder="Event,City,Organizer"><br><br>
        
        <label>Date</label><br>
        <input type="text" name="from" id="from"> <br><br>
        <input type="text" name="to" id="to"> <br><br>
        
        <label>Location</label><br>
        <input type="text" name="location" id="location"><br><br>
        <label>Industry</label><br>
        <select name="industry" id="industry">
            <option value="">Select Industry</option>
            <?php 
                if($industry_list)
                {
                    foreach($industry_list as $industry)
                    {
                        echo '<option value="'.$industry['name'].'">'.$industry['name'].'</option>';
                    }
                }
            ?>
        </select><br><br>
        <label>Functionality</label><br>
        <select name="functionality" id="functionality">
            <option value="">Select Functionality</option>
            <?php 
                if($functionality_list)
                {
                    foreach($functionality_list as $function)
                    {
                        echo '<option value="'.$function['name'].'">'.$function['name'].'</option>';
                    }
                }
            ?>
        </select><br><br>
        <input type="submit" value="Search" name="search">
        </form>
        
    </body>
</html>
<script type="text/javascript">
          $(document).ready(function(){
              //$("#dia").dialog();
                              var SITE_URL                                      = '<?php echo SITE_URL?>';
                              var source                                        = SITE_URL+'client/event/search?type='
                              var type                                          = '';
                              if(type != '')
                              {
                                  source                                        = 'client/event/autocomplete?type=';
                              }
                              $( "#search_" ).autocomplete(
                                {
            
                                        source                                  :source,
                                        minLength                               :3,
                                        width                                   : 320,
                                        max                                     : 10,
                                        /*select: function(event,ui ) {
                                            //alert(ui.item.label);
                                                window.location.href            = SITE_URL+'events?search='+ui.item.value;
                                            }*/
                               });/*.keydown(function(e)
                                   {
                                       if (e.keyCode === 13)
                                       {
                                           search_();
                                       }
                                   });*/
                                   
                        $("#search_form").submit(function(){
                            var keyword                                         = $("#search_").val();
                            var from                                            = $("#from").val();
                            var to                                              = $("#to").val();
                            var industry                                        = $("#industry").val();
                            var functionality                                   = $("#functionality").val();
                            
                        })           
                   
          });
          
        function search_()
        {
            var SITE_URL                                                        = 'http://192.168.2.107/project-procialize/solution/';
            alert('test');
            if($("#search_").val() != '')
            window.location.href                            = SITE_URL+"events?type=&term="+encodeURIComponent($("#search_").val());
        }
        
        $(function() {
    $( "#from" ).datepicker({
      defaultDate: "+1w",
      changeMonth: true,
      numberOfMonths: 1,
      dateFormat    : 'dd-mm-yy',
      onClose: function( selectedDate ) {
        $( "#to" ).datepicker( "option", "minDate", selectedDate );
      }
    });
    $( "#to" ).datepicker({
      defaultDate: "+1w",
      changeMonth: true,
      numberOfMonths: 1,
      dateFormat    : 'dd-mm-yy',
      onClose: function( selectedDate ) {
        $( "#from" ).datepicker( "option", "maxDate", selectedDate );
      }
    });
  });
      </script> 
