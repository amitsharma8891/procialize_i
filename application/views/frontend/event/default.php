<?php $thisPage = 'Default Organizer'; ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="shortcut icon" href="images/favicon.png" type="image/png">

        <title>Default Organizer - Procialize</title>

        <link href="<?php echo base_url(); ?>public/admin/css/style.default.css" rel="stylesheet">
        <link rel="stylesheet" href="<?php echo base_url(); ?>public/admin/css/jquery.tagsinput.css" />
        <link rel="stylesheet" href="<?php echo base_url(); ?>public/admin/css/bootstrap-fileupload.min.css" />
        <link rel="stylesheet" href="<?php echo base_url(); ?>public/admin/css/timepicker.css" />
        <link rel="stylesheet" href="<?php echo base_url(); ?>public/admin/css/validationEngine.jquery.css" />
        <link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.13/themes/start/jquery-ui.css" />

        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
        <script src="<?php echo base_url(); ?>public/admin/js/html5shiv.js"></script>
        <script src="<?php echo base_url(); ?>public/admin/js/respond.min.js"></script>
        <![endif]-->

    </head>

    <body>

        <section>

            <div class="leftpanel">
                <?php // $this->load->view('admin/leftpanel') ?>
            </div> <!-- leftpanel -->

            <div class="mainpanel">

                <div class="headerbar">
                    <?php $this->load->view('admin/header') ?>
                </div><!-- headerbar -->

                <div class="pageheader"> 
                    <?php // $this->load->view('admin/breadcrumb'); ?>
                </div>
                
                <?php print_r($this->session->flashdata('message')); ?>
                <?php $this->load->view($middle); ?>
                <!-- contentpanel -->

            </div><!-- mainpanel -->

            <div class="rightpanel">
                <?php // $this->load->view('admin/rightpanel') ?>
            </div><!-- rightpanel -->

        </section>


        <script src="<?php echo base_url(); ?>public/admin/js/jquery-1.10.2.min.js"></script>
        <script src="<?php echo base_url(); ?>public/admin/js/jquery-migrate-1.2.1.min.js"></script>
        <script src="<?php echo base_url(); ?>public/admin/js/bootstrap.min.js"></script>
        <script src="<?php echo base_url(); ?>public/admin/js/modernizr.min.js"></script>
        <script src="<?php echo base_url(); ?>public/admin/js/jquery.sparkline.min.js"></script>
        <script src="<?php echo base_url(); ?>public/admin/js/toggles.min.js"></script>
        <script src="<?php echo base_url(); ?>public/admin/js/retina.min.js"></script>
        <script src="<?php echo base_url(); ?>public/admin/js/jquery.cookies.js"></script>
        <script src="<?php echo base_url(); ?>public/admin/js/jquery.tagsinput.min.js"></script>
        <script src="<?php echo base_url(); ?>public/admin/js/jquery.validate.min.js"></script>
        <script src="<?php echo base_url(); ?>public/admin/js/bootstrap-fileupload.min.js"></script>
        <script src="<?php echo base_url(); ?>public/admin/js/timepicker.js"></script>
        <script src="<?php echo base_url(); ?>public/admin/js/chosen.jquery.min.js"></script>
        <script src="<?php echo base_url(); ?>public/admin/js/jquery.validationEngine.js"></script>
        <script src="<?php echo base_url(); ?>public/admin/js/jquery.validationEngine-en.js"></script>

        <script src="<?php echo base_url(); ?>public/admin/js/custom.js"></script>
        <script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>

        <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&libraries=places"></script>
        <script src="<?php echo base_url(); ?>public/admin/js/map.js"></script>
        <script src="<?php echo base_url(); ?>public/admin/js/username.js"></script>

        <script>
            jQuery(document).ready(function() {

                // Chosen Select
                jQuery(".chosen-select").chosen({'width': '100%', 'white-space': 'nowrap'});

                // Tags Input
                jQuery('#tags').tagsInput({
                    width: 'auto',
                    'autocomplete_url': '<?php echo base_url('manage/tag/autocomplete/'); ?>' + $(this).val(),
                });
                jQuery("#event_start").datepicker({dateFormat: 'yy-mm-dd',
                    onSelect: function(datetext) {
                        var d = new Date(); // for now
                        datetext = datetext + " " + d.getHours() + ":" + d.getMinutes() + ":" + d.getSeconds();
                        $('#event_start').val(datetext);
                    },
                });
                jQuery("#event_end").datepicker({dateFormat: 'yy-mm-dd',
                    onSelect: function(datetext) {
                        var d = new Date(); // for now
                        datetext = datetext + " " + d.getHours() + ":" + d.getMinutes() + ":" + d.getSeconds();
                        $('#event_end').val(datetext);
                    },
                });
                jQuery("#ad_starts").datepicker({dateFormat: 'yy-mm-dd',
                    onSelect: function(datetext) {
                        var d = new Date(); // for now
                        datetext = datetext + " " + d.getHours() + ":" + d.getMinutes() + ":" + d.getSeconds();
                        $('#ad_starts').val(datetext);
                    },
                });
                jQuery("#ad_ends").datepicker({dateFormat: 'yy-mm-dd',
                    onSelect: function(datetext) {
                        var d = new Date(); // for now
                        datetext = datetext + " " + d.getHours() + ":" + d.getMinutes() + ":" + d.getSeconds();
                        $('#ad_ends').val(datetext);
                    },
                });

                $('#location').googleAutocomplete();
                $('#username').userName();
                $('form').validationEngine('hideAll', {promptPosition: "centerRight", scroll: false});

                // Delete row in a table
                jQuery('.delete-row').click(function() {
                    var c = confirm("Continue delete?");
                    var id = $(this).attr('data');
                    var self = $(this);
                    if (c) {

                        $.ajax({
                            url: delete_url,
                            data: {id: id},
                            type: 'POST',
                            dataType: 'json',
                        }).done(function(data) {
                            if (data.status) {
                                self.closest('tr').fadeOut(function() {
                                    self.remove();
                                });
                            } else {
                                alert('Fail to delete exhibitor');
                            }
                        });

                        return false;
                    }
                    return false;
                });

                $('.group-checkable-custom').click(function() {
                    $('.checkboxes-custom').prop('checked', this.checked);
                    if (this.checked) {
                        $('#delete-item').removeClass('disabled').addClass('enabled');
                    } else {
                        $('#delete-item').removeClass('enabled').addClass('disabled');

                    }

                });
                $('body').on('click', '.enabled', function() {
                    var status = confirm('Are you sure you want to delete');
                    if (status)
                        $('#list-form').submit();
                });
                var type_of_answer = 1;
                $('body').on('click', '.add-Element', function() {
                    var html = '';
                    $('.duplicate').each(function() {
                        html = html + $(this).clone().wrapAll("<div/>").parent().html().replace('duplicate', '');

                    });
                    html = html.replace('type_of_answer', 'type_of_answer' + type_of_answer++);
                    $(this).hide();
                    $('.form-group:last').before(html);
                    $('.add-Element:last').show();
                });
                $('.time-picker').timepicker({'timeFormat': 'H:i:s'});
                $('#sort-list').change(function() {
                    url = $(this).val();
                    window.location = url;
                });

            });
        </script>

    </body>
</html>
