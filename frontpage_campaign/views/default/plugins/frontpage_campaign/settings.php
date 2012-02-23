<?php

// ID of admin who is the master of the index-page

$campaign_admin_id = $vars['entity']->campaign_admin_id;



// setting is also used for the array name, so the option-function works also when admin changes the language

$right = elgg_echo('frontpage_campaign:settings:right');
$left = elgg_echo('frontpage_campaign:settings:left');
$head = elgg_echo('frontpage_campaign:settings:head');
$foot = elgg_echo('frontpage_campaign:settings:foot');
$yes = elgg_echo('frontpage_campaign:settings:yes');
$no = elgg_echo('frontpage_campaign:settings:no');

$campaign_big_pic_show = $vars['entity']->campaign_big_pic_show;

// settings are called the first time or not saved

$no_stettings = (empty($campaign_big_pic_show) ? true : false);

$campaign_small_pic_show = $vars['entity']->campaign_small_pic_show;
$campaign_info_position = $vars['entity']->campaign_info_Position;
$campaign_info = $vars['entity']->campaign_info;

// settings are called the first time; so give a hint
if ($no_stettings){
    $campaign_info = elgg_echo('frontpage_campaign:settings:campaign_info_hint');
}

$campaign_events = $vars['entity']->campaign_events;
$campaign_events_position = $vars['entity']->campaign_events_Position;
$campaign_flip_block_show = $vars['entity']->campaign_flip_block_show;
$campaign_flip_block_position = $vars['entity']->campaign_flip_block_position;
$campaign_videos_show = $vars['entity']->campaign_videos_show;
$campaign_recources_show = $vars['entity']->campaign_recources_show;
$campaign_donate_text = $vars['entity']->campaign_donate_text;
$campaign_paypal_code = $vars['entity']->campaign_paypal_code;
$campaign_bank_account = $vars['entity']->campaign_bank_account;
$campaign_facebooksite_og_title = $vars['entity']->campaign_facebooksite_og_title;
$campaign_facebooksite_og_description = $vars['entity']->campaign_facebooksite_og_description;
$campaign_twitter_tag = $vars['entity']->campaign_facebooksite_og_description;
$campaign_donate = $vars['entity']->campaign_donate;
$campaign_donate_text = $vars['entity']->campaign_donate_text;
$campaign_paypal_code = $vars['entity']->campaign_paypal_code;
$campaign_bank_account = $vars['entity']->campaign_bank_account;
$campaign_numberofshownrecources = $vars['entity']->campaign_numberofshownrecources;
$campaign_numberofshownvideos = $vars['entity']->campaign_numberofshownvideos;
$campaign_recource_text = $vars['entity']->campaign_recource_text;




echo "<hr>";

/* echo elgg_echo('frontpage_campaign:settings:admin_id_label');
echo elgg_view('input/text',array('value' => $campaign_admin_id, 'name' => 'params[campaign_admin_id]'));
echo "<br><br><hr>"; */

echo elgg_echo('frontpage_campaign:settings:campaign_info_label') . "<br>";
echo elgg_echo('frontpage_campaign:settings:campaign_info_position_label') . "&nbsp;". "&nbsp;";
echo elgg_view('input/dropdown', array(
        'name' => 'params[campaign_info_position]',
        'value' => (empty($campaign_info_position) ? $foot : $campaign_info_position),
        'options_values' => array(
$left => $left,
$right => $right,
),
));
echo "<br>";
echo elgg_view('input/longtext',array('value' => $campaign_info, 'name' => 'params[campaign_info]'));
echo "<br><hr><br>";

echo elgg_echo('frontpage_campaign:settings:big_pic_show_label') . "&nbsp;". "&nbsp;";
echo elgg_view('input/dropdown', array(
        'name' => 'params[campaign_big_pic_show]',
        'value' => (empty($campaign_big_pic_show) ? $right : $campaign_big_pic_show) ,
        'options_values' => array(
                $left => $left,
                $right => $right,
        ),
));

echo "<br><hr>";



echo elgg_echo('frontpage_campaign:settings:campaign_events_label') . "<br>";
echo elgg_echo('frontpage_campaign:settings:campaign_events_position_label') . "&nbsp;". "&nbsp;";
echo elgg_view('input/dropdown', array(
        'name' => 'params[campaign_events_position]',
        'value' => (empty($campaign_events_position) ? $foot : $campaign_events_position),
        'options_values' => array(
                $head => $head,
                $foot => $foot,
        ),
));
echo "<br>";
echo elgg_view('input/longtext',array('value' => $campaign_events, 'name' => 'params[campaign_events]'));
echo "<br><hr>";

