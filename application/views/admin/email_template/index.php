<?php ?>


<div class="contentpanel"><!-- Content Panel -->
    <div class="row mb20"><!-- Exhibitor Row -->


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
                                    <td class="tdalign"><?php echo $value['subject'] ?></td>
                                    <!--<td class="tdalign"><?php //echo ($value['status'] == 1) ? 'E' : 'D'; ?></td>-->
                                    <td class="table-action tdalign">

                                        <a title="Edit" href="<?php echo base_url('manage/email_template/add/' . $value['id']); ?>"><i class="fa fa-pencil"></i></a>
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
 