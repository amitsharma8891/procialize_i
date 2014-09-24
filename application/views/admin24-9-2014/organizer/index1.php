<?php ?>


<div class="contentpanel"><!-- Content Panel -->
    <div class="row mb20"><!-- Exhibitor Row -->

        <div class="col-sm-12 col-md-12">
            <button class="btn btn-success btn-block" onclick="window.location = '<?php echo base_url('manage/organizer/add'); ?>'">Add Organizer</button>
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
                    <div class="ckbox ckbox-default">
                        <input type="submit" name="send_mail" value="Send Mail" class="btn btn-default">
                    </div>
                </li>

                <li>
                    <a href="#" class="itemopt disabled" id="delete-item"><i class="fa fa-trash-o"></i> Delete</a>
                </li>



                <li>
                    <div class="ckbox ckbox-default">
                        <select type="select" id="sort-list" class="form-control">
                            <option> Sort By </option>
                            <option value="<?php echo base_url('manage/organizer/0'); ?>"> A - Z </option>
                            <option value="<?php echo base_url('manage/organizer/1'); ?>"> Z - A </option>
                           <!-- <option value="<?php // echo base_url('manage/organizer/2');   ?>"> Featured First </option>-->
                            <option value="<?php echo base_url('manage/organizer/3'); ?>"> Mail not sent </option>
                            <option value="<?php echo base_url('manage/organizer/4'); ?>"> Mail sent </option>
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
    <?php if (!empty($list)) { //echo '<pre>'; print_r($list); exit;
        ?>
        <div class="row">
            <div class="col-sm-12 col-md-12">
                <div class="table-responsive">
                    <table class="table mb30">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Logo</th>
                                <th>Organizer Name</th>
                                <th>Username</th>
                                <th>Status (E/D)</th>
                                <th>Mail sent (Y/N)?</th>
                                <th>&nbsp;</th>
                                <th>&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($list as $organizer):
                                ?>


                                <tr>
                                    <td class="text-center tdalign">
                                        <?php if ($this->session->userdata('id') != $organizer['organizer_id']) { ?>
                                            <input type="checkbox" name="delete[]" class="checkboxes-custom" value="<?php echo $organizer['organizer_id']; ?>">
                                        <?php } ?>
                                    </td>
                                    <td class="tdalign">
                                        <?php
                                        if ($organizer['organiser_photo'] != '') {
                                            $img = base_url() . UPLOAD_ORGANIZER_LOGO_DISPLAY . $organizer['organiser_photo'];
                                        } else {
                                            $img = base_url() . 'uploads/organizer_logo.png';
                                        }
                                        ?>
                                        <img width="30px" height="30px" src="<?php echo $img; ?>"</td>                               
                                    <td class="tdalign"><?php echo $organizer['name'] ?></td>
                                    <td class="tdalign"><?php echo $organizer['username'] ?></td>
                                    <td class="tdalign"><?php echo ($organizer['status'] == 1) ? 'E' : 'D'; ?></td>
                                    <td class="tdalign"><?php echo ($organizer['mail_sent'] == 1) ? 'Y' : 'N'; ?></td>
                                    <td class="table-action tdalign">

                                        <a title="Analytics" href="#"><i class="fa fa-bar-chart-o"></i></a>
                                        <a title="Edit" href="<?php echo base_url('manage/organizer/edit/' . $organizer['organizer_id']); ?>"><i class="fa fa-pencil"></i></a>
                                        <?php if ($this->session->userdata('id') != $organizer['organizer_id']) { ?>
                                            <a title="Delete" href="#" data="<?php echo $organizer['organizer_id']; ?>" class="delete-row"><i class="fa fa-trash-o"></i></a>
                                        <?php } ?>
                                    </td>
                                    <?php if ($this->session->userdata('is_superadmin') == 1) { ?>

                                        <td>
                                            <?php if ($organizer['event_id'] == '') { ?>
                                                <a class="btn btn-default btn-sm" href="javscript:void(0);" onClick="alert('Please create an Event for this Organizer before attempting to login.')">Login</a>
                                            <?php } else { ?>
                                                <a class="btn btn-default btn-sm" href="<?php echo base_url() ?>manage/login/adminLogin/O/<?php echo ($organizer["user_id"]); ?>" onClick="return confirm('Are you want to login with this user??')">Login</a>

                                            <?php } ?>
                                        </td>
                                    <?php } ?>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div><!-- table-responsive -->
            </div>
        </div>
        <?php
    } else {
        echo 'No Organizer Present';
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
<?php form_close(); ?>
<script>
                delete_url = '<?php echo base_url('manage/organizer/delete/json'); ?>';
</script>
