<div class="logopanel">
    <img src="<?php echo SITE_URL . 'uploads/app_logo/' . getSetting()->app_logo_big ?>" height="30"/>
</div><!-- logopanel -->

<div class="leftpanelinner mt10">    

    <!-- This is only visible to small devices -->
    <div class="visible-xs hidden-sm hidden-md hidden-lg">   
        <div class="media userlogged">
            <!--<img alt="" src="images/photos/loggeduser.png" class="media-object">-->
            <div class="media-body">
                <h4>Admin</h4>
                <span>"Life is so..."</span>
            </div>
        </div>

        <h5 class="sidebartitle actitle">Account</h5>
        <ul class="nav nav-pills nav-stacked nav-bracket mb30">
            <li><a href="profile.html"><i class="fa fa-user"></i> <span>Edit Profile</span></a></li>
            <li><a href="#"><i class="fa fa-cog"></i> <span>Account Settings</span></a></li>
            <li><a href="#"><i class="fa fa-question-circle"></i> <span>Help</span></a></li>
            <li><a href="signout.html"><i class="fa fa-sign-out"></i> <span>Sign Out</span></a></li>
        </ul>
    </div>

    <ul class="nav nav-pills nav-stacked nav-bracket">
        <?php
//        display($this->session->all_userdata());
        $type = $this->session->userdata('type_of_user');
        $superadmin = $this->session->userdata('is_superadmin');
        $user_id = $this->session->userdata('user_id');
        $Pid = $this->session->userdata('id');
//        print_r($this->session->all_userdata());exit;
        $arrMenus = array();
        $arrEvents = array();
//        $superadmin = false;
        $arrMenus = generateMenu($type, $superadmin);
        $arrEvents = getEvents($user_id, $superadmin, $type);
        ?>
        <?php
//        display($arrEvents);
//        show_query();
        $arrSkipArrow = array('exhibitor profile', 'Profile', 'Announcement', 'Survey', 'Dashboard', 'Survey', 'Industry', 'Functionality', 'Tag','Email Template');
        if (!$superadmin) {
            $i = 0;
            if (count($arrEvents) > 0) {
                setcookie("event_id",$arrEvents[0]['event_id'],time() + 3600 * 3600,'/');
            }
            
            foreach ($arrEvents as $event) {
                $i++;
                ?>
                <li class="nav-parent <?php echo (get_cookie('event_id') == $event['event_id']) ? 'nav-active' : '' ?>"><a href="#"><i class="fa fa-folder"></i> <?php echo $event['name']; ?> <span> </span></a>
                    <ul class="children" style="display: <?php echo (get_cookie('event_id') == $event['event_id']) ? 'block' : 'none' ?>;">
        <?php foreach ($arrMenus as $url => $menu) {
            ?>
                            <li class="sub-menu <?php echo (get_cookie('menu_name') == ucwords(strtolower($menu))) ? 'active' : '' ?>" data="<?php echo $event['event_id'] ?>">

                                <a
                                    data="<?php echo ucwords(strtolower($menu)) ?>"
            <?php echo ($menu == 'Announcement') ? 'data-target="#compose" data-toggle="modal"' : ''; ?>   
                                    href='<?php
//                                $event_id = $event["event_id"];

                                    if ($url == 'manage/event/edit/')
                                        echo base_url("$url" . $event['event_id']);
                                    elseif ($menu == 'Announcement')
                                        echo '#';
                                    else
                                        echo base_url("$url");
                                    ?>'><i class="fa fa-caret-right"></i> <?php
                                    if ($menu == 'index')
                                        $menu = 'dashboard';
                                    echo ucwords(strtolower($menu))
                                    ?></a>
                                    <?php
                                    if ($type == 'E' && $menu == 'exhibitor profile') {
                                        echo getProfileStatus($Pid);
                                    }
                                    ?>

                            </li>
            <?php if (!in_array($menu, $arrSkipArrow)) { ?>    
                                <span class="fa fa-arrow-down"></span>
                                <?php
                            }
                        }
                        ?>
                    </ul>
                </li>

        <?php
    }
} else {
    $arrHeader = array('Admin Menu', 'Master Data');
    ?>
            <?php
            $first = true;

            $arrSkipArrow = array('Exhibitor Profile', 'Announcement', 'Survey', 'Dashboard', 'Survey', 'Industry', 'Functionality', 'Tag','Email Template');

            //  print_r($arrMenus);exit;
            foreach ($arrHeader as $header) {
                ?>
                <li class="nav-parent nav-active"><a href="#"><i class="fa fa-folder"></i> <?php echo $header; ?> <span> </span></a>
                    <ul class="children" style="display: block;">
        <?php
        $i = 0;
        foreach ($arrMenus as $url => $menu) {
            $i++;
            if ($i == 9 && $first == true) {
                $first = false;
                break;
            }
            if ($i < 9 && $first == false)
                continue;
            ?>
                            <li class="sub-menu <?php echo (get_cookie('menu_name') == ucwords(strtolower($menu))) ? 'active' : '' ?>"   >
                                <a
                                    data="<?php echo ucwords(strtolower($menu)) ?>"
                                    href='<?php
                $event_id = '';
                echo base_url("$url/$event_id")
            ?>'><i class="fa fa-caret-right"></i> <?php
                                    if ($menu == 'index')
                                        $menu = 'dashboard';

                                    echo ucwords(strtolower($menu))
                                    ?></a></li>
                                    <?php if (!in_array(ucwords(strtolower($menu)), $arrSkipArrow)) { ?>    
                                <span class="fa fa-arrow-down"></span>
                            <?php }
                            ?>
                            <?php
                        }
                        ?>
                    </ul>
                </li>
    <?php } ?>


<?php } ?>
    </ul>

</div><!-- leftpanelinner -->