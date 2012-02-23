
<?php
/**
 * Flipwall Entry
 *
 * @uses $vars['flip']      frontside of the entry
 * @uses $vars['data']      backside of the entry (displayed when flipped)
 */
$front = elgg_extract('front', $vars, '');
$back  = elgg_extract('back',  $vars, '');
unset($vars['front']);
unset($vars['back']);

$link_title = elgg_echo('flipwall:clicktoflip');
$content = "<div class='flipwall-entry' title='" . $link_title ."'  style='margin:3.5px; margin-bottom:5px;float:left; width:147px; height:147px;'>";
$content .= "<div class='flipwall-entry-front'>" .  $front ."</div>";
$content .= "<div class='flipwall-entry-back'>" . $back ."</div>";
$content .= "</div>";

echo $content;
