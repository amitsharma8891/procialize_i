<?php
//    echo date('Y-m-d h:i:s');
?>
<div class="contentpanel"><!-- Content Panel -->

   <!-- <p class="mb20">Drag & drop events from right to left. Double click on it to delete.</p>-->
    <div class="row">

        <?php if (empty($tracks)) { ?>
            No track Added.<a href="javascript:void(0)" class="add-track" />Click here</a> to add a track
        <?php } else { ?>


            <div class="col-sm-10">
                <div class="btn-toolbar" role="toolbar">
                    <?php foreach ($tracks as $track) { ?>
                        <form method="POST" action="" name="tracks">
                            <div class="btn-group">
                                <button type="submit" class="btn btn-default <?php echo ($track_selected == $track['id']) ? 'track_selected' : ''; ?>" id="track_<?php echo $track['id'] ?>"><?php echo $track['name'] ?></button>
                                <input type="hidden" name="track_id" value="<?php echo $track['id'] ?>" >
                                <button type="button" class="btn btn-default delete-track" id="<?php echo $track['id'] ?>"><i class="fa fa-times text-danger"></i></button>
                            </div>
                        </form>

                    <?php } ?>
                </div>
            </div>



            <div class="col-sm-2 pull-right">
                <span class="add-track btn btn-success pull-right">Add New Track</span>
            </div>

        </div>

        <div class="row mb10">
            <div class="col-sm-4 mr20">
            </div>
            <div class="col-sm-2">
                <form method="POST" action="" name="prev_form"  class="" >
                    <button type="submit" value="prev" name="prev" class="btn btn-primary btn-block"> <i class="fa fa-arrow-left mr10"></i> Previous Day </button>
                    <input type="hidden" name="prev_date" value="<?php echo $prev ?>" />
                </form>
            </div>
            <div class="col-sm-2">
                <form method="POST" action="" name="next_form"  class="" >
                    <button type="submit" value="next" name="next" class="btn btn-primary btn-block">Next Day <i class="fa fa-arrow-right ml10"></i></button>
                    <input type="hidden" name="next_date" value="<?php echo $next ?>" />
                </form>
            </div>

            <div class="col-sm-3">
            </div>

        </div>

        <div class="row">
            <div class="col-md-12">

                <div id="calendar"></div>
            <?php } ?>

        </div>
    </div>

</div><!-- contentpanel -->

<script>
    var event_id = <?php echo (isset($this->event_id)) ? $this->event_id : '""'; ?>;
    var track_id = <?php echo isset($track_selected) ? $track_selected : '""'; ?>;
    var events = <?php echo json_encode($events); ?>
</script>

<button data-toggle="modal" id="display-session-pop" data-target="#add-session"></button>
<div class="modal fade" id="add-session" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <form action ="<?php echo base_url('manage/agenda/addSession'); ?>" id="session_create_form" method="POST" enctype="multipart/form-data">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title session-popup-title" id="myModalLabel">Add Session</h4>
                    <h4 id="start-end-date"></h4>

                </div>
                <div class="modal-body">

                    <div class="row mb10">

                        <div class="col-sm-6">
                            <input type="text" class="form-control validate[required]" name="session_title" placeholder="Session Title" id="session_title">
                        </div>
                        <div class="col-sm-3">
                            <input type="hidden" name="session_start"  id="session_start"/>
                            <input type="hidden" name="session_end" id="session_end" />
                            <input type="hidden" name="session_startF"  id="session_startF"/>
                            <input type="hidden" name="session_endF" id="session_endF" />
                            <input type="hidden" name="all_day" id="all_day" />
                        </div>
                    </div>


                    <div class="row mb10">
                        <div class="col-sm-12">
                            <textarea name="session_des" id="session_des"  rows="6" class="form-control  validate[required]" placeholder="Write text for the post to be displayed in the session description"></textarea>
                        </div>
                    </div>

                    <div class="row mb10">
                        <div class="col-sm-12">
                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                <a href="#" title="remove" class="closebtn fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i></a>
                                <div class="fileinput-preview thumbnail" data-trigger="fileinput" style="max-width: 100%; max-height: 80px;">
                                    <img src="http://placehold.it/106x64" alt="" class="img-responsive aimg session-image">
                                </div>
                                <span class="btn btn-default btn-file">
                                    <span class="fileinput-new">Session Profile</span>
                                    <span class="fileinput-exists">Change Session Profile</span>
                                    <input type="file" name="upload" value="" id="logo" class="form-control" placeholder="Logo" validate="" error="Logo">
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="row mb10">
                        <div class="col-sm-12">
                            <?php echo form_dropdown('speaker_id[]', $speakers, '', 'class="form-control chosen-select" data-placeholder="Speakers"  id="speaker_id" multiple'); ?>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <input type="hidden" id="id" name="session_id" /> 
                            <input type="hidden" value="<?php echo $track_selected; ?>" id="track_id" name="track_id" /> 
                            <input type="submit" class="btn btn-success btn-block" id="add-session-popUP1" value="Add">
                        </div>
                    </div>

                </div>
                <div id="session-popup-footer"></div>
            </div>
        </div>
    </form>
</div>
