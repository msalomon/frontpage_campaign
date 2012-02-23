<?php
$campaign_donate=elgg_get_plugin_setting('campaign_donate', 'frontpage_campaign');
$campaign_donate_thankyou_error=elgg_echo('frontpage_campaign:settings:donation_thankyou_error');
if (strtolower($campaign_donate) == strtolower(elgg_echo('frontpage_campaign:settings:yes'))) {
	if ($campaign_donate_thankyou_error) {
		$body .= "<div class='elgg-col elgg-col-1of1' style='margin:10px 0px 0px 0px'>" .$campaign_donate_thankyou_error . "</div><div class='donationWrapper'>";
	}
	
	
	$body .= "<div>";
	$page_content = elgg_view_layout('one_column', array(
            'content' => $body,
	));

	echo elgg_view_page('', $page_content);
}
else {
	echo elgg_view_page('', '.');

}
