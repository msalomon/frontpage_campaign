<?php 
if ($vars['entity']->guid) {
    $content = "<div class='c_i_c_title'>" . elgg_view('output/url', array(
            'text' => elgg_get_excerpt($vars['entity']->title, 50),
            'href' => $vars['entity']->getURL(),
    )) . "</div>";
    $excerpt = elgg_get_excerpt($vars['entity']->description,50);
    $content .= "<div class='c_i_c_subtitle'> $excerpt $comments_link</div>";

    if (Trim($vars['entity']->opt_pic) ==  trim(elgg_echo('frontpage_campaign:opt_pic_label')) ){
        $opt_icon =  "<a href='" . $vars['entity']->getURL() ."'><img src='" . $CONFIG->wwwroot ."mod/frontpage_campaign/icon.php?recourcesguid=" . $vars['entity']->guid ."&size=medium'></a>";
    }
    else {
        $vars['size'] = "medium";
        $img = elgg_view('output/img', array(
                'src' => $vars['entity']->getIconURL($vars['size']),
                'alt' => 'recources',
        ));
        $opt_icon = $img;
    }
    $comments_count = $vars['entity']->countComments();
    //only display if there are commments
    if ($comments_count != 0) {
    	$text = elgg_echo("comments") . " ($comments_count)";
    	$comments_link =  elgg_view('output/url', array(
                'href' => $vars['entity']->getURL() ,
                'text' => $text,
    	));
    	$content = $content ."<div class='c_i_c_subcomments'>" .$comments_link ."</div>";
    } 
    echo "<div class='elgg-col elgg-col-1of2'>" . elgg_view_image_block($opt_icon, $content) . '</div>';
    
}
