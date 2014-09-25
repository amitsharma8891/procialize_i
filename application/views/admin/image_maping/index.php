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
                                <th>Mapped event </th>
                                <th>Mapped Image</th>
                                <!--<th>Status (E/D)</th>-->
                                <th>&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($list as $value):
                                ?>
                                <tr>
                                    <td class="tdalign"><?php echo $value['name'] ?></td>
                                    <td class="tdalign"><?php echo $value['image_name'] ?></td>
                                    <!--<td class="tdalign"><?php //echo ($value['status'] == 1) ? 'E' : 'D';     ?></td>-->
                                    <td class="table-action tdalign">

                                        <a title="Edit" href="<?php echo base_url('manage/image_maping/add/' . $value['id']); ?>"><i class="fa fa-pencil"></i></a>
                                    </td>
                                    <td class="table-action tdalign">

                                        <a title="Map" href="<?php echo base_url('manage/image_maping/map_exhibitor/' . $value['id']); ?>"><i class="fa fa-picture-o"></i></a>
                                    </td>
                                    <td class="table-action tdalign">

                                        <a title="Delete" href="<?php echo base_url('manage/image_maping/delete/' . $value['id']); ?>" onclick="return confirm('Are you sure want to delete this image map ?')"><i class="fa fa-trash-o"></i></a>
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
</div>