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
                <button class="btn btn-success btn-block"id="event_preview" data-toggle="modal" data-target="#preview">Preview</button>
            </li>
        </ol>
    </div>

<?php } ?>
