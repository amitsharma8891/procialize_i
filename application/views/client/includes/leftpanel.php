<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="shortcut icon" href="images/favicon.png" type="image/png">
        <title><?php echo getSetting()->app_name; ?></title>
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

                <div class="logopanel">
                    <h1><?php echo getSetting()->app_name; ?></h1>
                </div><!-- logopanel -->

                <div class="leftpanelinner">    

                    <!-- This is only visible to small devices -->
                    <div class="visible-xs hidden-sm hidden-md hidden-lg">   
                        <div class="media userlogged">
                            <img alt="" src="images/photos/loggeduser.png" class="media-object">
                            <div class="media-body">
                                <h4>John Doe</h4>
                                <span>"Life is so..."</span>
                            </div>

                        </div>
                    </div>

                    <ul class="nav nav-pills nav-stacked nav-bracket mt10">
                        <li class="active"><a href="index.html"><i class="fa fa-home"></i> <span>Home</span></a></li>
                        <li><a href="index.html"><i class="fa fa-search"></i> <span>Search Events</span></a></li>
                        <li><a href="index.html"><i class="fa fa-sitemap"></i> <span>Saved Exhibitors</span></a></li>
                        <li><a href="index.html"><i class="fa fa-users"></i> <span>Saved Attendees</span></a></li>
                        <li><a href="index.html"><i class="fa fa-bullhorn"></i> <span>Saved Speakers</span></a></li>
                        <li><a href="index.html"><i class="fa fa-retweet"></i> <span>Share Procialize</span></a></li>
