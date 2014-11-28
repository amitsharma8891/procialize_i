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
<script>
    $('document').ready(function() {
//         $('#city').find('option').val().remove().end();
        $('#country').change(function() {
            var SITE_URL = '<?php echo SITE_URL; ?>';
            var html_val = new Array();
            var country_id = $(this).val();
            $.ajax({
                type: "POST",
                url: SITE_URL + "manage/place/get_city",
                dataType: "json",
                data: {
                    'country_id': country_id,
                },
                success: function(res)
                {
                    $.each(res.city_list, function(index, value) {
                        var temp = '<option value = "' + value.name + '" >' + value.name + '</option>';
                        html_val.push(temp);
                    });
                    $('#city').find('option').remove().end();
                    $('#city').append(html_val);
                    $("#city").trigger("chosen:updated");
//                    console.clear();
                }
            });
        });
    });
</script>

