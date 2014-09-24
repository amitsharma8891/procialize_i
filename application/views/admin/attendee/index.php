
<div class="contentpanel"><!-- Content Panel -->

    <div class="row mb20"><!-- Attendee Row -->
        <?php $superadmin = $this->session->userdata('is_superadmin'); ?>
        <?php if ($superadmin) { ?>

            <div class="col-sm-12 col-md-12">
                <button class="btn btn-success btn-block" onclick="window.location = '<?php echo base_url('manage/attendee/add/'); ?>'">Add Attendee</button>
            </div>

        <?php } else { ?>

            <div class="col-sm-6 col-md-6">
                <button class="btn btn-success btn-block" onclick="window.location = '<?php echo base_url('manage/attendee/add/'); ?>'">Add Attendee</button>
            </div>
            <div class="col-sm-6 col-md-6">
                <button class="btn btn-success btn-block" data-toggle="modal" data-target="#import">Import Attendees - csv</button>
            </div>
        <?php } ?>

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
                    <div class="ckbox ckbox-default">
                        <input type="submit" name="send_passcode" value="Send Mail" class="btn btn-default">
                    </div>
                </li>
                <li>
                    <a href="#" class="itemopt disabled" id="delete-item"><i class="fa fa-trash-o"></i> Delete</a>
                </li>



                <li>
                    <div class="ckbox ckbox-default">
                        <select type="select" id="sort-list" class="form-control">
                            <option > Sort By </option>
                            <option value="<?php echo base_url('manage/attendee/0'); ?>">A - Z</option>
                            <option value="<?php echo base_url('manage/attendee/1'); ?>">Z - A</option>
                            <option value="<?php echo base_url('manage/attendee/3'); ?>">Mail not sent</option>
                            <option value="<?php echo base_url('manage/attendee/4'); ?>">Mail sent</option>
                            <option value="<?php echo base_url('manage/attendee/5'); ?>">Approve</option>
                            <option value="<?php echo base_url('manage/attendee/6'); ?>">Not  Approve</option>


                        </select>
                    </div>
                </li>
                <li>
                    <div class="ckbox ckbox-default">
                        <?php echo form_dropdown('event_drpdown', $event_dropdown, $selected_event, 'class="form-control" id="filter_drpdown"'); ?>
                    </div>
                </li>

                <li>
                    <div class="ckbox ckbox-default">
                        <input type="text" name="search" class="search-button form-control" style="display: inline" placeholder="search">
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
    <?php if (!empty($list)) { //echo '<pre>'; print_r($list); ?>
        <div class="row">
            <div class="col-sm-12 col-md-12">
                <div class="table-responsive">
                    <table class="table mb30">
                        <thead>
                            <tr>
                                <th></th>
                                <th class="text-center" >Photo</th>
                                <th class="tdwdth25p text-center">Event Name</th>
                                <th class="text-center">First Name</th>
                                <th class="text-center">Last Name</th>
                                <th class="text-center">Company</th>
                                <th class="text-center">City</th>
                                <th class="text-center">Phone #</th>
                                <th class="text-center">Passcode</th>
                                <th class="text-center">Status (E/D)</th>
                                <th class="text-center">Paid (Y/N/NA)</th>
                                <th class="text-center">Approved (Y/N)</th>
                                <th class="text-center">Mail sent (Y/N)?</th>
                                <th>&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>


                            <?php
                            //	print_r($list);

                            foreach ($list as $attendee) {
                                ?>
                                <tr>
                                    <td class="text-center tdalign">
                                        <input type="checkbox" name="delete[]" class="checkboxes-custom" value="<?php echo $attendee["attendee_id"]; ?>">
                                    </td>
                                    <?php
                                    if ($attendee['photo'] != '') {
                                        $img = base_url() . "uploads/attendee/" . $attendee['photo'];
                                    } else {
                                        $img = base_url() . 'uploads/organizer_logo.png';
                                    }
                                    ?>
                                    <td class="tdalign text-center"><img width="30px" height="30px"  src='<?php echo $img; ?>' > </td>
                                    <td class="tdalign text-center"><?php echo $attendee["event_name"] ?></td>
                                    <td class="tdalign text-center"><?php echo $attendee["first_name"] ?></td>
                                    <td class="tdalign text-center"><?php echo $attendee["last_name"] ?> </td>
                                    <td class="tdalign text-center"><?php echo $attendee["company_name"] ?>  </td>
                                    <td class="tdalign text-center"><?php echo $attendee["city"] ?>  </td>
                                    <td class="tdalign text-center"><?php echo $attendee["mobile"] ?></td>
                                    <td class="tdalign text-center"><?php echo $attendee["passcode"] ?></td>
                                    <td class="tdalign text-center"><?php echo ($attendee['status'] == 1) ? 'E' : 'D'; ?></td>
                                    <td class="tdalign text-center"><?php echo ($attendee['event_paid_status'] == 1) ? 'Y' : 'N/A'; ?></td>
                                    <td class="tdalign text-center"><?php echo ($attendee['attendee_approve_status'] == 1) ? 'Y' : 'N'; ?></td>
                                    <td class="tdalign text-center"><?php echo ($attendee['event_mail_sent'] == 1) ? 'Y' : 'N'; ?></td>
                                    <td class="table-action tdalign tdwdth130">
                                        <a title="Edit" href="<?php echo base_url(); ?>manage/attendee/edit/<?php echo $attendee["attendee_id"]; ?>"><i class="fa fa-pencil"></i></a>
                                        <a title="Delete" href="#" data="<?php echo $attendee["attendee_id"]; ?>" class="delete-row"><i class="fa fa-trash-o"></i></a>
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
        echo 'No Attendees Present';
    }
    ?>
    <?php echo form_close() ?>
    <div class="modal fade bs-example-modal-lg in" id="import" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Import Attendee - csv</h4>
                </div>
                <div class="modal-body">
                    <?php echo form_open_multipart('manage/attendee/import/' . $this->event_id); ?>

                    <p>Use this facility to upload multiple Attendees in one go. Upload template can only be CSV (Comma Separated Values). Download sample template by clicking on the 'Download Sample File'. </p>

                    <p><b>Mandatory fields:</b> Attendee First Name, Email ID</p>

                    <p>Lets say from an upload file of 200 records, if only 150 are valid and 50 have issues, system will accept the valid 150 records and show appropriate errors for the 50 ones. You can fix the issues for those 50 records and then use the same 'Upload with over-write' facility (without removing valid 150 records from the file) to upload again. System will over-write the 150 valid records again without expecting users to remove them from the upload file. </p>

                    <p>Note: Upload may take some time if the record size if big.</p>

                    <p><strong>Sample Upload Time:</strong></p>

                    100 Records:<br>
                    500 Records:<br>
                    1000 Records: <br>

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
                                        <input type="file" name="file" />
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6">
                            <button onClick="OpenInNewTab('<?php echo base_url('manage/attendee/downloadSample') ?>');"  type="button" class="btn btn-success btn-block">Download Sample File</button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 col-md-12">
                            <button type="submit" class="btn btn-success btn-block">Upload with Overwrite</button>
                        </div>
                    </div>
                    <?php echo form_close() ?>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    delete_url = '<?php echo base_url('manage/attendee/delete/json'); ?>'
</script>
