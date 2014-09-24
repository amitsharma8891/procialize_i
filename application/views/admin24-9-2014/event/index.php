<div class="contentpanel"><!-- Content Panel -->
    <div class="row mb20"><!-- Exhibitor Row -->

        <div class="col-sm-12 col-md-12">
            <button class="btn btn-success btn-block" onclick="window.location = '<?php echo base_url('manage/event/add'); ?>'">Add Event</button>
        </div>
        <!--        <div class="col-sm-6 col-md-6">
                    <button class="btn btn-success btn-block" data-toggle="modal" data-target="#import">Import Exhibitors - xls/csv</button>
                </div>-->

    </div>
    <?php echo form_open('', array('id' => 'list-form', 'name' => 'list-form')); ?>
    <div class="row mb10"><!-- Add Exhibitor Row -->

        <div class="col-sm-12 col-md-12">
            <ul class="filemanager-options">
                <li>
                    <div class="ckbox ckbox-default">
                        <input type="checkbox" id="selectall" class="group-checkable-custom" value="1" />
                        <label for="selectall">Select All</label>
                    </div>
                </li>
                <li>
                    <a href="#" class="itemopt disabled" id="delete-item"><i class="fa fa-trash-o"></i> Delete</a>
                </li>


                <li>
                    <div class="ckbox ckbox-default">
                        <select type="select" id="sort-list" class="form-control">
                            <option value="">Sort By</option>
                            <option value="<?php echo base_url('manage/event/0'); ?>">A - Z</option>
                            <option value="<?php echo base_url('manage/event/1'); ?>">Z - A</option>
                        </select>
                    </div>
                </li>

                <li>
                    <div class="ckbox ckbox-default">
                        <?php echo form_dropdown('organizer_drpdown', $Organizer_dropdown, '', 'class="form-control" id="filter_drpdown"'); ?>
                    </div>
                </li>
				
				
                <li>
                    <div class="ckbox ckbox-default">
                        <input type="text" name="Search" class="search-button form-control" style="display: inline" placeholder="Search">
                    </div>
                </li>

                <li>
                    <div class="ckbox ckbox-default">
                        <input type="submit" value="Search"  class="btn btn-default">
                    </div>
                </li>
            </ul>   
        </div>
    </div>
<?php if (!empty($list)) { 
    ?>
    <div class="row">
        <div class="col-sm-12 col-md-12">
            <div class="table-responsive">
                <table class="table mb30 text-center">
                    <thead>
                        <tr>
                            <th></th>
                            <th class="text-center">Featured?</th>
                            <th class="text-center">Logo</th>
                            <th class="text-center">Organizer Name</th>
                            <th class="text-center">Event Name</th>
                            <th class="text-center">Event City</th>
                            <th class="text-center">Contact Name</th>
                            <th class="text-center">Contact Phone #</th>
                            <th class="text-center">Status (E/D)</th>
							<th>&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
						// echo IMAGE_BASEPATH.'/'.UPLOAD_EVENT_LOGO_DISPLAY ; 
					  //echo '<pre>'; print_r($list[0]['logo']); 
						
						foreach ($list as $event): ?>
                            <tr>
                                <td class="text-center tdalign">
                                    <input type="checkbox" name="delete[]" class="checkboxes-custom" value="<?php echo $event['event_id']; ?>">
                                </td>
                                <td><?php echo ($event['is_featured'] != 0) ? anchor('#', '<i class="fa fa-certificate fa-lg"></i>') : '<i class="fa fa-certificate fa-lg"></i>'; ?></td>
                                <td>
                                    <?php 
                                    //if (file_exists(IMAGE_BASEPATH . UPLOAD_EXHIBITOR_LOGO . $event['logo']))
                                       // echo base_url(UPLOAD_EXHIBITOR_LOGO . $event['logo']);
                                    if($event['logo'] != '') { ?>
                                        <img src=" <?php echo base_url(UPLOAD_EVENT_LOGO_DISPLAY.$event['logo']);
                                    ?>" width="30px" height="30px" title="Event Logo" alt="">
                                    <?php } else { ?>
                                       <img src=" <?php echo base_url('uploads/events/logo/event-logo.png');
                                    ?>" width="30px" height="30px" title="Event Logo" alt="">
                                    <?php } ?>
                                        
									
                               <!-- <img width="35px" height="35px" src='<?php echo base_url() ?>/<?php echo UPLOAD_EVENT_LOGO_DISPLAY ?><?php echo ($event['logo'] == '') ? 'logo.png' : $event['logo']; ?> ' />--> </td>  
                                <td class="tdalign"><?php echo $event['organizer_name']; ?></td>
                                <td class="tdalign"><?php echo $event['name'] ?></td>
                                <td class="tdalign"><?php echo $event['city'] ?></td>
                                <td class="tdalign"><?php echo $event['contact_name']; ?></td>
                                <td class="tdalign"><?php echo $event['contact_mobile']; ?></td>
                                <td class="tdalign"><?php echo ($event['status'] == 1)?'E':'D'; ?></td>
                                <td class="table-action tdalign tdwdth130">

                                    <a title="Edit" href="<?php echo base_url('manage/event/edit/' . $event['event_id']); ?>"><i class="fa fa-pencil"></i></a>
                                    <a title="Delete" href="#" data="<?php echo $event['event_id']; ?>" class="delete-row"><i class="fa fa-trash-o"></i></a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div><!-- table-responsive -->
        </div>
    </div>
    <?php
    } else {
        echo 'No Events Present';
    }
    ?>
    <!-- Import xls/csv -->
    <div class="modal fade" id="import" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Import Exhibitors - xls/csv</h4>
                </div>
                <div class="modal-body">
                    <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem
                        aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo
                        enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui
                        ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur,
                        adipisci velit.</p>

                    <div class="row mb10">
                        <div class="col-sm-6">
                            <div class="fileupload fileupload-new" data-provides="fileupload">
                                <div class="input-append">
                                    <div class="uneditable-input">
                                        <i class="glyphicon glyphicon-file fileupload-exists"></i>
                                        <span class="fileupload-preview"></span>
                                    </div>
                                    <span class="btn btn-default btn-file">
                                        <span class="fileupload-new">Browse</span>
                                        <span class="fileupload-exists">Change</span>
                                        <input type="file" />
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6">
                            <button type="button" class="btn btn-primary btn-block">Download Sample File</button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 col-md-6">
                            <button type="button" class="btn btn-success btn-block">Upload with over-right</button>
                        </div>
                        <div class="col-sm-6 col-md-6">
                            <button type="button" class="btn btn-success btn-block">Upload</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<?php echo form_close(); ?>
<script>
                delete_url = '<?php echo base_url('manage/event/delete/json'); ?>';
</script>
