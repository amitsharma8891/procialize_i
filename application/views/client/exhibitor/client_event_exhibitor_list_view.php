<!---client header view--->
<?php $this->load->view(CLIENT_HEADER) ?>

<!---client header view--->
<style>
    ul.multiselect-container{ width: 100% !important;}
    input.multiselect-search{ padding: 12px !important;}
    .glyphicon{ font-size:15px!important; padding:0 7px !important;}
</style>

<!----event top navigation---->
<?php $this->load->view(EVENT_TOP_NAVIGATION) ?>
<!----event top navigation---->
<script src="<?php echo base_url(); ?>public/client/js/bootstrap-multiselect.js"></script>
<script href="<?php echo base_url(); ?>public/client/css/bootstrap-multiselect.css" rel="stylesheet"></script>
<div class="form-group" style="margin-bottom: 0px;">
    <div class="col-sm-6">

        <input type="text" id="search_user" onkeyup="serach_user('exhibitor')" class="form-control input-sm mt18" placeholder="Search Name, Industry, Functionality, Product Category, Location" style="padding: 11px 20px 11px 10px;">

    </div>
    <div class="col-sm-6 mt18">


        <select  id="exhibitor_id" name="exhibitor_id" class="form-control" multiple="multiple"> 
            <?php
            $seletcted = "";

            foreach ($product_category_list as $key => $value) {
                ?>
                <option value = "<?php echo $value['id'] ?>"><?php echo $value['name']; ?></option>

                <?php
            }
            ?>

        </select>

    </div>



</div>
</div>


<div class="contentpanel">
    <div class="panel panel-default panel-stat">
        <div class="">

            <div class="row" id="ajax_attendee">
                <script type="text/javascript">
                    var SITE_URL = '<?php echo SITE_URL; ?>';
                    $(document).ready(function()
                    {

                        $('#exhibitor_id').multiselect({
                            buttonWidth: '100%',
//                            ulWidth: '100%',
                            maxHeight: 300,
                            includeSelectAllOption: true,
                            enableFiltering: true
                        });
                        //col-sm-6
                        var width = screen.width
                        $(".changeListClass").removeClass('col-sm-6 col-md-3');
                        if (width <= 1024)
                        {
                            //alert(width+'in if');
                            $(".changeListClass").addClass('col-sm-12 col-md-12');
                        }
                        else
                        {
                            //alert(width+'in else');
                            $(".changeListClass").addClass('col-sm-12 col-md-12');
                        }

                        $(".input-group-addon").click(function() {
                            var search_category_list = $("#exhibitor_id").val();

                            $.ajax({
                                type: 'POST',
                                url: '<?php echo SITE_URL; ?>' + "client/event/search_user",
                                dataType: 'json',
                                data: {
                                    search_category_list: search_category_list
                                },
                                success: function(res)
                                {
                                    var val = eval(res);
                                    $(".user_list_loader").hide();
                                    $(".user_list_loader").html('');
//                                    if (scroll == 'scroll')
//                                        $("#ajax_attendee").append(val.user);
//                                    else
                                        $("#ajax_attendee").html(val.user);
                                }
                            });
                        });
                    })
                </script>
                <?php
                if ($exhibitor_list) {
                    //display($exhibitor_list);
                    foreach ($exhibitor_list as $key => $value) {
                        ?>  
                        <div class="col-sm-12 col-md-4 changeListClass">

                            <div class="stat well well-sm exhbt">
                                <a href="<?php echo SITE_URL . 'events/exhibitor-detail/' . $value['attendee_id'] ?>">
                                    <div class="row">
                                        <div class="col-xs-4">
                                            <div class="thumb">
                                                <img src="<?php echo SITE_URL . 'uploads/' . front_image('exhibitor', $value['exhibitor_logo']) ?>" alt="" class="img-responsive userlogo"/>
                                            </div>
                                        </div>
                                        <div class="col-xs-8 eventdet">
                                            <?php if ($value['exhibitor_featured'] == 1) { ?>	
                                                <span class="pull-right mr10">
                                                    <p class="featured_icon"><i class="fa fa-bookmark"></i></p>
                                                </span>
                                            <?php } ?>

                                            <h4><?php echo ucwords(strtolower($value['exhibitor_name'])) ?></h4>
                                            <small class="stat-label"><?php echo $value['exhibitor_city'] . ', ' . $value['exhibitor_country'] ?></small>
                                            <small class="stat-label"><?php echo $value['exhibitor_industry'] ?></small>
                                            <small class="stat-label"><?php echo $value['exhibitor_product_category'] ?></small>
                                            <?php if ($value['stall_number']) { ?>
                                                <small class="stat-label">Stall Number: <strong><?php echo $value['stall_number'] ?></strong></small>
                                            <?php } ?>
                                        </div>

                                    </div><!-- row -->
                                </a>

                                                                                                                                                                                                                                        <!--<p class="exinfo"><strong>Website:</strong> www.infinisystem.com</p>-->

                                <?php if ($value['exhibitor_featured'] == 1 && $value['exhibitor_website']) { ?>
                                    <hr>
                                    <!--<p class="exinfo"><strong>Email:</strong> <?php //echo $value['exhibitor_email']                             ?></p>-->
                                    <p class="exinfo"><strong>Website:</strong> <?php echo $value['exhibitor_website'] ?></p>
                                <?php } ?>

                            </div><!-- stat -->
                        </div><!-- col-sm-6 -->
                        <?php
                    }
                } else {
                    echo '<div class="col-sm-6 col-md-3">No Data Found!</div>';
                }
                ?>







            </div><!-- row -->
        </div>
    </div>
</div><!-- contentpanel -->

</div><!-- mainpanel -->

<div class="rightpanel">

    <!--Right panel view--->
    <?php $this->load->view(CLIENT_RIGHT_PANEL) ?>
    <!--Right panel view--->

</div><!-- rightpanel -->


</section>
<script type="text/javascript">


    var count = 1;
    var scroll = 'scroll';
    //alert('122');
    $(window).scroll(function() {
        //alert('122');
        if ($(window).scrollTop() == $(document).height() - $(window).height()) {
            //loadArticle(count);
            //alert('scroll');
            serach_user('exhibitor', count, scroll);
            count++;
        }
    });

    function loadArticle(pageNumber)
    {
        alert(pageNumber);
        /*$.ajax({
         url: "<?php //bloginfo('wpurl')                              ?>/wp-admin/admin-ajax.php",
         type:'POST',
         data: "action=infinite_scroll&page_no="+ pageNumber + '&loop_file=loop', 
         success: function(html){
         $("#content").append(html);   // This will be the div where our content will be loaded
         }
         });*/
        return false;
    }

</script>
<!--<script type="text/javascript" src="<?php echo CLIENT_PLUGINS ?>infiniteScroll/scroll.js"></script>-->
<?php $this->load->view(CLIENT_FOOTER) ?>
