<?php

$campaign_admin_id=$vars['entity']->campaign_admin_id;
$campaign_twitter_tag=$vars['entity']->campaign_twitter_tag;
$campaign_events=$vars['entity']->campaign_events;
$campaign_facebooksite_og_title=$vars['entity']->campaign_facebooksite_og_title;
$campaign_facebooksite_og_description=$vars['entity']->campaign_facebooksite_og_description;
$campaign_facebooksite_og_site_image=$vars['entity']->campaign_facebooksite_og_site_image;
$campaign_numberofshownvideos=$vars['entity']->campaign_numberofshownvideos;
$campaign_donate=$vars['entity']->campaign_donate;
$campaign_donate_text=$vars['entity']->campaign_donate_text;
$campaign_paypal_code = $vars['entity']->campaign_paypal_code;
$campaign_bank_account = $vars['entity']->campaign_bank_account;


echo elgg_echo('frontpage_campaign:settings:admin_id_label');
echo elgg_view('input/text',array('value' => $campaign_admin_id, 'name' => 'params[campaign_admin_id]'));
echo "<br /><hr>";
echo "<br>";


echo elgg_echo('frontpage_campaign:settings:campaign_events_label') . "<br>";
echo elgg_view('input/longtext',array('value' => $campaign_events, 'name' => 'params[campaign_events]'));

echo "<br /><hr><br />";
echo elgg_echo('frontpage_campaign:settings:info_pic_show_label') . "&nbsp;". "&nbsp;";
echo elgg_view('input/dropdown', array(
        'name' => 'params[campaign_info_pic_show]',
        'value' => $vars['entity']->campaign_info_pic_show,
        'options_values' => array(
                'left' => elgg_echo('frontpage_campaign:settings:left'),
                'right' => elgg_echo('frontpage_campaign:settings:right'),
        ),
));
echo "<br /><br /><hr><br />";

echo elgg_echo('frontpage_campaign:settings:campaign_donate_label') . "&nbsp;". "&nbsp;";
echo elgg_view('input/dropdown', array(
        'name' => 'params[campaign_donate]',
        'value' => $vars['entity']->campaign_donate,
        'options_values' => array(
                'yes' => elgg_echo('frontpage_campaign:settings:donate_yes'),
                'no' => elgg_echo('frontpage_campaign:settings:donate_no'),
        ),
));
echo "<br><br>";


echo elgg_echo('frontpage_campaign:settings:donate_text_label');
echo elgg_view('input/longtext',array('value' => $campaign_donate_text, 'name' => 'params[campaign_donate_text]'));
?>
<br>
<br>

<?php
echo elgg_echo('frontpage_campaign:settings:paypal_code');
echo elgg_view('input/plaintext', array('name'=>'params[campaign_paypal_code]', 'value'=>$campaign_paypal_code));
?>


<br />
<br />


<?php
echo elgg_echo('frontpage_campaign:settings:bank_account');
echo elgg_view('input/text', array('name'=>'params[campaign_bank_account]', 'value'=>$campaign_bank_account));
?>




<br>
<br>
<hr>
<br>













<?php
echo elgg_echo('frontpage_campaign:settings:campaign_facebooksite_og_title_label');
echo elgg_view('input/text',array('value' => $campaign_facebooksite_og_title, 'name' => 'params[campaign_facebooksite_og_title]'));
?>
<br>
<br>







<?php
echo elgg_echo('frontpage_campaign:settings:campaign_facebooksite_og_description_label');
echo elgg_view('input/text',array('value' => $campaign_facebooksite_og_description, 'name' => 'params[campaign_facebooksite_og_description]'));
?>
<br>
<br>







<?php
echo elgg_echo('frontpage_campaign:settings:campaign_twitter_tag_label');
echo elgg_view('input/text',array('value' => $campaign_twitter_tag, 'name' => 'params[campaign_twitter_tag]'));
?>
<br>
<br>







<?php
echo elgg_echo('frontpage_campaign:settings:campaign_facebooksite_og_site_image_label');
echo elgg_view('input/text',array('value' => $campaign_facebooksite_og_site_image, 'name' => 'params[campaign_facebooksite_og_site_image]'));
?>


<br>
<br>
<hr>






<?php
echo elgg_echo('frontpage_campaign:settings:numberofshownvideos_label');
echo elgg_view('input/text',array('value' => $campaign_numberofshownvideos, 'name' => 'params[campaign_numberofshownvideos]'));
?>
<br>
<hr>
