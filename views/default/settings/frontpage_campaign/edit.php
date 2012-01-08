<?php

$campaign_admin_id=$vars['entity']->campaign_admin_id;
$campaign_twitter_tag=$vars['entity']->campaign_twitter_tag;
$campaign_events=$vars['entity']->campaign_events;
$campaign_facebooksite_og_title=$vars['entity']->campaign_facebooksite_og_title;
$campaign_facebooksite_og_description=$vars['entity']->campaign_facebooksite_og_description;
$campaign_facebooksite_og_site_image=$vars['entity']->campaign_facebooksite_og_site_image;
$numberofshownvideos=$vars['entity']->numberofshownvideos;
?>
<hr>
<?php
echo elgg_echo('frontpage_campaign:settings:admin_id_label');
echo elgg_view('input/text',array('value' => $campaign_admin_id, 'internalname' => 'params[campaign_admin_id]'));
?>
<br>
<hr>
<?php
echo elgg_echo('frontpage_campaign:settings:campaign_events_label');
echo elgg_view('input/longtext',array('value' => $campaign_events, 'internalname' => 'params[campaign_events]'));
?>
<br>
<hr>
<?php
echo elgg_echo('frontpage_campaign:settings:campaign_facebooksite_og_title_label');
echo elgg_view('input/text',array('value' => $campaign_facebooksite_og_title, 'internalname' => 'params[campaign_facebooksite_og_title]'));
?>
<br>
<hr>
<?php
echo elgg_echo('frontpage_campaign:settings:campaign_facebooksite_og_description_label');
echo elgg_view('input/text',array('value' => $campaign_facebooksite_og_description, 'internalname' => 'params[campaign_facebooksite_og_description]'));
?>
<br>
<hr>
<?php
echo elgg_echo('frontpage_campaign:settings:campaign_twitter_tag_label');
echo elgg_view('input/text',array('value' => $campaign_twitter_tag, 'internalname' => 'params[campaign_twitter_tag]'));
?>
<br>
<hr>
<?php
echo elgg_echo('frontpage_campaign:settings:campaign_facebooksite_og_site_image_label');
echo elgg_view('input/text',array('value' => $campaign_facebooksite_og_site_image, 'internalname' => 'params[campaign_facebooksite_og_site_image]'));
?>
<br>
<hr>
<?php
echo elgg_echo('frontpage_campaign:settings:numberofshownvideos_label');
echo elgg_view('input/text',array('value' => $numberofshownvideos, 'internalname' => 'params[numberofshownvideos]'));
?>
<br>
<hr>
