<!-- Header Left -->
<script>
    var events = {};
</script>
<a class="menutoggle"><i class="fa fa-bars"></i></a>


<!-- Header Right -->

<div class="header-right">
    <ul class="headermenu">
        <li>

        </li>
        <!--        <li> Notifications 
                    <div class="btn-group">
                        <button class="btn btn-default dropdown-toggle tp-icon notificationSection" data-toggle="dropdown">
                            <i class="glyphicon glyphicon-globe"></i>
                            <span class="badge notificationCount">0</span>
                        </button>
                        <div class="dropdown-menu dropdown-menu-head pull-right notificationSection_main">
                            <h5 class="title">You Have 6 New Notifications</h5>
                            <ul class="dropdown-list gen-list">
                                <li class="new">
                                    <a href="#">
                                        <span class="thumb"><img src="images/photos/user4.png" alt="" /></span>
                                        <span class="desc">
                                            <span class="name">Harikrishna Nair <span class="badge badge-success">new</span></span>
                                            <span class="msg">is now following you</span>
                                        </span>
                                    </a>
                                </li>
                                <li class="new">
                                    <a href="#">
                                        <span class="thumb">
                                            <img src="images/photos/user5.png" alt="" />
                                        </span>
                                        <span class="desc">
                                            <span class="name">Vivek Gholap <span class="badge badge-success">new</span></span>
                                            <span class="msg">is now following you</span>
                                        </span>
                                    </a>
                                </li>
                                <li class="new">
                                    <a href="#">
                                        <span class="thumb"><img src="images/photos/user3.png" alt="" /></span>
                                        <span class="desc">
                                            <span class="name">Pathik Bhatt <span class="badge badge-success">new</span></span>
                                            <span class="msg">likes your recent status</span>
                                        </span>
                                    </a>
                                </li>
                                <li class="new">
                                    <a href="#">
                                        <span class="thumb"><img src="images/photos/user3.png" alt="" /></span>
                                        <span class="desc">
                                            <span class="name">Jigar Shah <span class="badge badge-success">new</span></span>
                                            <span class="msg">downloaded your work</span>
                                        </span>
                                    </a>
                                </li>
                                <li class="new">
                                    <a href="#">
                                        <span class="thumb"><img src="images/photos/user3.png" alt="" /></span>
                                        <span class="desc">
                                            <span class="name">Chintan Lad <span class="badge badge-success">new</span></span>
                                            <span class="msg">send you 2 messages</span>
                                        </span>
                                    </a>
                                </li>
                                <li class="new"><a href="#">See All Notifications</a></li>
                            </ul>
                        </div>
                    </div>
                </li>-->

        <li><!-- User Account -->
            <div class="btn-group">
                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                    <?php // echo $this->session->userdata('logo') ?>
                    <img src="<?php echo $this->session->userdata('logo') ?>" alt="" />
                    <?php
                    $username = $this->session->userdata('username');
                    $first_name = $this->session->userdata('first_name');
                    echo ($username != '') ? $username : $first_name;
                    ?>
                    <span class="caret"></span>
                </button>
                <?php
                $url = '#';
//                echo '<pre>';print_r($this->session->all_userdata());exit;
                $type = $this->session->userdata('type_of_user');
                $id = $this->session->userdata('id');
                switch ($type) {
                    case 'O':
                        $url = base_url() . 'manage/organizer/add_edit/' . $id;
                        break;
                    case 'E':
                        $url = base_url() . 'manage/exhibitor/edit/' . $id;
                        break;
                }
                $setting_url = base_url() . 'manage/setting/';
                $is_superadmin = $this->session->userdata('is_superadmin');
                if ($is_superadmin) {
                    $url = base_url() . 'manage/user/edit_profile/' . $id;
                }
                ?>
                <ul class="dropdown-menu dropdown-menu-usermenu pull-right">
                    <?php
                    get_cookie('logged_in_id');
                    $type = $this->session->userdata('type_of_user');
