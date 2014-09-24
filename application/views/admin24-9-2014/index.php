<?php $thisPage="index"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="shortcut icon" href="images/favicon.png" type="image/png">

  <title>Super Admin - Procialize</title>

  <link href="css/style.default.css" rel="stylesheet">
  <link href="css/jquery.datatables.css" rel="stylesheet">

  <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!--[if lt IE 9]>
  <script src="js/html5shiv.js"></script>
  <script src="js/respond.min.js"></script>
  <![endif]-->
  
</head>

<body>
 
<!-- Preloader -->
<div id="preloader">
    <div id="status"><i class="fa fa-spinner fa-spin"></i></div>
</div>

<section>
  
	<div class="leftpanel">
		<?php include('leftpanel.php') ?>
	</div><!-- leftpanel -->
  
  <div class="mainpanel">
    
    <div class="headerbar">
		<?php include('header.php') ?>
    </div><!-- headerbar -->
    
    <div class="pageheader">
      <h2><i class="fa fa-home"></i> Events <span>All elements to manage your Events...</span></h2>
      <div class="breadcrumb-wrapper">
        <span class="label">You are here:</span>
        <ol class="breadcrumb">
          <li><a href="index.php">Procialize</a></li>
          <li class="active">Events</li>
        </ol>
      </div>
    </div>
    
    <div class="contentpanel"><!-- Content Panel -->
	
		<div class="row"><!-- First Section -->
        
			<div class="col-sm-6 col-md-3">
			  <div class="panel panel-success panel-stat">
				<div class="panel-heading">
				  
				  <div class="stat">
					<div class="row">
					  <div class="col-xs-4">
						<img src="images/is-user.png" alt="" />
					  </div>
					  <div class="col-xs-8">
						<small class="stat-label">Analytics</small>
						<h1>900k+</h1>
					  </div>
					</div><!-- row -->
					
					<div class="mb15"></div>
					
					<div class="row">
					  <div class="col-xs-6">
						<small class="stat-label">Event Profile</small>
						<h4>7.80</h4>
					  </div>
					  
					  <div class="col-xs-6">
						<small class="stat-label">% New Visits</small>
						<h4>76.43%</h4>
					  </div>
					</div><!-- row -->
				  </div><!-- stat -->
				  
				</div><!-- panel-heading -->
			  </div><!-- panel -->
			</div><!-- col-sm-6 -->
			
			<div class="col-sm-6 col-md-3">
			  <div class="panel panel-danger panel-stat">
				<div class="panel-heading">
				  
				  <div class="stat">
					<div class="row">
					  <div class="col-xs-4">
						<img src="images/is-document.png" alt="" />
					  </div>
					  <div class="col-xs-8">
						<small class="stat-label">Event Profile</small>
						<h1>54.40%</h1>
					  </div>
					</div><!-- row -->
					
					<div class="mb15"></div>
					
					<small class="stat-label">Avg. Visit Duration</small>
					<h4>01:80:22</h4>
					  
				  </div><!-- stat -->
				  
				</div><!-- panel-heading -->
			  </div><!-- panel -->
			</div><!-- col-sm-6 -->
			
			<div class="col-sm-6 col-md-3">
			  <div class="panel panel-primary panel-stat">
				<div class="panel-heading">
				  
				  <div class="stat">
					<div class="row">
					  <div class="col-xs-4">
						<img src="images/is-document.png" alt="" />
					  </div>
					  <div class="col-xs-8">
						<small class="stat-label">Agenda</small>
						<h1>300k+</h1>
					  </div>
					</div><!-- row -->
					
					<div class="mb15"></div>
					
					<small class="stat-label">% Bounce Rate</small>
					<h4>34.23%</h4>
					  
				  </div><!-- stat -->
				  
				</div><!-- panel-heading -->
			  </div><!-- panel -->
			</div><!-- col-sm-6 -->
			
			<div class="col-sm-6 col-md-3">
			  <div class="panel panel-dark panel-stat">
				<div class="panel-heading">
				  
				  <div class="stat">
					<div class="row">
					  <div class="col-xs-4">
						<img src="images/is-money.png" alt="" />
					  </div>
					  <div class="col-xs-8">
						<small class="stat-label">Promote</small>
						<h1>$655</h1>
					  </div>
					</div><!-- row -->
					
					<div class="mb15"></div>
					
					<div class="row">
					  <div class="col-xs-6">
						<small class="stat-label">Last Week</small>
						<h4>$32,322</h4>
					  </div>
					  
					  <div class="col-xs-6">
						<small class="stat-label">Last Month</small>
						<h4>$503,000</h4>
					  </div>
					</div><!-- row -->
					  
				  </div><!-- stat -->
				  
				</div><!-- panel-heading -->
			  </div><!-- panel -->
			</div><!-- col-sm-6 -->
		
		</div><!-- First Section -->
      
      <div class="row">
	  
		<div class="col-sm-4 col-md-3">
          
          <div class="panel panel-default">
            <div class="panel-body">
            <h5 class="subtitle mb5">Most Browser Used</h5>
            <p class="mb15">Duis autem vel eum iriure dolor in hendrerit in vulputate...</p>
            <div id="donut-chart2" style="text-align: center; height: 298px;"></div>
            </div><!-- panel-body -->
          </div><!-- panel -->
          
        </div><!-- col-sm-3 -->
	  
        <div class="col-sm-8 col-md-9">
          <div class="panel panel-default">
            <div class="panel-body">
              <div class="row">
                <div class="col-sm-8">
                  <h5 class="subtitle mb5">Network Performance</h5>
                  <p class="mb15">Duis autem vel eum iriure dolor in hendrerit in vulputate...</p>
                  <div id="basicflot" style="width: 100%; height: 300px; margin-bottom: 20px"></div>
                </div><!-- col-sm-8 -->
                <div class="col-sm-4">
                  <h5 class="subtitle mb5">Server Status</h5>
                  <p class="mb15">Summary of the status of your server.</p>
                  
                  <span class="sublabel">CPU Usage (40.05 - 32 cpus)</span>
                  <div class="progress progress-sm">
                    <div style="width: 40%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="40" role="progressbar" class="progress-bar progress-bar-primary"></div>
                  </div><!-- progress -->
                  
                  <span class="sublabel">Memory Usage (32.2%)</span>
                  <div class="progress progress-sm">
                    <div style="width: 32%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="40" role="progressbar" class="progress-bar progress-bar-success"></div>
                  </div><!-- progress -->
                  
                  <span class="sublabel">Disk Usage (82.2%)</span>
                  <div class="progress progress-sm">
                    <div style="width: 82%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="40" role="progressbar" class="progress-bar progress-bar-danger"></div>
                  </div><!-- progress -->
                  
                  <span class="sublabel">Databases (63/100)</span>
                  <div class="progress progress-sm">
                    <div style="width: 63%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="40" role="progressbar" class="progress-bar progress-bar-warning"></div>
                  </div><!-- progress -->
                  
                  <span class="sublabel">Domains (2/10)</span>
                  <div class="progress progress-sm">
                    <div style="width: 20%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="40" role="progressbar" class="progress-bar progress-bar-success"></div>
                  </div><!-- progress -->
                  
                  <span class="sublabel">Email Account (13/50)</span>
                  <div class="progress progress-sm">
                    <div style="width: 26%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="40" role="progressbar" class="progress-bar progress-bar-success"></div>
                  </div><!-- progress -->
                  
                  
                </div><!-- col-sm-4 -->
              </div><!-- row -->
            </div><!-- panel-body -->
          </div><!-- panel -->
        </div><!-- col-sm-9 -->
		
      </div><!-- row -->
      
      <div class="row">
        
        <div class="col-sm-7">
          
          <div class="table-responsive dashboard-datatable">
            <table class="table" id="table1">
              <thead>
                 <tr>
                    <th>Rendering engine</th>
                    <th>Browser</th>
                    <th>Platform(s)</th>
                 </tr>
              </thead>
              <tbody>
                 <tr class="odd gradeX">
                    <td>Trident</td>
                    <td>Internet
                        Explorer 4.0</td>
                    <td>Win 95+</td>
                 </tr>
                 <tr class="even gradeC">
                    <td>Trident</td>
                    <td>Internet
                        Explorer 5.0</td>
                    <td>Win 95+</td>
                 </tr>
                 <tr class="odd gradeA">
                    <td>Trident</td>
                    <td>Internet
                        Explorer 5.5</td>
                    <td>Win 95+</td>
                 </tr>
                 <tr class="even gradeA">
                    <td>Trident</td>
                    <td>Internet
                        Explorer 6</td>
                    <td>Win 98+</td>
                 </tr>
                 <tr class="odd gradeA">
                    <td>Trident</td>
                    <td>Internet Explorer 7</td>
                    <td>Win XP SP2+</td>
                 </tr>
                 <tr class="even gradeA">
                    <td>Trident</td>
                    <td>AOL browser (AOL desktop)</td>
                    <td>Win XP</td>
                 </tr>
                 <tr class="gradeA">
                    <td>Gecko</td>
                    <td>Firefox 1.0</td>
                    <td>Win 98+ / OSX.2+</td>
                 </tr>
                 <tr class="gradeA">
                    <td>Gecko</td>
                    <td>Firefox 1.5</td>
                    <td>Win 98+ / OSX.2+</td>
                 </tr>
                 <tr class="gradeA">
                    <td>Gecko</td>
                    <td>Firefox 2.0</td>
                    <td>Win 98+ / OSX.2+</td>
                 </tr>
                 <tr class="gradeA">
                    <td>Gecko</td>
                    <td>Firefox 3.0</td>
                    <td>Win 2k+ / OSX.3+</td>
                 </tr>
                 <tr class="gradeA">
                    <td>Gecko</td>
                    <td>Camino 1.0</td>
                    <td>OSX.2+</td>
                 </tr>
                 <tr class="gradeA">
                    <td>Gecko</td>
                    <td>Camino 1.5</td>
                    <td>OSX.3+</td>
                 </tr>
                 <tr class="gradeA">
                    <td>Gecko</td>
                    <td>Netscape 7.2</td>
                    <td>Win 95+ / Mac OS 8.6-9.2</td>
                 </tr>
                 <tr class="gradeA">
                    <td>Gecko</td>
                    <td>Netscape Browser 8</td>
                    <td>Win 98SE+</td>
                 </tr>
                 <tr class="gradeA">
                    <td>Gecko</td>
                    <td>Netscape Navigator 9</td>
                    <td>Win 98+ / OSX.2+</td>
                 </tr>
                 <tr class="gradeA">
                    <td>Gecko</td>
                    <td>Mozilla 1.0</td>
                    <td>Win 95+ / OSX.1+</td>
                 </tr>
                 <tr class="gradeA">
                    <td>Gecko</td>
                    <td>Mozilla 1.1</td>
                    <td>Win 95+ / OSX.1+</td>
                 </tr>
                 <tr class="gradeA">
                    <td>Gecko</td>
                    <td>Mozilla 1.2</td>
                    <td>Win 95+ / OSX.1+</td>
                 </tr>
                 <tr class="gradeA">
                    <td>Gecko</td>
                    <td>Mozilla 1.3</td>
                    <td>Win 95+ / OSX.1+</td>
                 </tr>
                 <tr class="gradeA">
                    <td>Gecko</td>
                    <td>Mozilla 1.4</td>
                    <td>Win 95+ / OSX.1+</td>
                 </tr>
                 <tr class="gradeA">
                    <td>Gecko</td>
                    <td>Mozilla 1.5</td>
                    <td>Win 95+ / OSX.1+</td>
                 </tr>
                 <tr class="gradeA">
                    <td>Gecko</td>
                    <td>Mozilla 1.6</td>
                    <td>Win 95+ / OSX.1+</td>
                 </tr>
                 <tr class="gradeA">
                    <td>Gecko</td>
                    <td>Mozilla 1.7</td>
                    <td>Win 98+ / OSX.1+</td>
                 </tr>
                 <tr class="gradeA">
                    <td>Gecko</td>
                    <td>Mozilla 1.8</td>
                    <td>Win 98+ / OSX.1+</td>
                 </tr>
                 <tr class="gradeA">
                    <td>Gecko</td>
                    <td>Seamonkey 1.1</td>
                    <td>Win 98+ / OSX.2+</td>
                 </tr>
                 <tr class="gradeA">
                    <td>Gecko</td>
                    <td>Epiphany 2.20</td>
                    <td>Gnome</td>
                 </tr>
                 <tr class="gradeA">
                    <td>Webkit</td>
                    <td>Safari 1.2</td>
                    <td>OSX.3</td>
                 </tr>
                 <tr class="gradeA">
                    <td>Webkit</td>
                    <td>Safari 1.3</td>
                    <td>OSX.3</td>
                 </tr>
                 <tr class="gradeA">
                    <td>Webkit</td>
                    <td>Safari 2.0</td>
                    <td>OSX.4+</td>
                 </tr>
                 <tr class="gradeA">
                    <td>Webkit</td>
                    <td>Safari 3.0</td>
                    <td>OSX.4+</td>
                 </tr>
                 <tr class="gradeA">
                    <td>Webkit</td>
                    <td>OmniWeb 5.5</td>
                    <td>OSX.4+</td>
                 </tr>
                 <tr class="gradeA">
                    <td>Webkit</td>
                    <td>iPod Touch / iPhone</td>
                    <td>iPod</td>
                 </tr>
                 <tr class="gradeA">
                    <td>Webkit</td>
                    <td>S60</td>
                    <td>S60</td>
                 </tr>
                 <tr class="gradeA">
                    <td>Presto</td>
                    <td>Opera 7.0</td>
                    <td>Win 95+ / OSX.1+</td>
                 </tr>
                 <tr class="gradeA">
                    <td>Presto</td>
                    <td>Opera 7.5</td>
                    <td>Win 95+ / OSX.2+</td>
                 </tr>
                 <tr class="gradeA">
                    <td>Presto</td>
                    <td>Opera 8.0</td>
                    <td>Win 95+ / OSX.2+</td>
                 </tr>
                 <tr class="gradeA">
                    <td>Presto</td>
                    <td>Opera 8.5</td>
                    <td>Win 95+ / OSX.2+</td>
                 </tr>
                 <tr class="gradeA">
                    <td>Presto</td>
                    <td>Opera 9.0</td>
                    <td>Win 95+ / OSX.3+</td>
                 </tr>
                 <tr class="gradeA">
                    <td>Presto</td>
                    <td>Opera 9.2</td>
                    <td>Win 88+ / OSX.3+</td>
                 </tr>
                 <tr class="gradeA">
                    <td>Presto</td>
                    <td>Opera 9.5</td>
                    <td>Win 88+ / OSX.3+</td>
                 </tr>
                 <tr class="gradeA">
                    <td>Presto</td>
                    <td>Opera for Wii</td>
                    <td>Wii</td>
                 </tr>
                 <tr class="gradeA">
                    <td>Presto</td>
                    <td>Nokia N800</td>
                    <td>N800</td>
                 </tr>
                 <tr class="gradeA">
                    <td>Presto</td>
                    <td>Nintendo DS browser</td>
                    <td>Nintendo DS</td>
                 </tr>
                 <tr class="gradeC">
                    <td>KHTML</td>
                    <td>Konqureror 3.1</td>
                    <td>KDE 3.1</td>
                 </tr>
                 <tr class="gradeA">
                    <td>KHTML</td>
                    <td>Konqureror 3.3</td>
                    <td>KDE 3.3</td>
                 </tr>
                 <tr class="gradeA">
                    <td>KHTML</td>
                    <td>Konqureror 3.5</td>
                    <td>KDE 3.5</td>
                 </tr>
                 <tr class="gradeX">
                    <td>Tasman</td>
                    <td>Internet Explorer 4.5</td>
                    <td>Mac OS 8-9</td>
                 </tr>
                 <tr class="gradeC">
                    <td>Tasman</td>
                    <td>Internet Explorer 5.1</td>
                    <td>Mac OS 7.6-9</td>
                 </tr>
                 <tr class="gradeC">
                    <td>Tasman</td>
                    <td>Internet Explorer 5.2</td>
                    <td>Mac OS 8-X</td>
                 </tr>
                 <tr class="gradeA">
                    <td>Misc</td>
                    <td>NetFront 3.1</td>
                    <td>Embedded devices</td>
                 </tr>
                 <tr class="gradeA">
                    <td>Misc</td>
                    <td>NetFront 3.4</td>
                    <td>Embedded devices</td>
                 </tr>
                 <tr class="gradeX">
                    <td>Misc</td>
                    <td>Dillo 0.8</td>
                    <td>Embedded devices</td>
                 </tr>
                 <tr class="gradeX">
                    <td>Misc</td>
                    <td>Links</td>
                    <td>Text only</td>
                 </tr>
                 <tr class="gradeX">
                    <td>Misc</td>
                    <td>Lynx</td>
                    <td>Text only</td>
                 </tr>
                 <tr class="gradeC">
                    <td>Misc</td>
                    <td>IE Mobile</td>
                    <td>Windows Mobile 6</td>
                 </tr>
                 <tr class="gradeC">
                    <td>Misc</td>
                    <td>PSP browser</td>
                    <td>PSP</td>
                 </tr>
                 <tr class="gradeU">
                    <td>Other browsers</td>
                    <td>All others</td>
                    <td>-</td>
                 </tr>
              </tbody>
           </table>
          </div><!-- table-responsive -->
          
        </div><!-- col-sm-7 -->
        
        <div class="col-sm-5">
          
          <div class="panel panel-success">
            <div class="panel-heading padding5">
              <div id="line-chart" style="height: 248px;"></div>
            </div>
            <div class="panel-body">
              <div class="tinystat pull-left">
                <div id="sparkline" class="chart mt5"></div>
                <div class="datainfo">
                  <span class="text-muted">Average Sales</span>
                  <h4>$630,201</h4>
                </div>
              </div><!-- tinystat -->
              <div class="tinystat pull-right">
                <div id="sparkline2" class="chart mt5"></div>
                <div class="datainfo">
                  <span class="text-muted">Total Sales</span>
                  <h4>$139,201</h4>
                </div>
              </div><!-- tinystat -->
            </div>
          </div><!-- panel -->
          
        </div><!-- col-sm-6 -->
      </div><!-- row -->
	  
    </div><!-- contentpanel -->
    
  </div><!-- mainpanel -->
  
	<div class="rightpanel">
		<?php include('rightpanel.php') ?>
	</div><!-- rightpanel -->
  
  
