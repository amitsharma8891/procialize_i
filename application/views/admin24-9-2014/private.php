<?php $thisPage='Private Organizer'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="shortcut icon" href="images/favicon.png" type="image/png">

  <title>Private Organizer - Procialize</title>

  <link href="css/style.default.css" rel="stylesheet">
  <link rel="stylesheet" href="css/jquery.tagsinput.css" />
  <link rel="stylesheet" href="css/bootstrap-fileupload.min.css" />
  
  <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!--[if lt IE 9]>
  <script src="js/html5shiv.js"></script>
  <script src="js/respond.min.js"></script>
  <![endif]-->
  
</head>

<body>
<section>
  
	<div class="leftpanel">
		<?php include('leftpanel.php') ?>
	</div><!-- leftpanel -->
  
	<div class="mainpanel">
    
		<div class="headerbar">
			<?php include('header.php') ?>
		</div><!-- headerbar -->
		
		<div class="pageheader">
		  <h2><i class="fa fa-star"></i> Private Organizer <span>Create Private Organizer</span></h2>
		  <div class="breadcrumb-wrapper">
			<ol class="breadcrumb">
			  <li>Create Organizer</li>
			  <li class="active">Private Organizer</li>
			</ol>
		  </div>
		</div>
		
		<div class="contentpanel"><!-- Content Panel -->
		
			<div class="row mb10"><!-- Add Exhibitor Row -->
			
				<form action="/" method="post">
				
				<div class="form-group">
					<label class="col-sm-2 control-label">Organizer Name</label>
					<div class="col-sm-6">
						<input type="text" placeholder="Organizer Name" class="form-control" />
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">Username</label>
					<div class="col-sm-6">
						<input type="text" placeholder="Username" class="form-control" />
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">Password</label>
					<div class="col-sm-6">
						<input type="text" placeholder="Password" class="form-control" />
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">First Name</label>
					<div class="col-sm-6">
						<input type="text" placeholder="First Name" class="form-control" />
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">Last Name</label>
					<div class="col-sm-6">
						<input type="text" placeholder="Last Name" class="form-control" />
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">Email</label>
					<div class="col-sm-6">
						<input type="text" placeholder="Email" class="form-control" />
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">Mobile</label>
					<div class="col-sm-6">
						<input type="text" placeholder="Mobile" class="form-control" />
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-4">
					<input type="button" class="btn btn-danger btn-block" value="Cancel"/>
					</div>
					<div class="col-sm-4">
					<input type="button" class="btn btn-success btn-block" value="Save"/>
					</div>
				</div>
				
				</form>
			</div>
			
			
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
<script src="js/jquery.tagsinput.min.js"></script>
<script src="js/bootstrap-fileupload.min.js"></script>
<script src="js/chosen.jquery.min.js"></script>

<script src="js/custom.js"></script>
<script>
jQuery(document).ready(function(){
    
  // Chosen Select
  jQuery(".chosen-select").chosen({'width':'100%','white-space':'nowrap'});
  
  // Tags Input
  jQuery('#tags').tagsInput({width:'auto'});

});
</script>
</body>
</html>
