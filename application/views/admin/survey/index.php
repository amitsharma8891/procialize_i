
<div class="contentpanel"><!-- Content Panel -->

    <div class="row mb20"><!-- Survey Row -->

        <div class="col-sm-12 col-md-12">
            <button class="btn btn-success btn-block" onclick="window.location = '<?php echo base_url('manage/survey/add/' . $this->event_id); ?>'">Add Survey</button>
        </div>

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
                            <option value="<?php echo base_url('manage/survey/0'); ?>">A - Z</option>
                            <option value="<?php echo base_url('manage/survey/1'); ?>">Z - A</option>
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
    <?php if (!empty($list)) { //echo '<pre>'; print_r($list); ?>
        <div class="row">
            <div class="col-sm-12 col-md-12">
                <div class="table-responsive">
                    <table class="table mb30">
                        <thead>
						  <tr>
							<th></th>
							<!--<th>Featured/Non-Featured</th>
							<th>Last Name</th>
							<th>Username</th> -->
							<th>Survey Name</th> 
                            <th>Status</th> 
							<th>&nbsp;</th>
						  </tr>
						</thead>
						<tbody>
                            <?php foreach ($list as $survey) { ?>
                                <tr>
                                    <td class="text-center tdalign">
                                        <input type="checkbox" name="delete[]" class="checkboxes-custom" value="<?php echo $survey["id"]; ?>">
                                    </td>
                                    <!-- <td><i class="fa fa-shield"></i></td> -->
                                    <td class="tdalign"><?php echo $survey["name"] ?> </td>
                                    <td class="tdalign"><?php echo ($survey['status'] == 1)?'E':'D'; ?></td>
                                    <td class="table-action tdalign">

                                        <a title="Edit" href="<?php echo base_url(); ?>manage/survey/edit/<?php echo $survey["id"]; ?>"><i class="fa fa-pencil"></i></a>
                                        <a title="Delete" href="#" data="<?php echo $survey["id"]; ?>" class="delete-row"><i class="fa fa-trash-o"></i></a>
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
        echo 'No Surveys Present';
    }
    ?>
<?php echo form_close() ?>
    <script>
                delete_url = '<?php echo base_url('manage/survey/delete/json'); ?>'
    </script>