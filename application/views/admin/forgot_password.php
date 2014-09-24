<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="shortcut icon" href="images/favicon.png" type="image/png">

  <title>Procialize Admin</title>

  <link href="<?php echo base_url(); ?>public/admin/css/style.default.css" rel="stylesheet">

  <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!--[if lt IE 9]>
  <script src="<?php echo base_url(); ?>public/admin/js/html5shiv.js"></script>
  <script src="<?php echo base_url(); ?>public/admin/js/respond.min.js"></script>
  <![endif]-->
</head>

<body class="signin">

<!-- Preloader -->
<div id="preloader">
    <div id="status"><i class="fa fa-spinner fa-spin"></i></div>
</div>

<section>
  
    <div class="signinpanel">
        
        <div class="row">
            
            <div class="col-md-5">
                
                <div class="signin-info">
                    <div class="">
                        <h1>Procialize</h1>
                    </div><!-- logopanel -->
                
                    <div class="mb20"></div>
                
                    <h5><strong>Welcome to Procialize!</strong></h5>
                    <ul>
                        <li><i class="fa fa-arrow-circle-o-right mr5"></i> Event Sessions</li>
                        <li><i class="fa fa-arrow-circle-o-right mr5"></i> Interact with Speakers &amp; Attendees</li>
                        <li><i class="fa fa-arrow-circle-o-right mr5"></i> Give Feedback</li>
                        <li><i class="fa fa-arrow-circle-o-right mr5"></i> Invite Contacts</li>
						<li><i class="fa fa-arrow-circle-o-right mr5"></i> Social Sharing</li>
                        <li><i class="fa fa-arrow-circle-o-right mr5"></i> and much more...</li>
                    </ul>
                </div><!-- signin0-info -->
            
            </div>
            
            <div class="col-md-7 mt10">
                <?php
                  echo $this->session->flashdata('message');
                 echo  validation_errors();?>
				<?php  echo ''; print_R(generateFormHtml($fields));?>
            </div>
            
        </div><!-- row -->
        
        <div class="signup-footer">
            <div class="pull-left">
                &copy; 2014. All Rights Reserved. Procialize
            </div>
            <div class="pull-right">
                <!--Created By: <a href="http://www.infinisystem.com/" target="_blank">Infini Systems</a>-->
            </div>
        </div>
        
    </div><!-- signin -->
  
</section>


<script src="<?php echo base_url(); ?>public/admin/js/jquery-1.10.2.min.js"></script>
<script src="<?php echo base_url(); ?>public/admin/js/jquery-migrate-1.2.1.min.js"></script>
<script src="<?php echo base_url(); ?>public/admin/js/bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>public/admin/js/modernizr.min.js"></script>
<script src="<?php echo base_url(); ?>public/admin/js/retina.min.js"></script>

<script src="<?php echo base_url(); ?>public/admin/js/custom.js"></script>
<script type="text/javascript">

  jQuery('#cancel_button .btn-danger').click(function() {
    window.history.back();
  });

</script>
</body>
</html>
