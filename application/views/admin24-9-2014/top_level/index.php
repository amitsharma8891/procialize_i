
<div class="contentpanel"><!-- Content Panel -->

    <div class="row mb20"><!-- Exhibitor Row -->

        <div class="col-sm-12 col-md-12">
            <button class="btn btn-success btn-block" onclick="window.location = '<?php echo base_url('manage/top_level/add/'); ?>'">Add Top Level</button>
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
                        <input type="text" name="search" class="search-button form-control" placeholder="Search">
                    </div>
                </li>

                <li>
                    <div class="ckbox ckbox-default">
                        <input type="submit" value="Search" class="btn btn-default">
                    </div>
                </li>

                <li>
                    <div class="ckbox ckbox-default">
                        <select type="select" id="sort-list" class="form-control">
                            <option value="<?php echo base_url('manage/top_level/0'); ?>">A - Z</option>
                            <option value="<?php echo base_url('manage/top_level/1'); ?>">Z - A</option>
                           
                        </select>
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
                    <table class="table mb30">
                        <thead>
						  <tr>
							<th></th>
							<th>Featured/Non-Featured</th>
							<th>Last Name</th>
							<th>Username</th>
							<th></th>
						  </tr>
						</thead>
						<tbody>
                            <?php 
                            foreach ($list as $top_level) { ?>
                                <tr>
                                    <td class="text-center"><input type="checkbox" name="delete[]" class="checkboxes-custom" value="<?php echo $top_level["id"]; ?>"></td>
                                    
                                    
                                    <td><?php echo $top_level["name"] ?> </td>
                                    
                                    <td class="table-action">
                                        <a title="Edit" href="<?php echo base_url(); ?>manage/top_level/edit/<?php echo $top_level["id"]; ?>"><i class="fa fa-pencil"></i></a>
                                        <a title="Delete" href="#" data="<?php echo $top_level["id"]; ?>" class="delete-row"><i class="fa fa-trash-o"></i></a>
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
        echo 'No Top Level Present';
    }
    ?>
<?php echo form_close() ?>

<script>
                delete_url = '<?php echo base_url('manage/top_level/delete/json'); ?>'
</script>