//                    echo $superadmin = $this->session->userdata('is_superadmin');
                    $user_id = $this->session->userdata('user_id');
                    if ($user_id != get_cookie('logged_in_id')) {
//                            
                        ?>

                        <li><a href="<?php echo base_url() ?>manage/login/adminLogin/<?php echo get_cookie('logged_in_type') ?>/<?php echo get_cookie('logged_in_id'); ?>" onClick="return confirm('Are you want to login with this user??')"><i class="glyphicon glyphicon-cog"></i> Login back to previous account</a></li>
                    <?php }
                    ?>
                    <li><a href="<?php echo $url ?>"><i class="glyphicon glyphicon-user"></i> Edit Profile</a></li>
                    <li><a href="<?php echo $setting_url ?>"><i class="glyphicon glyphicon-cog"></i> App Setting</a></li> 
                    <li><a href="#" data-target="#help" data-toggle="modal"><i class="glyphicon glyphicon-question-sign"></i> Help</a></li>
                    <?php if ($type != 'E'){  ?>
                    <li><a href="#" data-target="#tour" data-toggle="modal"><i class="glyphicon glyphicon-question-sign"></i> Tour</a></li>
                    <?php } ?>
                    <li><a href="<?php echo base_url('manage/login/logout'); ?>"><i class="glyphicon glyphicon-log-out"></i> Log Out</a></li>
                </ul>
            </div>
        </li>

        <li><!-- Right Panel -->
            <button id="chatview" class="btn btn-default tp-icon chat-icon">
                <i class="fa fa-arrow-left"></i>
            </button>
        </li>
    </ul>
</div><!-- header-right -->


<script id="notification_content" type="text/template">
    <% if (content.length > 0) { %>
    <% for (i = 0; i < content.length;
    i++
    ) { %>
    <ul class = "dropdown-list gen-list" >
    <li class = "new" >
    <a href = "#" >
    <span class = "desc" >
    <span class = "name " > <%= content[i].content %> </span>
    <% if (content[i].type == "O") { %>
    <span class = "msg" > Offer from <%= content[i].name %> ( <%= content[i].user %> ) </span>
    <% } else if (content[i].type == "S"){ %>
    <span class = "msg" > Surevy from <%= content[i].name %> (<%= content[i].user %>) </span>
    <% } else{ %>
    <span class = "msg" ><%= content[i].name %> ( <%= content[i].user %> ) </span>        
    <% } %>
    <span class = "date" > <%= content[i].display_time %> , <%= content[i].event_name %> </span>
    </span>
    </a>
    </li>
    </ul>
    <% } %>
    <% } else{ %>
    <div class = 'fullWidth' >
    No
    Notification.
    </div>
    <% } %>
</script>


<script id="event_template" type="text/template">

    <div class="preview_21">
    <div class="panel panel-default panel-stat-preview ">
    <div>
    <div class="row">
    <div class="col-xs-12 preview_event" >
    <div class="stat well well-sm">
    <div class="row">
    <div class="col-xs-4">
    <div class="preview_thumb"> <img src="<%= content.event_logo %> " alt="" class="img-responsive preview_userlogo"/> </div>
    </div>
    <div class="col-xs-5 preview_eventdet">
    <h4><%=  content.event_date %></h4>
    <small class="stat-label"><%=  content.event_city %>,<%=  content.event_country %></small>
    <small class="stat-label"><%= content.event_ind_fun %></small> </div>
    <div class="col-xs-3">  <small class="stat-label">
    <div class="preview_thumb"> <img src="<%=content.org_logo %>" class="img-responsive userlogor" /> </div>
    </small> </div>
    </div>
    <!-- row -->

    <h4 class="tits"><%= content.event_name %></h4>
    <hr class="preview_mb9">
    <img src="<%= content.comman_connection %>" class="img-responsive">
    <address class="preview_address">
    <strong>Venue:</strong> <%=  content.event_location %><br>
    <strong>Email:</strong> <%= content.event_email %><br>
    <a href="#" target="_blank" class="preview_a"><strong>Website:</strong> <%= content.event_website %></a><br>
    </address>
    <a class="btn btn-success input-sm btn-block preview_mb9" >Download Event Map</a>
    <ul class="list-inline mb5">
    <li><a href="#"><img class="img-responsive" src="<%= content.event_img1 %>"></a></li>
    <li><a href="#"><img class="img-responsive" src="<%= content.event_img2 %>"></a></li>
    <li><a href="#"><img class="img-responsive" src="<%= content.event_img3 %>"></a></li>
    </ul>
    <p class="text-justify"><%= content.event_description %></p>
    <!---google map integrations----> 


    <!---google map integrations ends---->
    <div class="mb5" style="border:1px solid rgba(0,0,0,0.4); border-radius: 4px; height: 180px" id="map-canvas"></div>
    </div>
    <!-- stat -->  
    </div>
    <!-- col-sm-6 --> 

    </div>
    <!-- row --> 
    </div>
    </div>
    </div>

</script>
