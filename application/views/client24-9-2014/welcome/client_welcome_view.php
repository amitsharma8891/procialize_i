<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="<?php echo SITE_URL?>public/client/images/favicon.png" type="image/png">
    <title>Procialize</title>

    <!-- Bootstrap -->
    <link href="<?php echo CLIENT_CSS?>style.default.css" rel="stylesheet">

    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
       <style type="text/css">
	.carousel-fade .carousel-inner .item {
  opacity: 0.5;
-webkit-transition: opacity 1s ease-in-out;
  -moz-transition: opacity 1s ease-in-out;
  -o-transition: opacity 1s ease-in-out;
  transition: opacity 1s ease-in-out;}
.carousel-fade .carousel-inner .active {
  opacity: 1 !important;
}
.carousel-fade .carousel-inner .active.left,
.carousel-fade .carousel-inner .active.right {
  left: 0;
  opacity: 0.5;
  z-index: 1;
}
.carousel-fade .carousel-inner .next.left,
.carousel-fade .carousel-inner .prev.right {
  opacity: 0.5;
}
.carousel-fade .carousel-control {
  z-index: 2;
}
	</style>
 
  </head>
  <body>
  	<!--<div class="navbar navbar-fixed-top slider-top">
		<div class="container-fluid">
			<center><img src="<?php echo CLIENT_IMAGES?>pl_index.png" style="margin-top:50px;"></center>
		</div>
	</div>-->
  
	<div id="carousel-example-generic" class="carousel slide index-slider carousel-fade" data-ride="carousel">
		<!-- Indicators -->
		<ol class="carousel-indicators">
                    <?php 
                        if(getSetting()->app_slider_image)
                        {
                            $class = '';
                            $slider = json_decode(getSetting()->app_slider_image,TRUE);
                            foreach($slider as $sl=>$slv)
                            {
                                $class = '';
                                if($sl == 0)
                                    $class = 'class="active"';
                                echo '<li data-target="#carousel-example-generic" data-slide-to="'.$sl.'" '.$class.'></li>';
                            }
                        }
                    ?>
<!--			<li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
			<li data-target="#carousel-example-generic" data-slide-to="1"></li>
			<li data-target="#carousel-example-generic" data-slide-to="2"></li>
			<li data-target="#carousel-example-generic" data-slide-to="3"></li>
			<li data-target="#carousel-example-generic" data-slide-to="4"></li>
			-->
		</ol>
                <!--<div class="index_skip"><a href="<?php echo SITE_URL?>search" style="color:#fff;">Skip</a></div>-->
		<!-- Wrapper for slides -->
		<div class="carousel-inner">
                    <?php 
                        if(getSetting()->app_slider_image)
                        {
                            $class = '';
                            $slider = json_decode(getSetting()->app_slider_image,TRUE);
                            foreach($slider as $sl=>$slv)
                            {
                                $class = '';
                                if($sl == 0)
                                {
                                    $class = 'active';
                                }
                                    
                                ?>
                                    <div class="item <?php echo $class?>">
                                        <img src="<?php echo SITE_URL.'uploads/app_slider/'.$slv?>" alt="" />
                                        <div class="container">
                                                <div class="carousel-caption">
                                                        <!--<p class="lead">A platform to Professionally Socialize</p>-->
                                                </div>
                                        </div>
                                    </div>
                                <?php
                            }
                        }
                    ?>
			
			
			<!--<div class="item">
				<img src="<?php echo CLIENT_IMAGES?>slider2.jpg" alt="" />
				<div class="container">
					<div class="carousel-caption">
					</div>
				</div>
			</div>
                    
			<div class="item">
				<img src="<?php echo CLIENT_IMAGES?>slider3.jpg" alt="" />
				<div class="container">
					<div class="carousel-caption">
					</div>
				</div>
			</div>
			
			<div class="item">
				<img src="<?php echo CLIENT_IMAGES?>slider4.jpg" alt="" />
				<div class="container">
					<div class="carousel-caption">
					</div>
				</div>
			</div>
			
			<div class="item">
				<img src="<?php echo CLIENT_IMAGES?>slider5.jpg" alt="" />
				<div class="container">
					<div class="carousel-caption">
					</div>
				</div>
			</div>-->

		</div>
                

	</div>
      
	
	<div class="navbar navbar-fixed-bottom slider-bottom">
		<div class="container-fluid">
		
                    <p class="text-center" style="margin-bottom:0px;"><a href="<?php echo SITE_URL?>events">Continue</a></p>
		</div>
	</div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="<?php echo CLIENT_SCRIPTS?>touchswipe.min.js"></script>
    <script src="<?php echo CLIENT_SCRIPTS?>bootstrap.min.js"></script>
	<script>  
	$(document).ready(function() { 

			$('.carousel').carousel({
			pause: "true",
			interval: 7000
		});

		$('.carousel').css({'margin': 0, 'width': $(window).outerWidth(), 'height': $(window).outerHeight()});
		//$('.carousel-inner').css({'z-index': 0});
		$('.carousel .item').css({'position': 'fixed', 'width': '100%', 'height': '100%'});
		$('.carousel-inner div.item img').each(function() {
			var imgSrc = $(this).attr('src');
			$(this).parent().css({'background': 'url('+imgSrc+') center center no-repeat', '-webkit-background-size': '100% ', '-moz-background-size': '100%', '-o-background-size': '100%', 'background-size': '100%', '-webkit-background-size': 'cover', '-moz-background-size': 'cover', '-o-background-size': 'cover', 'background-size': 'cover'});
			$(this).remove();
		});

		$(window).on('resize', function() {
			$('.carousel').css({'width': $(window).outerWidth(), 'height': $(window).outerHeight()});
		});
	
  		$(".carousel-inner").swipe( {
						//Generic swipe handler for all directions
						swipeLeft:function(event, direction, distance, duration, fingerCount) {
							$(this).parent().carousel('next'); 
						},
						swipeRight: function() {
							$(this).parent().carousel('prev'); 
						},
						//Default is 75px, set to 0 for demo so any distance triggers swipe
						threshold:0
					});
	});  
	</script> 
	
  </body>
</html>