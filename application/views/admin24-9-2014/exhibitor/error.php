
<div class="csv_upload_error"><!--Out of {} records, {} uploaded successfully and {} has/have following problems :<br>-->
    <?php 
//    echo count($error);exit;
    if(count($error) > 0){ ?>
    <?php echo $insertValues; ?> records created / updated successfully.
   <?php  foreach ($error as $line => $rows) { ?>
        <div class="csv_line">Row :<?php echo $line; ?>
        Field(s)  
        <?php
        foreach ($rows as $key => $row) 
        {
            echo $row ;
            if($key != count($rows)-1) 
                 echo ",   "; 
        }
        
        ?>
        : Either mandatory but data missing OR Invalid data entered </div>
    <?php }
    }else{
    ?>
    <?php echo $insertValues; ?> records created / updated successfully.
    <?php } ?>
</div>

<!--<div class="csv_upload_error">
    <?php /*foreach ($error as $line => $rows) { ?>
        <div class="csv_line">Line Number :<?php echo $line; ?></div>
        <div class="csv_error_message">Columns </div>
        <?php foreach ($rows as $row) { ?>
        <div class="column_error">
            <?php echo $row; ?>
        </div>
        <?php } ?>
    <?php } */
    ?>
</div>-->
