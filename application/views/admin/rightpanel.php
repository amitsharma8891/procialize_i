<!-- Nav tabs -->
<ul class="nav nav-tabs nav-justified">
    <li class="active"><a href="#rp-links" data-toggle="tab"><i class="fa fa-link"></i></a></li>
    <!--<li><a href="#rp-notepad" data-toggle="tab"><i class="fa fa-pencil-square-o"></i></a></li>-->
    <?php
    $type = $this->session->userdata('type_of_user');
    if ($type == 'E') {
        ?>
        <li><a href="#rp-updates" data-toggle="tab"><i class="fa fa-clock-o"></i></a></li>
<?php } ?>
</ul>

<!-- Tab panes -->
<div class="tab-content">
    <div class="tab-pane active" id="rp-links">
        <h5 class="sidebartitle">Quick Links</h5>
        <ul class="chatuserlist">
            <li class="online">
                <i class="fa fa-user"></i> <a href="<?php echo base_url('manage/attendee/quick'); ?>">Add Attendees</a>
            </li>

        </ul>
    </div>

    <?php
    if ($type == 'E') {
        ?>
        <div class="tab-pane" id="rp-updates">
            <h5 class="sidebartitle">Updates</h5>
            <ul class="chatuserlist">
                <?php
                $notifications = getNotification();

                foreach ($notifications as $notify) {
                    ?>
                    <li class="online">
                        <div class="media">
                            <a href="#" class="pull-left media-thumb">
                                <img alt="" src="<?php echo getProfilePic() ?>" class="media-object">
                            </a>
                            <div class="media-body">
        <?php echo $notify['content'] ?>
                            </div>
                        </div><!-- media -->
                    </li>
    <?php } ?>
            </ul>
        </div><!-- tab-pane -->
<?php } ?>
</div><!-- tab-content -->