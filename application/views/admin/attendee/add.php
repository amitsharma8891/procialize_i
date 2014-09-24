<div class="contentpanel"><!-- Content Panel -->

    <div class="row mb10"><!-- Add Exhibitor Row -->
    	<?php
    	if(isset($error)) {
    		echo $error;
    	}
		?>
        <?php echo  validation_errors('<div class="form-validation-error">','</div>');?>
       <?php  echo generateFormHtml($fields); ?>
    </div>


</div>