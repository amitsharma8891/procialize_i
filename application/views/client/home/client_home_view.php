    <!---client header view--->
    <?php $this->load->view(CLIENT_HEADER)?>
    
    <!---client header view--->
    
    
    <script type="text/javascript">
          $(document).ready(function(){
              //$("#dia").dialog();
                              //var SITE_URL                                      = 'http://192.168.2.107/project-procialize/solution/';
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
                                        select: function(event,ui ) {
                                            //alert(ui.item.label);
                                                window.location.href            = SITE_URL+'events?term='+ui.item.value;
                                            }
                               }).keydown(function(e)
                                   {
                                       if (e.keyCode === 13)
                                       {
                                           search_();
                                       }
                                   });
          })
          
        function search1_()
        {
            //alert('test');
           //if($("#search_").val() != '')
            window.location.href                            = SITE_URL+"events?type=&term="+encodeURIComponent($("#search_").val());
        }
      </script> 
    <div class="contentpanel">
    <div class="panel panel-default panel-stat">
		<div class="panel-heading panel-heading-alt">
		
		  <div class="row">
			
			<div class="col-xs-12">
			<h3 class="text-center" style="color:#58595b">Search An Event</h3>
				<div class="stat">
                                        <div class="form-group mb20">
                                            <input type="text" id="search_" class="form-control" placeholder="Search Event Name, Industry, Functionality, Location" style="-webkit-box-sizing: border-box;
-moz-box-sizing: border-box;
box-sizing: border-box;
padding: 8px 20px 8px 10px;
width: 100%;
height: auto;
outline: 0;
background: #fff url(http://procialize.in/beta/public/client/images/icon-search.png) no-repeat 99% center;
font-size: 13px;
line-height: normal;">
					</div>
                                    <div class="form-group">
						<button class="btn btn-success btn-block" type="button" onclick="search1_()">Search</button>
					</div>
					<form role="form" id="search_form" action="<?php echo SITE_URL?>events" method="get">
					
					<hr>
					<h4 style="color:#58595b; margin-bottom:10px;">Advance Search </h4>
					<div class="form-group mt15">
<!--						<div class="col-xs-6">
							<div class="input-group">
								<input type="text" class="form-control" placeholder="mm/dd/yyyy" name="from" id="from">
								<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
							</div>
						</div>-->
<!--						<div class="col-xs-6">
							<div class="input-group">
								<input type="text" class="form-control" placeholder="mm/dd/yyyy" name="to" id="to">
								<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
							</div>
						</div>-->
					</div>
					
					<div class="form-group mt15">
					<select name="industry" id="industry" class="form-control chosen-select" data-placeholder="Add Industry">
					  <option value="">Add Industry</option>
                                          <?php 
                                            if($industry_list)
                                            {
                                                foreach($industry_list as $industry)
                                                {
                                                    echo '<option value="'.$industry['name'].'">'.$industry['name'].'</option>';
                                                }
                                            }
                                        ?>
					</select>
					</div>
					<div class="form-group">
					<select name="functionality" id="functionality" class="form-control chosen-select" data-placeholder="Add Functionality">
					  <option value="">Add Functionality</option>
					  <?php 
                                            if($functionality_list)
                                            {
                                                foreach($functionality_list as $function)
                                                {
                                                    echo '<option value="'.$function['name'].'">'.$function['name'].'</option>';
                                                }
                                            }
                                        ?>
					</select>
					</div>
					<div class="form-group">
					<input type="text" name="location" id="location" placeholder="Add Location" class="form-control" />
					</div>
					<div class="form-group">
                                            <button class="btn btn-success btn-block center-block mb10" type="submit" value="Search" name="search">Search</button>
                                                
					</div>
					</form>
					
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

<script type="text/javascript">
    $(document).ready(function(){
              //$("#dia").dialog();
              // Chosen Select
        jQuery(".chosen-select").chosen({'width':'100%','white-space':'nowrap'});
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
            //var SITE_URL                                                        = 'http://192.168.2.107/project-procialize/solution/';
            if($("#search_").val() != '')
            window.location.href                            = SITE_URL+"events?type=&term="+encodeURIComponent($("#search_").val());
        }
        
        
     $(function() 
     {
        $( "#from" ).datepicker(
        {
          defaultDate: "+1w",
          changeMonth: true,
          numberOfMonths: 1,
          dateFormat    : 'dd-mm-yy',
          onClose: function( selectedDate ) {
            $( "#to" ).datepicker( "option", "minDate", selectedDate );
          }
        });
        
        $( "#to" ).datepicker(
        {
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
<?php $this->load->view(CLIENT_FOOTER)?>
