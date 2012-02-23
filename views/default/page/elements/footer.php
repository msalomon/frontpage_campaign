<?php
/**
 * Elgg footer
 * The standard HTML footer that displays across the site
 *
 * @package Elgg
 * @subpackage Core
 *
 */

echo elgg_view_menu('footer', array('sort_by' => 'priority', 'class' => 'elgg-menu-hz'));

$donationpage =  "cic/supportthis";

$supportthis_url = elgg_get_site_url() . 'mod/frontpage_campaign/graphics/donate.gif';
//$supportthis_url= str_replace("http:", "https:", $supportthis_url);
$powered_url = elgg_get_site_url() . "_graphics/powered_by_elgg_badge_light_bckgnd.gif";
echo '<div class="mts clearfloat float-alt">';

if (strtolower(elgg_get_plugin_setting('campaign_donate', 'frontpage_campaign')) == strtolower(elgg_echo('frontpage_campaign:settings:yes'))) {
    echo elgg_view('output/url', array(
            'href' => $donationpage ,
            'text' => "<img src=\"$supportthis_url\" title=\"SUPPORT THIS\" width=\"106\" height=\"15\" />",
            'is_trusted' => true,
    ));
}
echo elgg_view('output/url', array(
        'href' => 'http://elgg.org',
        'text' => "&nbsp;&nbsp;" ."<img src=\"$powered_url\" title=\"Powered by Elgg\" width=\"106\" height=\"15\" />",
        'is_trusted' => true,
));
echo '</div>';
