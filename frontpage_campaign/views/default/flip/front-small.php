
<?php

$file = $vars['entity'];
$image_url = elgg_get_site_url() . "mod/file/thumbnail.php?file_guid={$vars['entity']->getGUID()}&size=large";
$image_url = elgg_format_url($image_url);
$content = '';

// check for File entity
if(elgg_instanceof($file, 'object', 'file', 'ElggFile')) {
    $img     = $image_url;
    $img_alt = elgg_echo('flipwall:moreabout');

    $content = "<img src='" . $img ."' style='float:left; width:147px; height:147px;' title='" . $img_alt ."'>" ;
}

echo  $content;

