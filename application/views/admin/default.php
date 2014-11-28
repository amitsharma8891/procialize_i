<?php
$thisPage = 'Default Organizer';
error_reporting(0);
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="shortcut icon" href="<?php echo base_url() ?>/public/admin/images/favicon.png" type="image/png">

        <title>Default Organizer - <?php echo getSetting()->app_name; ?></title>

        <link href="<?php echo base_url(); ?>public/admin/css/style.default.css" rel="stylesheet">
        <link rel="stylesheet" href="<?php echo base_url(); ?>public/admin/css/jquery.tagsinput.css" />
        <link rel="stylesheet" href="<?php echo base_url(); ?>public/admin/css/bootstrap-fileupload.min.css" />
        <link rel="stylesheet" href="<?php echo base_url(); ?>public/admin/css/timepicker.css" />
        <link rel="stylesheet" href="<?php echo base_url(); ?>public/admin/css/validationEngine.jquery.css" />
        <link rel="stylesheet" href="<?php echo base_url(); ?>public/admin/css/fullcalendar.css" />
        <link rel="stylesheet" href="<?php echo base_url(); ?>public/admin/css/jasny.css" />
        <link rel="stylesheet" href="<?php echo base_url(); ?>public/admin/css/jquery-ui.css" />
        <link href="<?php echo base_url(); ?>public/admin/css/jquery.datatables.css" rel="stylesheet">
        <link rel="stylesheet" href="<?php echo base_url(); ?>public/admin/css/bootstrap-wysihtml5.css" />
        <link rel="stylesheet" href="<?php echo base_url(); ?>public/admin/css/colorpicker.css" />
        <link rel="stylesheet" href="<?php echo base_url(); ?>public/admin/css/preview.css" />
        <link rel="stylesheet" href="<?php echo base_url(); ?>public/admin/js/scroller/jquery.mCustomScrollbar.css" />
        <script src="<?php echo base_url(); ?>public/admin/js/jquery-1.10.2.min.js"></script>
        <script src="<?php echo base_url(); ?>public/admin/js/jquery-migrate-1.2.1.min.js"></script>
        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
        <script src="<?php echo base_url(); ?>public/admin/js/html5shiv.js"></script>
        <script src="<?php echo base_url(); ?>public/admin/js/respond.min.js"></script>
        <![endif]-->
        <?php include_once 'setting.php'; ?>
    </head>

    <body>
        <!-- Preloader -->

        <div id="preloader">
            <div id="status"><i class="fa fa-spinner fa-spin"></i></div>
        </div>
        <section>

            <div class="leftpanel">
                <?php $this->load->view('admin/leftpanel') ?>
            </div><!-- leftpanel -->

            <div class="mainpanel">

                <div class="headerbar">
                    <?php $this->load->view('admin/header') ?>
                </div><!-- headerbar -->

                <div class="pageheader"> 
                    <?php $this->load->view('admin/breadcrumb'); ?>
                </div>
                <?php echo ($this->session->flashdata('message')); ?>
                <?php $this->load->view($middle); ?>
                <!-- contentpanel -->

            </div><!-- mainpanel -->

            <div class="rightpanel">
                <?php $this->load->view('admin/rightpanel') ?>
            </div><!-- rightpanel -->

            <!-- Modal -->
        </section>



        <script src="<?php echo base_url(); ?>public/admin/js/bootstrap.min.js"></script>
        <script src="<?php echo base_url(); ?>public/admin/js/jquery-ui-1.10.3.min.js"></script>
        <script src="<?php echo base_url(); ?>public/admin/js/jasny.js"></script>
        <script src="<?php echo base_url(); ?>public/admin/js/modernizr.min.js"></script>
        <script src="<?php echo base_url(); ?>public/admin/js/jquery.sparkline.min.js"></script>
        <script src="<?php echo base_url(); ?>public/admin/js/toggles.min.js"></script>
        <script src="<?php echo base_url(); ?>public/admin/js/retina.min.js"></script>
        <script src="<?php echo base_url(); ?>public/admin/js/jquery.cookies.js"></script>
        <!--<script src="<?php echo base_url(); ?>public/admin/js/wysihtml5-0.3.0.min.js"></script>-->
        <script src="<?php echo base_url(); ?>public/admin/js/bootstrap-wysihtml5.js"></script>
        <script src="<?php echo base_url(); ?>public/admin/js/ckeditor/ckeditor.js"></script>
       <!-- <script src="<?php echo base_url(); ?>public/admin/js/ckeditor/adapters/jquery.js"></script>-->
        <script src="<?php echo base_url(); ?>public/admin/js/jquery.tagsinput.min.js"></script>
        <script src="<?php echo base_url(); ?>public/admin/js/jquery.validate.min.js"></script>
        <script src="<?php echo base_url(); ?>public/admin/js/bootstrap-fileupload.min.js"></script>
        <script src="<?php echo base_url(); ?>public/admin/js/timepicker.js"></script>
        <script src="<?php echo base_url(); ?>public/admin/js/chosen.jquery.min.js"></script>
        <script src="<?php echo base_url(); ?>public/admin/js/jquery.validationEngine.js"></script>
        <script src="<?php echo base_url(); ?>public/admin/js/jquery.validationEngine-en.js"></script>
        <script src="<?php echo base_url(); ?>public/admin/js/custom.js"></script>
        <script src="<?php echo base_url(); ?>public/admin/js/bootstrap-wizard.min.js"></script>
        <script src="<?php echo base_url(); ?>public/admin/js/fullcalendar.min.js"></script>

        <script src="<?php echo base_url(); ?>public/admin/js/raphael-2.1.0.min.js"></script>
        <script src="<?php echo base_url(); ?>public/admin/js/flot/flot.min.js"></script>
        <script src="<?php echo base_url(); ?>public/admin/js/flot/flot.resize.min.js"></script>

        <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&libraries=places"></script>
        <script src="<?php echo base_url(); ?>public/admin/js/map.js"></script>
        <script src="<?php echo base_url(); ?>public/admin/js/username.js"></script>
        <script src="<?php echo base_url(); ?>public/admin/js/jquery.datatables.min.js"></script>
        <script src="<?php echo base_url(); ?>public/admin/js/bootstrap-timepicker.min.js"></script>
        <script src="<?php echo base_url(); ?>public/admin/js/underscore-min.js"></script>
        <script src="<?php echo base_url(); ?>public/admin/js/custom_validation.js"></script>
        <script src="<?php echo base_url(); ?>public/admin/js/colorpicker.js"></script>
        <script src="<?php echo base_url(); ?>public/admin/js/scroller/jquery.mCustomScrollbar.concat.min.js"></script>
        <script>
            (function($) {
                $(window).load(function() {
                    $(".preview_event").mCustomScrollbar();
                });
            })(jQuery);
        </script>

        <script>
            var SITE_URL = '<?php echo SITE_URL; ?>';
            function update_tweets(event_id)
            {
                $.ajax({
                    type: "POST",
                    url: SITE_URL + "manage/event/update_event_tweets",
                    dataType: "json",
                    data: {
                        'event_id': event_id,
                    },
                    success: function(res)
                    {
                        if (res.status == 1) {
                            alert('Tweets Updated Successfully.');
                        }
                    }
                });
            }
            jQuery(document).ready(function() {
                $("input[name = 'search']").keypress(function(e) {
                    if (e.keyCode == '13') {
                        return false;

                    }
                });


                // Color Picker
                if (jQuery('#colorpicker').length > 0) {
                    jQuery('#colorSelector').ColorPicker({
                        onShow: function(colpkr) {
                            jQuery(colpkr).fadeIn(500);
                            return false;
                        },
                        onHide: function(colpkr) {
                            jQuery(colpkr).fadeOut(500);
                            return false;
                        },
                        onChange: function(hsb, hex, rgb) {
                            jQuery('#colorSelector span').css('backgroundColor', '#' + hex);
                            jQuery('#colorpicker').val('#' + hex);
                        }
                    });
                }
                if (jQuery('#colorpicker2').length > 0) {
                    jQuery('#colorSelector2').ColorPicker({
                        onShow: function(colpkr) {
                            jQuery(colpkr).fadeIn(500);
                            return false;
                        },
                        onHide: function(colpkr) {
                            jQuery(colpkr).fadeOut(500);
                            return false;
                        },
                        onChange: function(hsb, hex, rgb) {
                            jQuery('#colorSelector2 span').css('backgroundColor', '#' + hex);
                            jQuery('#colorpicker2').val('#' + hex);
                        }
                    });
                }

                /* setTimeout(function() {
                 $('#myModalx').modal('toggle');
                 }, 500); */

                // Chosen Select
                jQuery(".chosen-select").chosen({'width': '100%', 'white-space': 'nowrap'});
                // Tags Input
                jQuery('#tags').tagsInput({
                    width: 'auto',
                    'autocomplete_url': '<?php echo base_url('manage/tag/autocomplete/'); ?>' + $(this).val(),
                });
                


                $(document).ready(function() {
<?php if (!isset($datepicker)) { ?>
                        $("#event_start").datepicker({
                            minDate: 0,
                            maxDate: "+60D",
                            numberOfMonths: 1,
                            onSelect: function(selected) {
                                $("#event_end").datepicker("option", "minDate", selected);
                                $(".formError").remove();

                            }
                        });
                        $("#event_end").datepicker({
                            minDate: 0,
                            maxDate: "+60D",
                            numberOfMonths: 1,
                            onSelect: function(selected) {
                                $("#event_start").datepicker("option", "maxDate", selected);
                                $(".formError").remove();

                            }
                        });
<?php } ?>
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
                jQuery("#notification_date").datepicker({dateFormat: 'yy-mm-dd',
                    onSelect: function(datetext) {
                        var d = new Date(); // for now
                        //datetext = datetext + " " + d.getHours() + ":" + d.getMinutes() + ":" + d.getSeconds();
                        datetext = datetext;
                        $('#notification_date').val(datetext);
                        $(".formError").remove();

                    },
                });
                jQuery("#datepicker-general").datepicker({dateFormat: 'yy-mm-dd',
                    onSelect: function(datetext) {
                        var d = new Date(); // for now
                        datetext = datetext;
                        $("#datepicker-general").val(datetext);
                        $(".formError").remove();
                    },
                });
                $('#location_google').googleAutocomplete();
                $('#username').userName();
                $('form').validationEngine('', {promptPosition: "centerRight", scroll: false, validationEventTrigger: 'submit', });
                // Delete row in a table
                jQuery('.delete-row').click(function() {
                    var c = confirm("Please confirm if you would like to delete the profile(s)?");
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
                            }
                            alert(data.message);
                        });
                        return false;
                    }
                    return false;
                });
                $('.group-checkable-custom').click(function() {
                    $('.checkboxes-custom').prop('checked', this.checked);
                    if (this.checked) {
                        $('#delete-item').removeClass('disabled').addClass('enabled');
                        //$("input[name = 'send_mail']").removeClass('disabled').addClass('enabled');
                        $("input[name = 'send_mail']").removeClass('disabled').addClass('enabledmail');

                    } else {
                        $('#delete-item').removeClass('enabled').addClass('disabled');
                        //$("input[name = 'send_mail']").removeClass('enabled').addClass('disabled');
                        $("input[name = 'send_mail']").removeClass('enabledmail').addClass('disabled');
                    }

                });
                $('.checkboxes-custom').click(function() {
                    var activate_delete = false;
                    $('.checkboxes-custom').each(function() {
                        console.log($(this).prop('checked'));
                        if ($(this).prop('checked'))
                            activate_delete = true;
                    });
                    if (activate_delete) {
                        $('#delete-item').removeClass('disabled').addClass('enabled');
                        //$("input[name = 'send_mail']").removeClass('disabled').addClass('enabled');
                        $("input[name = 'send_mail']").removeClass('disabled').addClass('enabledmail');
                    } else {
                        $('#delete-item').removeClass('enabled').addClass('disabled');
                        //$("input[name = 'send_mail']").removeClass('enabled').addClass('disabled');
                        $("input[name = 'send_mail']").removeClass('enabledmail').addClass('disabled');
                    }

                });
                //$("input[name = 'send_mail']").removeClass('enabled').addClass('disabled');
                $("input[name = 'send_mail']").removeClass('enabledmail').addClass('disabled');

                $('body').on('click', '.enabled', function() {
                    var status = confirm('Please confirm if you would like to delete the profile(s)?');
                    if (status)
                        $('#list-form').submit();
                });
                $('body').on('click', '.enabledmail', function() {
                    var status = confirm('Please confirm if you would like to send mail to selected people?');
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
<?php if (isset($Agenda)) { ?>
                    /* initialize the calendar
                     -----------------------------------------------------------------*/
                    var date = new Date();
                    var d = date.getDate();
                    var m = date.getMonth();
                    var y = date.getFullYear();
                    var calendar = jQuery('#calendar').fullCalendar({
                        header: {
                            left: false,
                            center: false,
                            right: false
                        },
                        slotMinutes: 15,
                        columnFormat: {month: 'ddd', week: 'ddd d/M', day: 'dddd, d MMM, yyyy'},
                        year: <?php echo $year; ?>,
                        month: <?php echo $month - 1; ?>,
                        date: <?php echo $day; ?>,
                        events: events,
                        //                    theme: true,
                        defaultView: 'agendaDay',
                        editable: true,
                        selectable: true,
                        slotEventOverlap: false,
                        selectHelper: true,
                        select: function(start, end, allDay)
                        {
                            $('.session-popup-title').html('Add Session');
                            var start_date = $.fullCalendar.formatDate(start, "yyyy-MM-dd HH:mm:ss");
                            var end_date = $.fullCalendar.formatDate(end, "yyyy-MM-dd HH:mm:ss");
                            openPopUP(start, end, start_date, end_date, '', '', '')
                            $('#session-popup-footer').html('');
                            $('.session-image').attr('src', 'http://placehold.it/106x64');
                            //                        $( "#foo" ).trigger( "click" );
                            //                        var title = prompt('Event Title:');
                            //                        return false;

                        },
                        eventResize: function(event, dayDelta, minuteDelta, revertFunc) {
                            console.log(event);
                            console.log(event.session_id);
                            console.log(event.start);
                            console.log(event.end);
                            updateSession(event);
                        },
                        eventDrop: function(event, jsEvent, ui, view) {
                            console.log(event);
                            console.log(event.session_id);
                            console.log(event.start);
                            console.log(event.end);
                            updateSession(event);
                        },
                        eventClick: function(event, jsEvent, view) {
                            console.log(event);
                            $('.session-popup-title').html('Edit Session');
                            $('#session-popup-footer').html('<div class="modal-footer"><a href=<?php echo base_url('manage/agenda/deleteSession/') ?>/' + event.session_id + '  onclick="return confirm(\'Are you sure you want to delete?\')" class="btn btn-danger btn-sm delete_session">Delete Session</a></div>');
                            var start_date = $.fullCalendar.formatDate(event.start, "yyyy-MM-dd HH:mm:ss");
                            var end_date = $.fullCalendar.formatDate(event.end, "yyyy-MM-dd HH:mm:ss");
                            var start = event.start;
                            var end = event.end;
                            $('.session-image').attr('src', event.image);
                            openPopUP(start, end, start_date, end_date, event.title, event.description, event.speaker_id, event.session_id);
                        }
                    });
                    function openPopUP(start, end, start_date, end_date, title, desc, speaker_id, id) {
                        $('#session_title').val(title);
                        $('#session_des').val(desc);
                        $('#session_start').val(start);
                        $('#session_end').val(end);
                        $('#session_startF').val(start_date);
                        $('#session_endF').val(end_date);
                        var formatDate = 'dd MMMM yyyy (hh mm tt)';
                        $('#start-end-date').html($.fullCalendar.formatDate(start, formatDate) + ' - ' + $.fullCalendar.formatDate(end, formatDate));
                        console.log(speaker_id);
                        var dataarray = [];
                        if (speaker_id !== null)
                            dataarray = speaker_id.split(",");
                        $('#speaker_id').val(dataarray);
                        $('#id').val(id);
                        $('select').trigger("chosen:updated");
                        console.log(speaker_id);
                        $('#display-session-pop').click();
                    }

                    function updateSession(event) {
                        var start_date = $.fullCalendar.formatDate(event.start, "yyyy-MM-dd HH:mm:ss");
                        var end_date = $.fullCalendar.formatDate(event.end, "yyyy-MM-dd HH:mm:ss");
                        var sendData = {'start_time': start_date, 'end_time': end_date, 'id': event.session_id};
                        saveSession(sendData);
                    }

                    $('#add-session-popUP').click(function() {
                        var title = $('#session_title').val();
                        var start = $('#session_start').val();
                        var end = $('#session_end').val();
                        var desc = $('#session_des').val();
                        var allDay = $('#all_day').val();
                        var speaker_id = $('#speaker_id').val();
                        var id = $('#id').val();
                        if (title)
                        {
                            if (id == '') {
                                var start_date = $('#session_startF').val();
                                var end_date = $('#session_endF').val();
                                var sendData = {'speaker_id': speaker_id, 'name': title, 'description': desc, 'start_time': start_date, 'end_time': end_date, 'track_id': track_id, 'event_id': event_id, 'id': id}
                                var id = saveSession(sendData);
                                calendar.fullCalendar('renderEvent',
                                        {
                                            title: title,
                                            start: start,
                                            end: end,
                                            allDay: allDay,
                                        },
                                        true // make the event "stick"
                                        );
                            }

                        }
                        calendar.fullCalendar('unselect');
                        $('.close').click();
                        console.log($('#track_' + track_id));
                    });
                    function saveSession(sendData) {
                        $.ajax({
                            data: sendData,
                            type: 'POST',
                            url: '<?php echo base_url() ?>manage/agenda/addSession',
                            dataType: 'json'
                        }).done(function(result) {
                            $('#track_' + track_id).click();
                        })
                    }

                    $('body').on('click', '.add-track', function() {
                        var title = prompt('Track Title:');
                        if (title) {

                            var sendData = {'name': title, 'event_id': event_id};
                            $.ajax({
                                data: sendData,
                                type: 'POST',
                                url: '<?php echo base_url() ?>manage/agenda/addtrack',
                                dataType: 'json'
                            }).done(function(result) {
                                window.location.reload();
                            })
                        }

                    });
                    $('.delete-track').click(function() {
                        var self = $(this);
                        var title = confirm('Are you sure you want to delete');
                        var id = $(this).attr('id');
                        if (title) {
                            var sendData = {'id': id};
                            $.ajax({
                                data: sendData,
                                type: 'POST',
                                url: '<?php echo base_url() ?>manage/agenda/deleteTrack',
                                dataType: 'json'
                            }).done(function(result) {
                                self.parent().remove();
                                if ($('.delete-track').length == 0) {
                                    window.location.reload();
                                }
                            })
                        }

                    });
<?php } ?>
                jQuery('#cancel_button').click(function() {
                    var burl = '<?php echo base_url(); ?>';
                    var curl = '<?php echo $this->uri->segment(1); ?>';
                    var gurl = '<?php echo $this->uri->segment(2); ?>';
                    window.location = burl + curl + '/' + gurl;
                });
                $('#filter_drpdown').change(function() {
                    var value = $(this).val();
                    $(this).closest('form').trigger("reset");
                    $(this).val(value);
                    $(this).closest('form').submit();
                });
                jQuery(document).ready(function() {


                    // Chosen Select
                    jQuery("select").chosen({
                        'min-width': '100px',
                        'white-space': 'nowrap',
                        disable_search_threshold: 10
                    });

                    // Show aciton upon row hover
                    jQuery('.table-hidaction tbody tr').hover(function() {
                        jQuery(this).find('.table-action-hide a').animate({opacity: 1});
                    }, function() {
                        jQuery(this).find('.table-action-hide a').animate({opacity: 0});
                    });
                    $('#notification_date').prop("disabled", true);
                    $('#start_time').prop("disabled", true);
                    $('#now').click(function() {
                        var self = $(this);
                        if (this.checked) {
                            $('#notification_date').prop("disabled", true);
                            $('#datepicker-general').prop("disabled", true);
                            $('#start_time').prop("disabled", true);
                            $('#time').prop("disabled", true);
                        } else {

                            $('#notification_date').prop("disabled", false);
                            $('#datepicker-general').prop("disabled", false);
                            $('#start_time').prop("disabled", false);
                            $('#time').prop("disabled", false);
                        }

                    });
                    $('#alll').click(function() {
                        $('.select_all').prop("checked", this.checked);
                    });
                    $('#All').click(function() {
                        $('#Exhibitor').prop("checked", this.checked);
                        $('#Attendee\\/Speaker').prop("checked", this.checked);
                    });
                    $('#Exhibitor').live('click', function() {
                        if (!$('#Exhibitor').prop('checked')) {

                            $('#All').prop('checked', false);
                        }
                    });
                    $('#Attendee\\/Speaker').live('click', function() {
                        if (!$('#Attendee\\/Speaker').prop('checked')) {
                            //alert('here');
                            $('#All').prop('checked', false);
                        }
                    });
                    $('#notification').submit(function() {
                        if ($('#announcement_content').val().trim() == '') {
                            alert('Notification text required');
                            $('#announcement_content').focus();
                            return false;
                        }

                        if (!$('#now').prop('checked') && ($('#notification_date').val() == '' || $('#start_time').val() == '')) {
                            alert('Ad start or From is required');
                            return false;
                        }
                        var checked = true;
                        $('.select_all').each(function() {
                            if (this.checked)
                                checked = false;
                        });
                        if (checked && $('#attendee').val() == null) {
                            alert('Please select type');
                            return false;
                        }

                    });
                    $('#session_create_form').submit(function() {
                        if (!!$('#speaker_id').val()) {
                            return true;
                        }
//                        alert('Please select aleast one speaker');
//                        return false;
                    });
                    $('.table').dataTable(
                            {
                                "bSort": false,
////                        "bFilter": false,
////                        "bLengthChange": false,
////                        "bRetrieve": true,
                            }
                    );
                    $('.cp-basic').colorpicker();
                    var month = new Array();
                    month[0] = "Jan";
                    month[1] = "Feb";
                    month[2] = "Mar";
                    month[3] = "Apr";
                    month[4] = "May";
                    month[5] = "June";
                    month[6] = "July";
                    month[7] = "Aug";
                    month[8] = "Sep";
                    month[9] = "Oct";
                    month[10] = "Nov";
                    month[11] = "Dec";
                    $('#event_preview').click(function() {
                        var data = [];
                        var std_date = $('#event_start').val();
                        var end_date = $('#event_end').val();
                        var convert_date = (std_date != '') ? new Date(std_date) : new Date();
                        console.log(std_date);
                        var std_day = convert_date.getDate();
                        var convert_date = new Date(end_date);
                        var convert_date = (end_date != '') ? new Date(end_date) : new Date();

                        var end_day = convert_date.getDate();
                        var end_mon = month[convert_date.getMonth()];
                        var end_yr = convert_date.getFullYear();

                        data['event_logo'] = $('.event_logo_image img').attr('src');
                        data['event_date'] = std_day + ' - ' + end_day + end_mon + ', ' + end_yr;
                        data['event_location'] = $('#location_google').val();
                        data['event_city'] = $('#city').val();
                        data['event_country'] = $('#country').val();
                        data['event_name'] = $('#name').val();
                        data['event_description'] = $('#description').val();
                        data['event_email'] = $('#email').val();
                        data['event_website'] = $('#website_link').val();
                        data['comman_connection'] = '<?php echo base_url() ?>public/admin/images/common_connections.png';

                        data['event_img1'] = $('.event_logo_image1 img').attr('src');
                        data['event_img2'] = $('.event_logo_image2 img').attr('src');
                        data['event_img3'] = $('.event_logo_image3 img').attr('src');

<?php if ($superadmin) { ?>
                            var org_logo = '<?php echo base_url() . 'public/admin/images/user.png' ?>';
<?php } else { ?>
                            var org_logo = '<?php echo $this->session->userdata('logo'); ?>';
<?php } ?>
                        data['org_logo'] = org_logo;
                        var industry_id = [];
                        $('#industry_id option:selected').each(function() {
                            industry_id.push($(this).text());
                        });
                        var industry_id_str = industry_id.join(', ');

                        var functionality_id = [];
                        $('#functionality_id option:selected').each(function() {
                            functionality_id.push($(this).text());
                        });
                        var functionality_id_str = functionality_id.join(', ');
                        data['event_ind_fun'] = industry_id_str + ',' + functionality_id;

                        var eventTemplate = _.template($("#event_template").html(), {
                            content: data
                        });

                        $('.preview1').html(eventTemplate);
                        $(".preview_event").mCustomScrollbar();

                        setTimeout(function() {

                            initialize();
//                            google.maps.event.addDomListener(window, 'resize', initialize);

                        }, 2000);

                    });
                    function initialize() {
                        console.log('asd');
                        var myLatlng = new google.maps.LatLng($("input[name=latitude]").val(), $("input[name=longitude]").val());
                        var mapOptions = {
                            zoom: 12,
                            center: myLatlng,
                            //mapTypeControl: false,
                            //scrollwheel: false,
                            //keyboardShortcuts: false,
                            //draggable: false,

                        }
                        var map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);

                        var marker = new google.maps.Marker({
                            position: myLatlng,
                            map: map,
                            //title: 'Hello World!'
                        });
                        map.setCenter(marker.getPosition())
                    }


                });
<?php
if (isset($data->tag_name)) {
    $arrTags = explode(',', $data->tag_name);
    foreach ($arrTags as $tag) {
        ?>
                        jQuery('#tags').addTag('<?php echo $tag ?>');
        <?php
    }
}
?>
                $('.sub-menu').click(function() {
                    var event_id = $(this).attr('data');
                    $.cookie('event_id', event_id, {expires: 7, path: '/'});
                });
                $('.sub-menu a').click(function() {
                    var menu_name = $(this).attr('data');
                    $.cookie('menu_name', menu_name, {expires: 7, path: '/'});
                });
            });
            function OpenInNewTab(url)
            {
                var win = window.open(url, '_blank');
            }


        </script>



        <div class="modal fade bs-example-modal-lg in" id="compose" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title" id="myModalLabel">Compose</h4>
                    </div>
                    <div class="modal-body">
                        <?php echo form_open(base_url() . 'manage/notification/add', array('id' => 'notification', 'name' => 'notification-form')); ?>

                        <div class="row mb10">
                            <!--<div class="col-sm-1">
                                Type
                            </div>-->
                            <div class="col-sm-3">
                                <?php
                                $type = $this->session->userdata('type_of_user');
                                if ($type != 'E') {
                                    ?>
                                    <select name= "type" type="select" class="form-control chosen-select">
                                        <option value="">Choose Type</option>
                                        <option value="A">Alert</option>
                                        <option value="N">Notification</option>
                                        <option value="F">Feedback</option>

                                    </select>
                                <?php } else { ?>
                                    Send Notification
                                    <input type="hidden" name="type" value="N" />
                                <?php } ?>

                            </div>
                            <div style="color:#a94442;"> <?php echo form_error('type'); ?></div>
                            <div class="col-sm-3">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <input name="now" type="checkbox" id="now" value="1" checked="checked">
                                    </span>
                                    <input type="text" value="Now" class="form-control" disabled>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                                    <input ntype="text" class="form-control " name="notification_date" placeholder="Select Date" id="notification_date">
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
                                    <div class="bootstrap-timepicker"><input id="start_time" name="notification_time" placeholder="From" type="text" class="form-control time-picker ui-timepicker-input"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb10">
                            <div class="col-sm-12">
                                <textarea id="announcement_content" name ='content' rows="6" class="form-control" placeholder="Write text for the post to be displayed in the notification section"></textarea>
                            </div>
                            <div style="color:#a94442;"> <?php echo form_error('content'); ?></div>
                        </div>
                        <div class="row mb10">
                            <div class="col-sm-12">
                                <?php echo form_dropdown('attendee_id[]', getAttendee_dropdown(), '', 'class="form-control chosen-select" id="attendee" multiple   placeholder="Type" data-placeholder="Attendee "'); ?>

                            </div>

                        </div>
                        <div class="row mb10">
                            <div class="col-sm-12">
                                <ul class="list-inline mb5">
                                    <li>
                                        
                                    </li>


                                    <li><input name ='attendee' class="select_all" type="checkbox" id="attendee" value="1"> <label for="attendee">All Attendee, Speakers, Exhibitors </label></li>
                                </ul>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <?php
                                $data = array("name" => "btnSubmit", "id" => "btnSubmit", "value" => "Send", "class" => "btn btn-success btn-block");
                                echo form_submit($data);
                                ?>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <button data-toggle="modal" id="display-session-pop" data-target="#add-session"></button>
        <div class="modal fade" id="add-session" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title" id="myModalLabel">Add Session</h4>
                    </div>
                    <div class="modal-body">
                        <form action="/" method="post">
                            <div class="row mb10">

                                <div class="col-sm-6">
                                    <input type="text" class="form-control " name="session_title" placeholder="Session Title" id="session_title">
                                </div>
                                <div class="col-sm-3">
                                    <input type="hidden" name="session_start"  id="session_start"/>
                                    <input type="hidden" name="session_end" id="session_end" />
                                    <input type="hidden" name="session_startF"  id="session_startF"/>
                                    <input type="hidden" name="session_endF" id="session_endF" />
                                    <input type="hidden" name="all_day" id="all_day" />
                                </div>
                            </div>
                            <div class="row mb10">
                                <div class="col-sm-12">
                                    <textarea id="session_des" rows="6" class="form-control" placeholder="Write text for the post to be displayed in the session description"></textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <input type="button" class="btn btn-success btn-block" id="add-session-popUP" value="Add">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="modal fade" id="help" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title" id="myModalLabel">Help</h4>
                </div>
                <div class="modal-body">
                    <address>
                        <strong>Need Help?</strong><br>
                        <strong>Feel free to Contact:</strong> Abhay Bhatia (9820325285) <br>
                        <strong>Email:</strong> info@procialize.in<br>
