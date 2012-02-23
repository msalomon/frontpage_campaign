<?php



// Get plugin settings

$campaign_paypal_code = elgg_get_plugin_setting("campaign_paypal_code","frontpage_campaign");
$campaign_bank_account = elgg_get_plugin_setting("campaign_bank_account","frontpage_campaign");
$campaign_donate=elgg_get_plugin_setting('campaign_donate', 'frontpage_campaign');
$campaign_donate_text=elgg_get_plugin_setting('campaign_donate_text', 'frontpage_campaign');

if (strtolower($campaign_donate) == strtolower(elgg_echo('frontpage_campaign:settings:yes'))) {
    if ($campaign_donate_text) {
        $body .= "<div class='elgg-col elgg-col-1of1' style='margin:10px 0px 0px 0px'>" .$campaign_donate_text . "</div><div class='donationWrapper'><center>";
    }
    else {
        $body .= "<div class='sidebarBox'>" . $campaign_donate_text . "</div>";
        $body .= "<div class='sidebarBox'><h3 style='margin:10px 0px 0px 0px' >" . sprintf(elgg_echo('frontpage_campaign:settings:donation_title'), elgg_get_config('sitename')) . "</h3>";
        $body .= "<center>" . sprintf(elgg_echo('frontpage_campaign:settings:donation_desc'), elgg_get_config('sitename')) . "<br><br>";
    }
    if($campaign_paypal_code){
        $body .= elgg_echo('frontpage_campaign:settings:donation_paypal') ."<br><br>";
        $body .= "<div class='donationButton'><center>" . $campaign_paypal_code . "</center></div>";
    }
    if($campaign_bank_account){
        $body .= "<br>" .elgg_echo('frontpage_campaign:settings:donation_banktransfer');
        $body .= "<br><br>" . sprintf(elgg_echo('frontpage_campaign:settings:donation:bank_account:text'),$campaign_bank_account) . "<br><br>";
    }

    $body .= "<br>";
    $body .= "</div>";
    if (!$campaign_donate_text) {
        $body .= "</div>";
    }
    $page_content = elgg_view_layout('one_column', array(
            'content' => $body,
    ));

    echo elgg_view_page('', $page_content);
}
else {
    echo elgg_view_page('', '.');

}