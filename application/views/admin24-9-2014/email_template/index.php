<?php ?>


<div class="contentpanel"><!-- Content Panel -->
    <div class="row mb20"><!-- Exhibitor Row -->

        <div class="col-sm-12 col-md-12">
            <button class="btn btn-success btn-block" onclick="window.location = '<?php echo base_url('manage/email_template/add'); ?>'">Add Email Template</button>
        </div>
        <!--        <div class="col-sm-6 col-md-6">
                    <button class="btn btn-success btn-block" data-toggle="modal" data-target="#import">Import Exhibitors - xls/csv</button>
                </div>-->

    </div>
    <?php //echo form_open('', array('id' => 'list-form', 'name' => 'list-form')); ?>
<!--    <div class="row mb10"> Add Exhibitor Row 

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
                            <option value="<?php echo base_url('manage/email_template/0'); ?>"> A - Z </option>
                            <option value="<?php echo base_url('manage/email_template/1'); ?>"> Z - A </option>
                            <option value="<?php // echo base_url('manage/organizer/2');   ?>"> Featured First </option>
                            <option value="<?php echo base_url('manage/email_template/3'); ?>"> Mail not sent </option>
                            <option value="<?php echo base_url('manage/email_template/4'); ?>"> Mail sent </option>
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
    </div>-->
    <?php if (!empty($list)) { //echo '<pre>'; print_r($list); exit;
        ?>
        <div class="row">
            <div class="col-sm-12 col-md-12">
                <div class="table-responsive">
                    <table class="table mb30">
                        <thead>
                            <tr>
                                <th>Email Template Name</th>
                                <th>Email Template Subject</th>
                                <th>Status (E/D)</th>
                                <th>&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php                               
                            foreach ($list as $value):
                                ?>
                                <tr>
<!--                                    <td class="text-center tdalign">
                                        <?php //if ($this->session->userdata('id') != $value['id']) { ?>
                                            <input type="checkbox" name="delete[]" class="checkboxes-custom" value="<?php echo $value['id']; ?>">
                                        <?php //} ?>
                                    </td>-->
                                    <td class="tdalign"><?php echo $value['name'] ?></td>
                                    <td class="tdalign"><?php echo $value['subject'] ?></td>
                                    <td class="tdalign"><?php echo ($value['status'] == 1) ? 'E' : 'D'; ?></td>
                                    <td class="table-action tdalign">

                                        <!-- <a title="Analytics" href="#"><i class="fa fa-bar-chart-o"></i></a> -->
                                        <a title="Edit" href="<?php echo base_url('manage/email_template/add/' . $value['id']); ?>"><i class="fa fa-pencil"></i></a>
                                        <?php // if ($this->session->userdata('id') != $value['id']) { ?>
                                            <!--<a title="Delete" href="#" data="<?php //echo $value['id']; ?>" class="delete-row"><i class="fa fa-trash-o"></i></a>-->
                                        <?php // } ?>
                                    </td>
                                    <?php if ($this->session->userdata('is_superadmin') == 1) { ?>

                                    
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
        echo 'No Email Template Present';
    }
    ?>
 