echo elgg_echo('frontpage_campaign:settings:flip_block_show_label') . "&nbsp;". "&nbsp;";
echo elgg_view('input/dropdown', array(
        'name' => 'params[campaign_flip_block_show]',
        'value' => (empty($campaign_flip_block_show) ? $left : $campaign_flip_block_show),
        'options_values' => array(
                $left => $left,
                $right => $right,
        ),
));
echo "&nbsp;&nbsp;";

echo elgg_echo('frontpage_campaign:settings:flip_block_position_label') . "&nbsp;". "&nbsp;";
echo elgg_view('input/dropdown', array(
        'name' => 'params[campaign_flip_block_position]',
        'value' => (empty($campaign_flip_block_position) ? $foot : $campaign_flip_block_position),
        'options_values' => array(
                $head => $head,
                $foot => $foot,
        ),
));
echo "<br><hr>";



echo elgg_echo('frontpage_campaign:settings:recources_label') . "&nbsp;". "&nbsp;";
echo elgg_view('input/dropdown', array(
        'name' => 'params[campaign_recources_show]',
        'value' => (empty($campaign_recources_show) ? $right: $campaign_recources_show),
        'options_values' => array(
$left => $left,
$right => $right,
),
));
echo "&nbsp;&nbsp;";
echo elgg_echo('frontpage_campaign:settings:small_pic_show_label') . "&nbsp;". "&nbsp;";
echo elgg_view('input/dropdown', array(
        'name' => 'params[campaign_small_pic_show]',
        'value' => (empty($campaign_small_pic_show) ? $left : $campaign_small_pic_show),
        'options_values' => array(
$left => $left,
$right => $right,
),
));
echo "&nbsp;&nbsp;";
echo elgg_echo('frontpage_campaign:settings:info_video_show_label') . "&nbsp;". "&nbsp;";
echo elgg_view('input/dropdown', array(
        'name' => 'params[campaign_videos_show]',
        'value' => (empty($campaign_videos_show) ? $left : $campaign_videos_show),
        'options_values' => array(
                $left => $left,
                $right => $right,
        ),
));

echo "<br><hr><br><br>";


echo elgg_echo('frontpage_campaign:settings:campaign_donate_label') . "&nbsp;". "&nbsp;";
echo elgg_view('input/dropdown', array(
        'name' => 'params[campaign_donate]',
        'value' => (empty($campaign_donate) ? $yes: $campaign_donate),
        'options_values' => array(
                $yes => $yes,
                $no => $no,
        ),
));
echo "<br><br>";


echo elgg_echo('frontpage_campaign:settings:donate_text_label');
echo elgg_view('input/longtext',array('value' => $campaign_donate_text, 'name' => 'params[campaign_donate_text]'));

echo "<br><br>";


echo elgg_echo('frontpage_campaign:settings:paypal_code');
echo elgg_view('input/plaintext', array('name'=>'params[campaign_paypal_code]', 'value'=>$campaign_paypal_code));



echo "<br><br>";



echo elgg_echo('frontpage_campaign:settings:bank_account');
echo elgg_view('input/text', array('name'=>'params[campaign_bank_account]', 'value'=>$campaign_bank_account));

echo "<br><br><br><hr><br><br>";

/* echo elgg_echo('frontpage_campaign:settings:campaign_facebooksite_og_title_label');
echo elgg_view('input/text',array('value' => $campaign_facebooksite_og_title, 'name' => 'params[campaign_facebooksite_og_title]'));

echo elgg_echo('frontpage_campaign:settings:campaign_facebooksite_og_description_label');
echo elgg_view('input/text',array('value' => $campaign_facebooksite_og_description, 'name' => 'params[campaign_facebooksite_og_description]'));

echo "<br><br>";

echo elgg_echo('frontpage_campaign:settings:campaign_twitter_tag_label');
echo elgg_view('input/text',array('value' => $campaign_twitter_tag, 'name' => 'params[campaign_twitter_tag]'));

echo "<br><br><hr><br>"; */

/* echo elgg_echo('frontpage_campaign:settings:numberofshownrecources_label');
echo elgg_view('input/text',array('value' => $campaign_numberofshownrecources, 'name' => 'params[campaign_numberofshownrecources]'));


echo "<br><br><hr>";  */

echo elgg_echo('frontpage_campaign:settings:numberofshownvideos_label');
echo elgg_view('input/text',array('value' => $campaign_numberofshownvideos, 'name' => 'params[campaign_numberofshownvideos]'));
echo "<br><br><hr>"; 
$url_adress =  'cic/indexpics';

$link = elgg_view('output/url', array(
		'href' => $url_adress,
		'text' => elgg_echo('frontpage_campaign:settings:here'),
));
if (!$no_stettings){
	echo elgg_echo('frontpage_campaign:settings:view_here',array($link));
}
echo "<br><br><hr><br>";
