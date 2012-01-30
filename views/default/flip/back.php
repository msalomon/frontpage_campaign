
<?php

$file = $vars['entity'];

$content = '';

// check for file entity
if(elgg_instanceof($file, 'object','file', 'ElggFile')) {
    $description = $file->description;

    $content = "<div style='float:left;'><div class='flipwall-description'>$description</div></div>";

}

echo  $content;