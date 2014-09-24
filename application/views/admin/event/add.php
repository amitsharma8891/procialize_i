<?php // echo $arrResult->paymnet_type; die;                          ?>

<div class="contentpanel"><!-- Content Panel -->
    <div class="row mb10"><!-- Add Exhibitor Row -->
        <?php
        if (isset($error)) {
            echo $error;
        }
        ?>
        <?php echo validation_errors('<div class="form-validation-error">', '</div>'); ?>

        <?php echo generateFormHtml($fields); ?>
    </div>
</div>
<style>
    .chosen-container-single-nosearch{ width: 311px !important;}
    .paymnt_type_class{
        display: none;
    }
    .payment_url{
        display: none;
    }
    .event_cost{
        display: none;
    }
</style>
<script>
    $(document).ready(function() {
        var paid_val_onload = $(".paid_event").val();
        var paymnet_type = $(".payment_type").val();
        if (paid_val_onload == 1) {
            if (paymnet_type == 1) {
                $(".paymnt_type_class").show();
                $(".payment_url").show();
                $(".event_cost").show();
            } else {
                $(".paymnt_type_class").show();
                $(".event_cost").show();
                $(".payment_url").hide();
            }
        } else {
            $(".event_cost").hide();
            $(".paymnt_type_class").hide();
            $(".payment_url").hide();
        }
        $('.payment_type').change(function() {
            var paymnet_type = $(this).val();
            if (paymnet_type == 1) {
                $(".payment_url").show();
                $(".event_cost").show();
            } else {
                $(".event_cost").show();
                $(".payment_url").hide();
            }
        });
        $('.paid_event').change(function() {
            var paid_val = $(".paid_event").val();
            if (paid_val == 1) {
                $(".paymnt_type_class").show();
                $(".event_cost").show();
            } else {
                $(".event_cost").hide();
                $(".paymnt_type_class").hide();
                $(".payment_url").hide();

            }
        });
//        $(".paymnt_type_class").show();
//        var urlregex = new RegExp("^(?!www | www\.)[A-Za-z0-9_-]+\.+[A-Za-z0-9.\/%&=\?_:;-]+$")
////        return urlregex.test(url);
//        $("#btnSave").click(function() {
//            var payment_url_value = $("#payment_url").val();
////            if (!urlregex.test(payment_url_value)) {
//
//            if (preg_match(urlregex, payment_url_value)) {
//                alert('ljhglkhglkh');
//                return false;
//
//            } else {
//                alert('ggggggggggggggggg');
//            }
//        });
//          $(".paymnt_type_class").show();

    });


</script>