<!--                        <strong>Address:</strong> ABCD, CDBG, 2899002<br>
                        <strong>Timing:</strong> 9am to 9pm<br>-->
                    </address>
                </div>
            </div>
        </div>
    </div>


    <!--Preview Popup-->
    <div class="modal fade" id="preview" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content"> 
                <div class="modal-body" style="display:inline-block; ">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <div class="col-xs-12">
                        <div class="preview1">
                            <div class="preview_21" style="">
                                <div class="panel panel-default panel-stat-preview ">
                                    <div>
                                        <div class="row">
                                            <div class="col-xs-12 preview_event" >
                                                <div class="stat well well-sm">
                                                    <div class="row">
                                                        <div class="col-xs-4">
                                                            <div class="preview_thumb"> <img src="<?php echo base_url() ?>/public/admin/images/homexpo.png" alt="" class="img-responsive preview_userlogo"/> </div>
                                                        </div>
                                                        <div class="col-xs-5 preview_eventdet">
                                                            <h4>15-18 Apr, 2014</h4>
                                                            <small class="stat-label">New Delhi, India</small> <small class="stat-label">Interiors, Decoratives</small> </div>
                                                        <div class="col-xs-3"> <small class="stat-label">
                                                                <div class="preview_thumb"> <img src="<?php echo base_url() ?>/public/admin/images/epc.png" class="img-responsive userlogor" /> </div>
                                                            </small> <small class="stat-label">
                                                                <div class="preview_thumb"> <img src="<?php echo base_url() ?>/public/admin/images/tradeindia.png" class="img-responsive userlogor" /> </div>
                                                            </small> </div>
                                                    </div>
                                                    <!-- row -->

                                                    <h4 class="tits">Home Expo India 2014</h4>
                                                    <hr class="preview_mb9">
                                                    <img src="<?php echo base_url() ?>/public/admin/images/common_connections.png" class="img-responsive">
                                                    <address class="preview_address">
                                                        <strong>Venue:</strong> India Expo centre and Mart, Greater Noida, Expressway, New Delhi<br>
                                                        <strong>Email:</strong> homeexpo@epch.com<br>
                                                        <a href="#" target="_blank" class="preview_a"><strong>Website:</strong> www.tradeshow.com</a><br>
                                                    </address>
                                                    <a class="btn btn-success input-sm btn-block preview_mb9" >Download Event Map</a>
                                                    <ul class="list-inline mb5">
                                                        <li><a href="#"><img class="img-responsive" src="<?php echo base_url() ?>/public/admin/images/gallery1.png"></a></li>
                                                        <li><a href="#"><img class="img-responsive" src="<?php echo base_url() ?>/public/admin/images/gallery2.png"></a></li>
                                                        <li><a href="#"><img class="img-responsive" src="<?php echo base_url() ?>/public/admin/images/gallery3.png"></a></li>
                                                    </ul>
                                                    <p class="text-justify">Home Expo India is a composite platform for showcasing India's products for the Home segment, comprising 3 sub shows; Indian Furnishings, Floorings & Textiles Show (IFFTEX); Indian Houseware & Decoratives Show (IHDS) and Indian Furniture & Accessories Show (IFAS).</p>
                                                    <p class="text-justify">More than 600 exhibitors will put their products and services at display and will attract the attention of all major stakeholders of the industry.</p>
                                                    <!---google map integrations----> 


                                                    <!---google map integrations ends---->
                                                    <div class="mb5" style="border:1px solid rgba(0,0,0,0.4); border-radius: 4px; height: 180px" id="map1-canvas"></div>
                                                </div>
                                                <!-- stat --> 
                                            </div>
                                            <!-- col-sm-6 --> 

                                        </div>
                                        <!-- row --> 
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
