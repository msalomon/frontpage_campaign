<?php

define('VIDEOLIST_SUPPORTED_PLATFORMS', 'youtube, vimeo, metacafe, bliptv', 'gisstv');

foreach(explode(', ', VIDEOLIST_SUPPORTED_PLATFORMS) as $videotype){
    include(elgg_get_plugins_path()."frontpage_campaign/lib/$videotype.php");
}

function videolist_parseurl($url){
    foreach(explode(', ', VIDEOLIST_SUPPORTED_PLATFORMS) as $videotype){
        if (is_callable("videolist_parseurl_$videotype")){
            if ($parsed = call_user_func("videolist_parseurl_$videotype", $url)) {
                return $parsed;
            }
        }
    }
    return array();
}

function videolist_get_data($parsed) {
    $videotype = $parsed['videotype'];
    $video_id = $parsed['video_id'];

    if(is_callable("videolist_get_data_$videotype")){
        return array_merge($parsed, call_user_func("videolist_get_data_$videotype", $parsed));
    } else {
        return $parsed;
    }
}
