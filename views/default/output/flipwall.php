
<?php
/**
 * A Flipwall
 *
 * @uses $vars['values']      an array of arrays with 2 values (front, back)
 * @uses $vars['shuffle']     whether the array should be shuffled
 */
$values  = elgg_extract('values',  $vars, '');
$shuffle = elgg_extract('shuffle', $vars, false);

unset($vars['values']);

if(!is_array($values) || empty($values)) {
	return true;
}

// shuffle values if requested
if($shuffle == true) {
	shuffle($values);
}

$content = '';
foreach($values as $entry) {
	$content .= elgg_view('output/flipwall-entry', array(
		'front' => $entry['front'],
		'back'  => $entry['back'],
	));
}

// output the view
if(!empty($content)) {
	$content =  <<<HTML
<div class="flipwall-entry-list-holder">
$content
	<div class="clear"></div>
</div>
HTML;

}

echo $content;

