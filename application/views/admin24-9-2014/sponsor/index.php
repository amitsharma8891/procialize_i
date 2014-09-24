
<div class="contentpanel"><!-- Content Panel -->

    <div class="row mb20"><!-- Exhibitor Row -->

        <div class="col-sm-12 col-md-12">
            <button class="btn btn-success btn-block" onclick="window.location = '<?php echo base_url('manage/sponsor/add/' . $this->event_id); ?>'">Add Sponsor</button>
        </div>
        <!-- <div class="col-sm-6 col-md-6">
                <button class="btn btn-success btn-block" data-toggle="modal" data-target="#import">Import Exhibitors - xls/csv</button>
        </div> -->

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
                            <option value="<?php echo base_url('manage/sponsor/0'); ?>">A - Z</option>
                            <option value="<?php echo base_url('manage/sponsor/1'); ?>">Z - A</option>

                        </select>
                    </div>
                </li>
                <li>
                    <div class="ckbox ckbox-default">
                        <?php echo form_dropdown('event_drpdown', $event_dropdown, '', 'class="form-control" id="filter_drpdown"'); ?>
                    </div>
                </li>

                <li>
                    <div class="ckbox ckbox-default">
                        <input type="text" name="search" class="search-button form-control" placeholder="Search">
                    </div>
                </li>

                <li>
                    <div class="ckbox ckbox-default">
                        <input type="submit" value="Search" class="btn btn-default">
                    </div>
                </li>

            </ul>	
        </div>
    </div>
    <?php //echo '<pre>'; print_r($list); exit;
    if (!empty($list)) { ?>
        <div class="row">
            <div class="col-sm-12 col-md-12">
                <div class="table-responsive">
                    <table class="table mb30">
                        <thead>
                            <tr class="text-center">
                                <th> &nbsp;</th>

                                <th  >Event Name</th>
                                <th  >Company Name</th>
                                <th  >Contact Name</th>
                                <th  >Contact Phone #</th>
                                <th  >Status (E/D)</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php // print_r($list);
                            foreach ($list as $sponsor) {
                                ?>
                                <tr>
                                    <td class="text-center tdalign"><input type="checkbox" name="delete[]" class="checkboxes-custom" value="<?php echo $sponsor["id"]; ?>"></td>

           <!--<td><img src="<?php echo base_url(UPLOAD_EXHIBITOR_LOGO_DISPLAY . $sponsor['logo']) ?>" width="20px" height="20px" title="Sponsor's Logo" alt=""> </td>  -->
                                    <td class="tdalign"><?php echo $sponsor["event_name"]; ?> </td>
                                    <td class="tdalign"><?php echo $sponsor["sponser_name"]; ?> </td>
                                    <td class="tdalign"><?php echo $sponsor["contact_person_name"]; ?> </td>
                                    <td class="tdalign"><?php echo $sponsor["contact_mobile_number"]; ?> </td>
                                    <td class="tdalign"><?php echo ($sponsor['status'] == 1) ? 'E' : 'D'; ?></td>

                                    <td class="table-action tdalign">
                                        <!-- <a title="User" href="#"><i class="fa fa-user"></i></a> -->
                                        
                                        <a title="Edit" href="<?php echo base_url(); ?>manage/sponsor/edit/<?php echo $sponsor["id"]; ?>"><i class="fa fa-pencil"></i></a>
                                        <a title="Delete" href="#" data="<?php echo $sponsor["id"]; ?>" class="delete-row"><i class="fa fa-trash-o"></i></a>
                                    </td>
                                </tr>
    <?php } ?>

                        </tbody>
                    </table>
                </div><!-- table-responsive -->
            </div>
        </div>
        <?php
    } else {
        echo 'No Sponsors Present';
    }
    ?>

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
                            <button type="button" class="btn btn-primary btn-block">Upload with over-right</button>
                        </div>
                        <div class="col-sm-6 col-md-6">
                            <button type="button" class="btn btn-primary btn-block">Upload</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
                delete_url = '<?php echo base_url('manage/sponsor/delete/json'); ?>'
</script>