<!--                        <li><a href="http://procialize.net/metropolis-sponsors" target="blank"><i class="fa fa-money"></i> <span>Our Sponsors</span></a></li>-->
                        <li><a href="index.html"><i class="fa fa-list"></i> <span>About Procialize</span></a></li>
                        <li><a href="index.html"><i class="fa fa-desktop"></i> <span>Application Settings</span></a></li>
                        <li><a href="<?php echo SITE_URL ?>client/event/logout"><i class="glyphicon glyphicon-folder-close"></i> <span>Logout</span></a></li>
                    </ul>

                </div><!-- leftpanelinner -->
            </div><!-- leftpanel -->

            <div class="mainpanel">
                <div class="page-background" id="background_section">
                    <div class="bg-img" id="px_background_img"></div>
                </div>

                <div class="headerbar">

                    <a class="menutoggle"><i class="fa fa-bars"></i></a>
                    <a class="logotop"><img src="images/pl.png"></a>
                    <p class="titletop"><?php echo getSetting()->app_name; ?></p>

                    <div class="header-right">
                        <ul class="headermenu">

                            <li>
                                <div class="btn-group">
                                    <button class="btn btn-default dropdown-toggle tp-icon" data-toggle="dropdown">
                                        <i class="glyphicon glyphicon-envelope"></i>
                                    </button>
                                </div>
                            </li>
                            <li>
                                <div class="btn-group">
                                    <button class="btn btn-default dropdown-toggle tp-icon" data-toggle="dropdown">
                                        <i class="glyphicon glyphicon-random"></i>
                                    </button>
                                </div>
                            </li>
                            <li>
                                <button id="chatview" class="btn btn-default tp-icon chat-icon">
                                    <i class="glyphicon glyphicon-bell"></i>
                                </button>
                            </li>
                        </ul>
                    </div><!-- header-right -->

                </div><!-- headerbar -->

                <div class="pageheader">
                    <input type="text" class="form-control" placeholder="Trade, Furniture">
                </div>

                <div class="contentpanel">
                    <div class="panel panel-default panel-stat">
                        <div class="panel-heading">

                            <div class="row">

                                <!-- <div class="col-sm-6 col-md-3">
                                      <div class="stat well well-sm">
                                        <div class="row">
                                          <div class="col-xs-3">
                                            <img src="images/homexpo.png" alt="" class="thumbnail img-responsive rbf"/>
                                          </div>
                                          <div class="col-xs-6">
                                                                <h4>April 15-18, 2014</h4>
                                            <small class="stat-label">New Delhi, India</small>
                                            <small class="stat-label">Interiors, Decoratives</small>
                                          </div>
                                                          <div class="col-xs-3">
                                                                <small class="stat-label"><img src="images/epc.png" class="thumbnail img-responsive rbf" /></small>
                                            <small class="stat-label"><img src="images/tradeindia.png" class="thumbnail img-responsive rbf" /></small>
                                          </div>
                                        </div>
                                        
                                                        <h4 class="tits">Home Expo India 2014</h4>
                                                        
                                                        <div class="panel panel-dark">
                                                                <div class="panel-heading">
                                                                  <ul class="photo-meta">
                                                                        <li><a href="#"> 94 Exhibitors</a></li>
                                                                        <li><a href="#"> 12 Speakers</a></li>
                                                                        <li><a href="#"> 185 Attendees</a></li>
                                                                  </ul>
                                                                </div>
                                                                <div class="panel-body">
                                                                        <div class="col-item">
                                                                                <div class="photo photo-left">
                                                        <img src="images/avatar.png" class="img-responsive thumb" alt="a" />
                                                                                        <img src="images/avatar.png" class="img-responsive thumb" alt="a" />
                                                                                        <img src="images/avatar.png" class="img-responsive thumb" alt="a" />
                                                                                        <img src="images/avatar.png" class="img-responsive thumb" alt="a" />
                                                                                        <img src="images/avatar.png" class="img-responsive thumb" alt="a" />
                                                                                        <div class="clearfix"></div>
                                                                                        <p class="det-left"><a href="#" class="">16 Common Connections</a></p>
                                                    </div>
                                                                                <div class="photo photo-right">
                                                        <img src="images/avatar.png" class="img-responsive thumb" alt="a" />
                                                                                        <img src="images/avatar.png" class="img-responsive thumb" alt="a" />
                                                                                        <img src="images/avatar.png" class="img-responsive thumb" alt="a" />
                                                                                        <div class="clearfix"></div>
                                                                                        <p class="det-right"><a href="#" class="">Gallery</a></p>
                                                    </div>
                                                                        </div>
                                                                </div>
                                                        </div>
                                                        
                                      </div>
                                </div> -->

                                <div class="col-sm-6 col-md-3">
                                    <div class="stat well well-sm">
                                        <a href="event.html">
                                            <div class="row">
                                                <div class="col-xs-4">
                                                    <div class="thumb">
                                                        <img src="images/homexpo.png" alt="" class="img-responsive userlogo"/>
                                                    </div>
                                                </div>
                                                <div class="col-xs-5 eventdet">
                                                    <h4>15-18 Apr, 2014</h4>
                                                    <small class="stat-label">New Delhi, India</small>
                                                    <small class="stat-label">Interiors, Decoratives</small>
                                                </div>
                                                <div class="col-xs-3">
                                                    <small class="stat-label">
                                                        <div class="thumb">
                                                            <img src="images/epc.png" class="img-responsive userlogor" />
                                                        </div>
                                                    </small>
                                                    <small class="stat-label">
                                                        <div class="thumb">
                                                            <img src="images/tradeindia.png" class="img-responsive userlogor" />
                                                        </div>
                                                    </small>
                                                </div>
                                            </div><!-- row -->

                                            <h4 class="tits">Home Expo India 2014</h4>
                                        </a>
                                        <div class="panel panel-dark">
                                            <div class="panel-heading">
                                                <ul class="photo-meta">
                                                    <li><a href="#"> 94 Exhibitors</a></li>
                                                    <li><a href="#"> 12 Speakers</a></li>
                                                    <li><a href="#"> 185 Attendees</a></li>
                                                </ul>
                                            </div>
                                            <div class="panel-body">
                                                <div class="row">
                                                    <div class="col-xs-6 temp text-center">
                                                        <ul class="social-list">
                                                            <li><a href="#"><img class="img-responsive" src="images/1.jpg"></a></li>
                                                            <li><a href="#"><img class="img-responsive" src="images/2.jpg"></a></li>
                                                            <li><a href="#"><img class="img-responsive" src="images/3.jpg"></a></li>
                                                            <li><a href="#"><img class="img-responsive" src="images/4.jpg"></a></li>
                                                            <li><a href="#"><img class="img-responsive" src="images/1.jpg"></a></li>
                                                        </ul>
                                                        <h5>16 Common Connections</h5>
                                                    </div>
                                                    <div class="col-xs-6 weather text-center">
                                                        <ul class="social-list">
                                                            <li><a href="#"><img class="img-responsive" src="images/gallery1.png"></a></li>
                                                            <li><a href="#"><img class="img-responsive" src="images/gallery2.png"></a></li>
                                                            <li><a href="#"><img class="img-responsive" src="images/gallery3.png"></a></li>
                                                        </ul>
                                                        <h5>Gallery</h5>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div><!-- stat -->
                                </div><!-- col-sm-6 -->

                                <div class="col-sm-6 col-md-3">
                                    <div class="stat well well-sm">
                                        <div class="row">
                                            <div class="col-xs-4">
                                                <div class="thumb">
                                                    <img src="images/chemspec.png" alt="" class="img-responsive userlogo"/>
                                                </div>
                                            </div>
                                            <div class="col-xs-5 eventdet">
                                                <h4>10-11 Apr, 2014</h4>
                                                <small class="stat-label">Mumbai, India</small>
                                                <small class="stat-label">Pharma, Chemicals</small>
                                            </div>
                                            <div class="col-xs-3">
                                                <small class="stat-label">
                                                    <div class="thumb">
                                                        <img src="images/chemicalweekly.png" class="img-responsive userlogor" />
                                                    </div>
                                                </small>
                                                <small class="stat-label">
                                                    <div class="thumb">
                                                        <img src="images/tradeindia.png" class="img-responsive userlogor" />
                                                    </div>
                                                </small>
                                            </div>
                                        </div><!-- row -->

                                        <h4 class="tits">Chemspec India 2014</h4>

                                        <div class="panel panel-dark">
                                            <div class="panel-heading">
                                                <ul class="photo-meta">
                                                    <li><a href="#"> 198 Exhibitors</a></li>
                                                    <li><a href="#"> 19 Speakers</a></li>
                                                    <li><a href="#"> 203 Attendees</a></li>
                                                </ul>
                                            </div>
                                            <div class="panel-body">
                                                <div class="row">
                                                    <div class="col-xs-6 temp text-center">
                                                        <ul class="social-list">
                                                            <li><a href="#"><img class="img-responsive" src="images/1.jpg"></a></li>
                                                            <li><a href="#"><img class="img-responsive" src="images/2.jpg"></a></li>
                                                            <li><a href="#"><img class="img-responsive" src="images/3.jpg"></a></li>
                                                            <li><a href="#"><img class="img-responsive" src="images/4.jpg"></a></li>
                                                            <li><a href="#"><img class="img-responsive" src="images/1.jpg"></a></li>
                                                        </ul>
                                                        <h5>32 Common Connections</h5>
                                                    </div>
                                                    <div class="brbr"></div>
                                                    <div class="col-xs-6 weather text-center">
                                                        <ul class="social-list">
                                                            <li><a href="#"><img class="img-responsive" src="images/gallery1.png"></a></li>
                                                            <li><a href="#"><img class="img-responsive" src="images/gallery2.png"></a></li>
                                                            <li><a href="#"><img class="img-responsive" src="images/gallery3.png"></a></li>
                                                        </ul>
                                                        <h5>Gallery</h5>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div><!-- stat -->
                                </div><!-- col-sm-6 -->

                                <div class="col-sm-6 col-md-3">
                                    <div class="stat well well-sm">
                                        <div class="row">
                                            <div class="col-xs-4">
                                                <div class="thumb">
                                                    <img src="images/travelofair.png" alt="" class="img-responsive userlogo"/>
                                                </div>
                                            </div>
                                            <div class="col-xs-5 eventdet">
                                                <h4>23-28 Aug, 2014</h4>
                                                <small class="stat-label">New York, USA</small>
                                                <small class="stat-label">Travel, Trade</small>
                                            </div>
                                            <div class="col-xs-3">
                                                <small class="stat-label">
                                                    <div class="thumb">
                                                        <img src="images/asiatic.png" class="img-responsive userlogor" />
                                                    </div>
                                                </small>
                                            </div>
                                        </div><!-- row -->

                                        <h4 class="tits">Travel-O-Fair</h4>

                                    </div><!-- stat -->
                                </div><!-- col-sm-6 -->

                                <div class="col-sm-6 col-md-3">
                                    <div class="stat well well-sm">
                                        <div class="row">
                                            <div class="col-xs-4">
                                                <div class="thumb">
                                                    <img src="images/invest.png" alt="" class="img-responsive userlogo"/>
                                                </div>
                                            </div>
                                            <div class="col-xs-5 eventdet">
                                                <h4>23-28 Aug, 2014</h4>
                                                <small class="stat-label">California, USA</small>
                                                <small class="stat-label">Travel, Trade</small>
                                            </div>
                                            <div class="col-xs-3">
                                                <small class="stat-label">
                                                    <div class="thumb">
                                                        <img src="images/asiatic.png" class="img-responsive userlogor" />
                                                    </div>
                                                </small>
                                            </div>
                                        </div><!-- row -->

                                        <h4 class="tits">Investment Expo</h4>

                                    </div><!-- stat -->
                                </div><!-- col-sm-6 -->


                            </div><!-- row -->
                        </div>
                    </div>
                </div><!-- contentpanel -->

            </div><!-- mainpanel -->

            <div class="rightpanel">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs nav-justified">
                    <li class="active"><a href="#rp-alluser" data-toggle="tab"><i class="fa fa-users"></i></a></li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                    <div class="tab-pane active" id="rp-alluser">
                        <h5 class="sidebartitle">Online Users</h5>
                        <ul class="chatuserlist">
                            <li class="online">
                                <div class="media">
                                    <a href="#" class="pull-left media-thumb">
                                        <img alt="" src="images/photos/userprofile.png" class="media-object">
                                    </a>
                                    <div class="media-body">
                                        <strong>Eileen Sideways</strong>
                                        <small>Los Angeles, CA</small>
                                    </div>
                                </div><!-- media -->
                            </li>
                            <li class="online">
                                <div class="media">
                                    <a href="#" class="pull-left media-thumb">
                                        <img alt="" src="images/photos/user1.png" class="media-object">
                                    </a>
                                    <div class="media-body">
                                        <span class="pull-right badge badge-danger">2</span>
                                        <strong>Zaham Sindilmaca</strong>
                                        <small>San Francisco, CA</small>
                                    </div>
                                </div><!-- media -->
                            </li>
                            <li class="online">
                                <div class="media">
                                    <a href="#" class="pull-left media-thumb">
                                        <img alt="" src="images/photos/user2.png" class="media-object">
                                    </a>
                                    <div class="media-body">
                                        <strong>Nusja Nawancali</strong>
                                        <small>Bangkok, Thailand</small>
                                    </div>
                                </div><!-- media -->
                            </li>
                            <li class="online">
                                <div class="media">
                                    <a href="#" class="pull-left media-thumb">
                                        <img alt="" src="images/photos/user3.png" class="media-object">
                                    </a>
                                    <div class="media-body">
                                        <strong>Renov Leongal</strong>
                                        <small>Cebu City, Philippines</small>
                                    </div>
                                </div><!-- media -->
                            </li>
                            <li class="online">
                                <div class="media">
                                    <a href="#" class="pull-left media-thumb">
                                        <img alt="" src="images/photos/user4.png" class="media-object">
                                    </a>
                                    <div class="media-body">
                                        <strong>Weno Carasbong</strong>
                                        <small>Tokyo, Japan</small>
                                    </div>
                                </div><!-- media -->
                            </li>
                        </ul>

                        <div class="mb30"></div>

                        <h5 class="sidebartitle">Offline Users</h5>
                        <ul class="chatuserlist">
                            <li>
                                <div class="media">
                                    <a href="#" class="pull-left media-thumb">
                                        <img alt="" src="images/photos/user5.png" class="media-object">
                                    </a>
                                    <div class="media-body">
                                        <strong>Eileen Sideways</strong>
                                        <small>Los Angeles, CA</small>
                                    </div>
                                </div><!-- media -->
                            </li>
                            <li>
                                <div class="media">
                                    <a href="#" class="pull-left media-thumb">
                                        <img alt="" src="images/photos/user2.png" class="media-object">
                                    </a>
                                    <div class="media-body">
                                        <strong>Zaham Sindilmaca</strong>
                                        <small>San Francisco, CA</small>
                                    </div>
                                </div><!-- media -->
                            </li>
                            <li>
                                <div class="media">
                                    <a href="#" class="pull-left media-thumb">
                                        <img alt="" src="images/photos/user3.png" class="media-object">
                                    </a>
                                    <div class="media-body">
                                        <strong>Nusja Nawancali</strong>
                                        <small>Bangkok, Thailand</small>
                                    </div>
                                </div><!-- media -->
                            </li>
                            <li>
                                <div class="media">
                                    <a href="#" class="pull-left media-thumb">
                                        <img alt="" src="images/photos/user4.png" class="media-object">
                                    </a>
                                    <div class="media-body">
                                        <strong>Renov Leongal</strong>
                                        <small>Cebu City, Philippines</small>
                                    </div>
                                </div><!-- media -->
                            </li>
                            <li>
                                <div class="media">
                                    <a href="#" class="pull-left media-thumb">
                                        <img alt="" src="images/photos/user5.png" class="media-object">
                                    </a>
                                    <div class="media-body">
                                        <strong>Weno Carasbong</strong>
                                        <small>Tokyo, Japan</small>
                                    </div>
                                </div><!-- media -->
                            </li>
                            <li>
                                <div class="media">
                                    <a href="#" class="pull-left media-thumb">
                                        <img alt="" src="images/photos/user4.png" class="media-object">
                                    </a>
                                    <div class="media-body">
                                        <strong>Renov Leongal</strong>
                                        <small>Cebu City, Philippines</small>
                                    </div>
                                </div><!-- media -->
                            </li>
                            <li>
                                <div class="media">
                                    <a href="#" class="pull-left media-thumb">
                                        <img alt="" src="images/photos/user5.png" class="media-object">
                                    </a>
                                    <div class="media-body">
                                        <strong>Weno Carasbong</strong>
                                        <small>Tokyo, Japan</small>
                                    </div>
                                </div><!-- media -->
                            </li>
                        </ul>
                    </div>

                </div><!-- tab-content -->
            </div><!-- rightpanel -->


        </section>


        <script src="js/jquery-1.10.2.min.js"></script>
        <script src="js/jquery-migrate-1.2.1.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/modernizr.min.js"></script>
        <script src="js/easing.js"></script>
        <script src="js/jquery.sparkline.min.js"></script>
        <script src="js/toggles.min.js"></script>
        <script src="js/retina.min.js"></script>
        <script src="js/jquery.cookies.js"></script>

        <script src="js/flot/flot.min.js"></script>
        <script src="js/flot/flot.resize.min.js"></script>
        <script src="js/morris.min.js"></script>
        <script src="js/raphael-2.1.0.min.js"></script>

        <script src="js/chosen.jquery.min.js"></script>

        <script src="js/custom.js"></script>

    </body>
</html>
