
<div class="contentpanel"><!-- Content Panel -->

    <div class="row mb20"><!-- Exhibitor Row -->

        <div class="col-sm-12 col-md-12">
            <button class="btn btn-success btn-block" onclick="window.location = '<?php echo base_url('manage/speaker/add/' . $this->event_id); ?>'">Add Speaker</button>
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
                    <div class="ckbox ckbox-default">
                        <input type="submit" name="send_mail" value="Send Mail" class="btn btn-default">
                    </div>
                </li>
                <li>
                    <div class="ckbox ckbox-default">
                        <input type="submit" name="by_pass_passcode" value="By Pass Passcode" class="btn btn-default">
                    </div>
                </li>
                <li>
                    <a href="#" class="itemopt disabled" id="delete-item"><i class="fa fa-trash-o"></i> Delete</a>
                </li>



                <li>
                    <div class="ckbox ckbox-default">
                        <select type="select" id="sort-list" class="form-control">
                            <option > Sort By </option>
                            <option value="<?php echo base_url('manage/speaker/0'); ?>">A - Z</option>
                            <option value="<?php echo base_url('manage/speaker/1'); ?>">Z - A</option>
                            <option value="<?php echo base_url('manage/speaker/2'); ?>">Featured First</option>
                            <option value="<?php echo base_url('manage/speaker/3'); ?>">Mail not sent</option>
                            <option value="<?php echo base_url('manage/speaker/4'); ?>">Mail sent</option>
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
                        <input type="text" name="search" style="display: inline;" class="search-button form-control" placeholder="Search">
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
    <?php if (!empty($list)) {  //echo '<pre>'; print_r($list); ?>
        <div class="row">
            <div class="col-sm-12 col-md-12">
                <div class="table-responsive">
                    <table class="table mb30">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Photo</th>
                                <th>Event Name</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Company</th>
                                <th>City</th>
                                <th>Phone #</th>
                                <th>Passcode</th>
                                <th>Status (E/D)</th>
                                <th>Mail sent (Y/N)?</th>
                                <th>&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
//                            display($list);
                            foreach ($list as $speaker) {
                                ?>
                                <tr>
                                    <td class="text-center tdalign">
                                        <input type="checkbox" name="delete[]" class="checkboxes-custom" value="<?php echo $speaker["attendee_id"]; ?>">
                                    </td>
                                    <td class="tdalign">
                                        <?php
                                        if ($speaker['photo'] != '') {
                                            $img = base_url() . "uploads/speaker/" . $speaker['photo'];
                                        } else {
                                            $img = base_url() . 'uploads/organizer_logo.png';
                                        }
                                        ?>
                                        <img width="30" height="30" src="<?php echo $img; ?>" /></td> 
                                    <td class="tdalign"><?php echo $speaker["event_name"]; ?></td>
                                    <td class="tdalign"><?php echo $speaker["first_name"]; ?> </td>
                                    <td class="tdalign"><?php echo $speaker["last_name"]; ?> </td>
                                    <td><?php echo $speaker["company_name"]; ?></td>
                                    <td><?php echo $speaker["city"]; ?></td>
                                    <td> <?php echo $speaker["mobile"]; ?></td>
                                    <td> <?php echo $speaker["passcode"]; ?></td>

                                    <td class="tdalign"><?php echo ($speaker['speaker_status'] == 1) ? 'E' : 'D'; ?></td>
                                    <td class="tdalign"><?php echo ($speaker['mail_sent'] == 1) ? 'Y' : 'N'; ?></td>
                                    <td class="table-action tdalign tdwdth130">

                                        <a title="Edit" href="<?php echo base_url(); ?>manage/speaker/edit/<?php echo $speaker["attendee_id"]; ?>"><i class="fa fa-pencil"></i></a>
                                        <a title="Delete" href="#" data="<?php echo $speaker["attendee_id"]; ?>" class="delete-row"><i class="fa fa-trash-o"></i></a>
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
        echo 'No Speakers Present';
    }

    echo form_close();
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
    delete_url = '<?php echo base_url('manage/speaker/delete/json'); ?>'
</script>
