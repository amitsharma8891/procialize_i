<?php ?>


<div class="contentpanel"><!-- Content Panel -->
    <div class="row mb20"><!-- Exhibitor Row -->
        <div class="row mb20"><!-- Exhibitor Row -->

            <div class="col-sm-12 col-md-12">
                <button class="btn btn-success btn-block" onclick="window.location = '<?php echo base_url('manage/place/add'); ?>'">Add </button>
            </div>
            <!--        <div class="col-sm-6 col-md-6">
                        <button class="btn btn-success btn-block" data-toggle="modal" data-target="#import">Import Exhibitors - xls/csv</button>
                    </div>-->

        </div>

        <?php if (!empty($list)) { //echo '<pre>'; print_r($list); exit;
            ?>
            <div class="row">
                <div class="col-sm-12 col-md-12">
                    <div class="table-responsive">
                        <table class="table mb30">
                            <thead>
                                <tr> 
                                    <th><?php echo ucfirst($country_city_type) . " Name" ?> </th>
                                    <!--<th> Subject</th>-->
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
                                        <!--<td class="tdalign"><?php //echo $value['subject']         ?></td>-->
                                        <!--<td class="tdalign"><?php //echo ($value['status'] == 1) ? 'E' : 'D';         ?></td>-->
                                        <td class="table-action tdalign">
                                            <a title="Edit" href="<?php echo base_url('manage/place/add/' . $value['id']); ?>"><i class="fa fa-pencil"></i></a>
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
            echo 'No ' . $country_city_type . ' Present';
        }
        ?>
 