
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

$content = <<<HTML
<div class="flipwall-entry" style='margin:3.5px; margin-bottom:5px;float:left; width:147px; height:147px;'>
<div class="flipwall-entry-front" >$front</div>
<div class="flipwall-entry-back" >$back</div>
</div>
HTML;

echo $content;
