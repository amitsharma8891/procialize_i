<style type="text/css">
            .truncate {
                width: 100%;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
            }
            /*setting*/
            <?php 
                if(getSetting()->app_background_image && file_exists(UPLOADS.'app_background/'.getSetting()->app_background_image)){
            ?>
            .page-background {background-image: url("<?php echo SITE_URL . 'uploads/app_background/' . getSetting()->app_background_image ?>");}
                <?php }else { ?>
            .page-background {background-color:#DDDFE1} 
                <?php }?>
            /*primary color - getSetting()->app_primary_color
              secondary color - getSetting()->app_secondary_color
            */
            .headerbar{background:none repeat scroll 0 0 <?php echo getSetting()->app_primary_color?>/*#000000*/!important;border-left:1px solid <?php echo getSetting()->app_secondary_color?> !important}/*p*/
            .right-compose{background: none repeat scroll 0 0 <?php echo getSetting()->app_primary_color?>/*#000000*/!important;}/*p*/
            .logopanel_button{background: none repeat scroll 0 0 <?php echo getSetting()->app_primary_color?>/*#000000*/!important;}/*p*/
            .leftpanel .logopanel_button a .btn-success{/*color:#000; border: 1px solid #ccc;*/ background: <?php echo getSetting()->app_secondary_color?>/*#eee*/!important;}/*s*/
            .headermenu .tp-icon{color:<?php echo getSetting()->app_secondary_color?>/*#000*/!important; background: <?php echo getSetting()->app_primary_color?>/*#eee*/!important;border-color:<?php echo getSetting()->app_primary_color?> !important;}
            .pageheader .navtop .photo-meta .active{background: none repeat scroll 0 0 <?php echo getSetting()->app_secondary_color?>/*#eee*/!important;}/*s*/
            .panel-stat .panel-event .panel-heading{background-color: <?php echo getSetting()->app_secondary_color?>/*#eee*/ !important;}/*s*/
            .col-xs-6 .btn-success{/*color:<?php //echo getSetting()->app_primary_color?>/*#000000!important;*/ /*border: 1px solid #ccc;*/ background: <?php echo getSetting()->app_secondary_color?>/*#eee*/!important;}/*s*/
            .btn-success{/*color:#000;*/ border: 1px solid <?php echo getSetting()->app_primary_color?> !important; background: <?php echo getSetting()->app_secondary_color?>/*#eee*/!important;}/*s*/
            .navtop li.active, .navtop li:active {background: <?php echo getSetting()->app_secondary_color?>/*#eee*/!important;;}
            .logopanel {background: none repeat scroll 0 0 <?php echo getSetting()->app_primary_color?>/*#58bbc2*/ !important;}
            .headermenu .dropdown-toggle{background: none repeat scroll 0 0 <?php echo getSetting()->app_primary_color?>/*#58bbc2*/ !important;}
            .menutoggle{border-right: 1px solid <?php echo getSetting()->app_primary_color?>/*#45a2a8 */!important; color:<?php echo getSetting()->app_secondary_color?> !important;}
            .panel-stat .panel-event .panel-heading{background:<?php echo getSetting()->app_secondary_color?>}
            /*.headermenu > li {border-left: 1px solid <?php //echo getSetting()->app_secondary_color?>/*#45a2a8 !important;}*/
            .nav-bracket .children > li > a:hover, .nav-bracket .children > li > a:active, .nav-bracket .children > li > a:focus{color:<?php echo getSetting()->app_secondary_color?> !important}
            .nav>li>a:hover, .nav>li>a:focus{color:<?php echo getSetting()->app_secondary_color?> !important}
            .headermenu .dropdown-menu li a:hover{background: none repeat scroll 0 0 <?php echo getSetting()->app_primary_color?>/*#58bbc2*/ !important;}
            .badge-success{background: none repeat scroll 0 0 <?php echo getSetting()->app_primary_color?>/*#58bbc2*/ !important;}
            .panel-stat .panel-event .panel-heading{background-color:<?php echo getSetting()->app_primary_color?> !important}
            .wc-cal-event{background:<?php echo getSetting()->app_primary_color?> !important};
            .wc-cal-event .wc-time{background:<?php echo getSetting()->app_secondary_color?> !important;}
            .wc-toolbar button{background: <?php echo getSetting()->app_secondary_color?> !important;}
            
</style>