</section>


<script src="js/jquery-1.10.2.min.js"></script>
<script src="js/jquery-migrate-1.2.1.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/modernizr.min.js"></script>
<script src="js/jquery.sparkline.min.js"></script>
<script src="js/toggles.min.js"></script>
<script src="js/retina.min.js"></script>
<script src="js/jquery.cookies.js"></script>

<script src="js/flot/flot.min.js"></script>
<script src="js/flot/flot.resize.min.js"></script>
<script src="js/morris.min.js"></script>
<script src="js/raphael-2.1.0.min.js"></script>

<script src="js/jquery.datatables.min.js"></script>
<script src="js/chosen.jquery.min.js"></script>

<script src="js/custom.js"></script>
<script src="js/dashboard.js"></script>

<script>
  jQuery(document).ready(function() {
    
    jQuery('#table1').dataTable();
    
    jQuery('#table2').dataTable({
      "sPaginationType": "full_numbers"
    });
    
    // Chosen Select
    jQuery("select").chosen({
      'min-width': '100px',
      'white-space': 'nowrap',
      disable_search_threshold: 10
    });
    
    // Delete row in a table
    jQuery('.delete-row').click(function(){
      var c = confirm("Continue delete?");
      if(c)
        jQuery(this).closest('tr').fadeOut(function(){
          jQuery(this).remove();
        });
        
        return false;
    });
    
    // Show aciton upon row hover
    jQuery('.table-hidaction tbody tr').hover(function(){
      jQuery(this).find('.table-action-hide a').animate({opacity: 1});
    },function(){
      jQuery(this).find('.table-action-hide a').animate({opacity: 0});
    });
  
  
  });
</script>
</body>
</html>
