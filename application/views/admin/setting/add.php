<div class="contentpanel"><!-- Content Panel -->

    <div class="row mb10"><!-- Add Exhibitor Row -->

       <?php echo form_open(); ?>

            <div class="form-group">
                <label class="col-sm-2 control-label">Top Level Name</label>
                <div class="col-sm-6">
                    <?php 
                    $arrInputName = array('id'=>'txtName',
                                          'name'=>'txtName',
                                          'placeholder'=>'Top Level Name',
                                          'class'=>'form-control');
                    echo form_input($arrInputName);
                    ?>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-4">
                    <input type="button" class="btn btn-danger btn-block" value="Cancel"/>
                </div>
                <div class="col-sm-4">
                    <input type="button" class="btn btn-success btn-block" value="Save"/>
                </div>
            </div>
       <?php echo form_close(); ?></form>
    </div>


</div>