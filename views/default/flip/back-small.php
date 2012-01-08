
<?php

$file = $vars['entity'];

$content = '';

// check for file entity
if(elgg_instanceof($file, 'object','file', 'ElggFile')) {
	$description = $file->description;

	$content = <<<HTML
	<div style='float:left;'>
	<div class="flipwall-description" style='font-size:10px; font-weight:normal;line-height:12px'>$description</div>

	</div>
HTML;
}

echo  $content;