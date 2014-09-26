<?php ?>


<div class="contentpanel"><!-- Content Panel -->
    <div class="row mb20"><!-- Exhibitor Row -->
        <div class="col-sm-12 col-md-12">
            <button class="btn btn-success btn-block" onclick="window.location = '<?php echo base_url('manage/image_maping/add'); ?>'">Add Event Mapping Image</button>
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
                                <th>Mapped Name</th>
                                <th>Mapped Image</th>
                                <th>Mapped Event Name</th>
                                <!--<th>Status (E/D)</th>-->
                                <th>&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($list as $value):

//                                display($value);
                                if ($value['parent_id'] == 0) {
                                    ?>
                                    <tr>
                                        <td class="tdalign"><?php echo $value['name'] ?></td>
                                        <td class="tdalign"><?php echo $value['image_name'] ?></td>
                                        <!--<td class="tdalign"><?php //echo ($value['status'] == 1) ? 'E' : 'D';                             ?></td>-->
                                        <td class="table-action tdalign">
                                            <a title="Edit" href="<?php echo base_url('manage/image_maping/add/' . $value['id']); ?>"><i class="fa fa-pencil"></i></a>
                                        </td>
                                        <?php if (!$value['parent_id']) {
                                            ?>
                                            <td class="table-action tdalign">
                                                <a title="Map" href="<?php echo base_url('manage/image_maping/map_exhibitor/' . $value['id']); ?>"><i class="fa fa-picture-o"></i></a>
                                            </td>

                                            <td class="table-action tdalign">

                                                <a title="Delete" href="<?php echo base_url('manage/image_maping/delete/' . $value['id']); ?>" onclick="return confirm('Are you sure want to delete this image map ?')"><i class="fa fa-trash-o"></i></a>
                                            </td>
                                        <?php } ?>
                                        <?php if ($this->session->userdata('is_superadmin') == 1) { ?>


                                        <?php } ?>
                                    </tr>
                                    <?php
                                    foreach ($list as $child):
                                        if ($value['id'] == $child['parent_id']) {
                                            ?>
                                            <tr>
                                                <td class="tdalign" style="padding-left: 4%"><?php echo $child['name'] ?></td>
                                                <td class="tdalign"><?php echo $child['image_name'] ?></td>
                                                <!--<td class="tdalign"><?php //echo ($child['status'] == 1) ? 'E' : 'D';                             ?></td>-->
                                                <td class="table-action tdalign">
                                                    <a title="Edit" href="<?php echo base_url('manage/image_maping/add/' . $child['id']); ?>"><i class="fa fa-pencil"></i></a>
                                                </td>


                                                <td class="table-action tdalign">
                                                    <a title="Map" href="<?php echo base_url('manage/image_maping/map_exhibitor/' . $child['id']); ?>"><i class="fa fa-picture-o"></i></a>
                                                </td>

                                                <td class="table-action tdalign">

                                                    <a title="Delete" href="<?php echo base_url('manage/image_maping/delete/' . $child['id']); ?>" onclick="return confirm('Are you sure want to delete this image map ?')"><i class="fa fa-trash-o"></i></a>
                                                </td>
                                                <?php if ($this->session->userdata('is_superadmin') == 1) { ?>


                                                <?php } ?>
                                            </tr>

                                            <?php
                                        }
                                    endforeach;
                                    ?>
                                <?php } endforeach; ?>
                        </tbody>
                    </table>
                </div><!-- table-responsive -->
            </div>
        </div>
        <?php
    } else {
        echo 'No Image map Present';
    }
    ?>
</div>