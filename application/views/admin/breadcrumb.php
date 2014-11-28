<h2><i class="fa <?php echo (isset($breadcrumb_class)) ? $breadcrumb_class : ''; ?>"></i> 
    <?php echo $breadcrumb; ?> 
    <!--<span> <?php echo $breadcrumb_tag; ?></span>-->
</h2>
<!--		  <div class="breadcrumb-wrapper">
                        <ol class="breadcrumb">
                          <li>Create Organizer</li> 
                          <li class="active">Default Organizer</li>
                        </ol>
                  </div>-->

<?php if (isset($event_page)) { ?>
    <div class="breadcrumb-wrapper">
        <ol class="breadcrumb">
            <li>
                <button class="btn btn-success btn-block"id="event_preview" data-toggle="modal" data-target="#preview"> Preview</button>
            </li>

        </ol>
    </div>

<?php } ?>
<?php
if (isset($event_image_map)) {
    $image_map_result = get_event_map_image_id();
    $image_map_id = 0;
    if ($event_image_map_status) {
        $image_map_id = $image_map_result['id'];
    }
    ?>
    <style>
        .breadcrumb>li+li:before{content: no-close-quote !important; padding: 0px}
    </style>
    <div class="breadcrumb-wrapper">
        <ol class="breadcrumb">
            <?php if ($event_image_map_status) { ?>
                <li>
                    <a class="btn btn-success btn-block" href="<?php echo SITE_URL . 'manage/image_maping/map_exhibitor/' . $image_map_id; ?>" id="event_map" >Event Map </a>
                </li>
            <?php } ?>
            <li>
                <a class="btn btn-success btn-block"id="event_map_delete" href="<?php echo SITE_URL . 'manage/image_maping/delete/' . $image_map_id; ?>" onclick="return confirm('This action will delete the Event Map as well as any other Child Maps if you have associated already. Please confirm.')"> Delete</a>
            </li>

        </ol>
    </div>

<?php } ?>
