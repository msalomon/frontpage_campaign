<?php

$base_url = elgg_get_site_url();
if (elgg_get_context()=='index-page') {
    //$css_path = $base_url . 'mod/frontpage_campaign/vendors/socialshareprivacy/socialshareprivacy/socialshareprivacy.css';
    $lang     = get_language();
    
    $image_url = $base_url . 'mod/frontpage_campaign/vendors/socialshareprivacy/socialshareprivacy/images/';
    $fb_dummy      = $image_url . 'dummy_facebook_en.png';
    $twitter_dummy = $image_url . 'dummy_twitter.png';
    $gplus_dummy   = $image_url . 'dummy_gplus.png';
    ?>
    <script type="text/javascript">
      jQuery(document).ready(function($){
        if($('#socialshareprivacy').length > 0){
          $('#socialshareprivacy').socialSharePrivacy({
    	    services : {
    	        facebook : {
    	            //'dummy_img'         : 'mod/frontpage_campaign/vendors/socialshareprivacy/socialshareprivacy/images/dummy_facebook.png',
    	            'dummy_img'         : '<?php echo $fb_dummy; ?>',
                    'txt_info'          : '<?php echo elgg_echo('socialshareprivacy:services:facebook:txt_info'); ?>',
                    'txt_fb_off'        : '<?php echo elgg_echo('socialshareprivacy:services:facebook:txt_fb_off'); ?>',
                    'txt_fb_on'         : '<?php echo elgg_echo('socialshareprivacy:services:facebook:txt_fb_on'); ?>',
                    'language'          : '<?php echo $lang; ?>',
                    'action'            : 'recommend'
    	    	}, 
    	        twitter : {
    	            'dummy_img'         : '<?php echo $twitter_dummy; ?>',
    	            'txt_info'          : '<?php echo elgg_echo('socialshareprivacy:services:twitter:txt_info'); ?>',
                    'txt_twitter_off'   : '<?php echo elgg_echo('socialshareprivacy:services:twitter:txt_twitter_off'); ?>',
                    'txt_twitter_on'    : '<?php echo elgg_echo('socialshareprivacy:services:twitter:txt_twitter_on'); ?>',
                    'language'          : '<?php echo $lang; ?>'
    	        },
    	        gplus : {
    	            'dummy_img'         : '<?php echo $gplus_dummy; ?>',
    	            'txt_info'          : '<?php echo elgg_echo('socialshareprivacy:services:gplus:txt_info'); ?>',
                    'txt_gplus_off'     : '<?php echo elgg_echo('socialshareprivacy:services:gplus:txt_gplus_on'); ?>',
                    'txt_gplus_on'      : '<?php echo elgg_echo('socialshareprivacy:services:gplus:txt_gplus_on'); ?>',
                    'language'          : '<?php echo $lang; ?>'
    	        }
    	    },
    	    //'css_path'          : '<?php echo ''; //$css_path ?>',
    	    'txt_help'          : '<?php echo elgg_echo('socialshareprivacy:txt_help'); ?>',
            'settings_perma'    : '<?php echo elgg_echo('socialshareprivacy:settings_perma'); ?>'
    	  }); 
        }
      });
    </script>
<?php
}
?>
