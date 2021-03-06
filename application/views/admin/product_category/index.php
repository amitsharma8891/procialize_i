
<div class="contentpanel"><!-- Content Panel -->

    <div class="row mb20"><!-- Exhibitor Row -->

        <div class="col-sm-12 col-md-12">
            <button class="btn btn-success btn-block" onclick="window.location = '<?php echo base_url('manage/product_category/add/'); ?>'">Add Product Category</button>
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
                    <div class="ckbox ckbox-default" >
                        <input type="text" name="search" style="display: inline" class="search-button form-control" placeholder="Search">
                    </div>
                </li>

                <li>
                    <div class="ckbox ckbox-default">
                        <input type="submit" value="search" class="btn btn-default">
                    </div>
                </li>

                <li>
                    <div class="ckbox ckbox-default">
                        <select type="select" id="sort-list" class="form-control">
                            <option value="<?php echo base_url('manage/product_category/0'); ?>">A to Z</option>
                            <option value="<?php echo base_url('manage/product_category/1'); ?>">Z to A</option>
                            <!-- <option value="<?php echo base_url('manage/product_category/2'); ?>">Featured first</option> -->
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
							<th>Product Category</th>
							<!-- <th>Last Name</th>
							<th>Username</th> 
							<th></th> -->
						  </tr>
						</thead>
						<tbody>
                            <?php 
                            foreach ($list as $product_category) { ?>
                                <tr>
                                    <td class="text-center"><input type="checkbox" name="delete[]" class="checkboxes-custom" value="<?php echo $product_category["id"]; ?>"></td>
                                    
                                    
                                    <td><?php echo $product_category["name"] ?> </td>
                                    
                                    <td class="table-action">
                                        <a title="Edit" href="<?php echo base_url(); ?>manage/product_category/edit/<?php echo $product_category["id"]; ?>"><i class="fa fa-pencil"></i></a>
                                        <a title="Delete" href="#" data="<?php echo $product_category["id"]; ?>" class="delete-row"><i class="fa fa-trash-o"></i></a>
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
        echo 'No Product Category Present';
    }
    ?>
<?php echo form_close() ?>

    <div class="modal fade" id="import" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Import Exhibitors - xls/csv</h4>
                </div>
                <div class="modal-body">
<?php echo form_open_multipart('manage/exhibitor/import'); ?>
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
                                        <input type="file" name="file" />
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6">
                            <button type="button" class="btn btn-success btn-block">Download Sample File</button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 col-md-12">
                            <button type="submit" class="btn btn-success btn-block">Upload</button>
                        </div>
                    </div>
<?php echo form_close() ?>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
                delete_url = '<?php echo base_url('manage/product_category/delete/json'); ?>'
</script>