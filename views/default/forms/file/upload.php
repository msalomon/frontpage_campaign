<?php
/**
 * Elgg file upload/save form
 *
 * @package ElggFile
 */
Global $CONFIG;

// once elgg_view stops throwing all sorts of junk into $vars, we can use
    $opt_pic = elgg_extract('opt_pic', $vars, '');
    $show_onindex = elgg_extract('show_onindex', $vars, '');
    $is_recources = elgg_extract('is_recources', $vars, '');
    $file_sort = elgg_extract('file_sort', $vars, '');
    $show_asblock = elgg_extract('show_asblock', $vars, '');
    $is_facebook = elgg_extract('is_facebook', $vars, '');
    $show_bigorsmall = elgg_extract('show_bigorsmall', $vars, '');
$title = elgg_extract('title', $vars, '');
$desc = elgg_extract('description', $vars, '');
$tags = elgg_extract('tags', $vars, '');
$access_id = elgg_extract('access_id', $vars, ACCESS_DEFAULT);
$container_guid = elgg_extract('container_guid', $vars);
if (!$container_guid) {
    $container_guid = elgg_get_logged_in_user_guid();
}
$guid = elgg_extract('guid', $vars, null);

if ($guid) {
    $file_label = elgg_echo("file:replace");
    $submit_label = elgg_echo('save');
    $entitiy = get_entity($guid) ;
    $opt_pic = $entitiy->opt_pic;
    $show_onindex = $entitiy->show_onindex;
    $is_recources = $entitiy->is_recources;
    $file_sort = $entitiy->file_sort;
    $show_asblock = $entitiy->show_asblock;
    $is_facebook = $entitiy->is_facebook;
    $show_bigorsmall  = $entitiy->show_bigorsmall;
} else {
    $file_label = elgg_echo("file:file");
    $submit_label = elgg_echo('upload');
}


?>

<div>
	<label><?php echo $file_label; ?> </label><br />
	<?php echo elgg_view('input/file', array('name' => 'upload')); ?>
</div>
<div>
	<label><?php echo elgg_echo('title'); ?> </label><br />
	<?php echo elgg_view('input/text', array('name' => 'title', 'value' => $title)); ?>
</div>
<div>
	<label><?php echo elgg_echo('description'); ?> </label>
	<?php echo elgg_view('input/longtext', array('name' => 'description', 'value' => $desc)); ?>
</div>
<hr>


<hr>
<div>
	<label><?php echo elgg_echo('tags'); ?> </label>
	<?php echo elgg_view('input/tags', array('name' => 'tags', 'value' => $tags)); ?>
</div>
<?php

$categories = elgg_view('input/categories', $vars);
if ($categories) {
    echo $categories;
}

?>
<div>
	<label><?php echo elgg_echo('access'); ?> </label><br />
	<?php echo elgg_view('input/access', array('name' => 'access_id', 'value' => $access_id)); ?>
</div>
<br>
<?php 
if(elgg_is_admin_logged_in()){
    echo "<div style='color:red'> Only visible for Admin. </div>";
    echo elgg_view("input/checkboxes", array(
            'options' => array(elgg_echo('frontpage_campaign:show_onindex_label') => elgg_echo('frontpage_campaign:show_onindex_label')),
            'name' => 'show_onindex',
            'value' =>  ($show_onindex == false ? 'not checked' : elgg_echo('frontpage_campaign:show_onindex_label')),
    )) ;

    ?>
<div>
	<label> <?php echo $group_option->label; ?><br />
	</label>
	<?php echo elgg_view("input/radio", array(
	        "name" => 'show_bigorsmall',
	        "value" => ($show_bigorsmall ? $show_bigorsmall : elgg_echo('flipwall:bigpic')),
	        'options' => array(
	                elgg_echo('flipwall:smallpic') => elgg_echo('flipwall:smallpic') ,
	                elgg_echo('flipwall:bigpic') => elgg_echo('flipwall:bigpic') ,
					elgg_echo('flipwall:nopic') => elgg_echo('flipwall:nopic') ,
	        ),
	));
	?>
</div>
<?php 

echo elgg_view("input/checkboxes", array(
        'options' => array(elgg_echo('frontpage_campaign:show_asblock_label') => elgg_echo('frontpage_campaign:show_asblock_label')),
        'name' => 'show_asblock',
        'value' => ($show_asblock == false ? "not checked" : elgg_echo('frontpage_campaign:show_asblock_label') ),
)) ;

echo "<br>";




 

echo elgg_view("input/checkboxes", array(
        'options' => array(elgg_echo('frontpage_campaign:is_facebook_label') => elgg_echo('frontpage_campaign:is_facebook_label')),
        'name' => 'is_facebook',
        'value' => ($is_facebook == false ? 'not checked' : elgg_echo('frontpage_campaign:is_facebook_label')),
)) ;

?>


<br>

<div>

	<br> <label><?php echo elgg_echo("frontpage_campaign:file_sort_label"); ?>
	</label><br />
	<?php echo elgg_view('input/text', array('name' => 'file_sort', 'value' => $file_sort)); ?>
</div>
<br>
 <?php 


echo elgg_view("input/checkboxes", array(
        'options' => array(elgg_echo('frontpage_campaign:is_recources_label') => elgg_echo('frontpage_campaign:is_recources_label')),
        'name' => 'is_recources',
        'value' =>  ($is_recources == false ? 'not checked' : elgg_echo('frontpage_campaign:is_recources_label')),
)) ;

?> 
<br>
<?php 

echo elgg_view("input/checkboxes", array(
        'options' => array(elgg_echo('frontpage_campaign:opt_pic_label') => elgg_echo('frontpage_campaign:opt_pic_label')),
        'name' => 'opt_pic',
        'value' =>  ($opt_pic == false ? 'not checked' : elgg_echo('frontpage_campaign:opt_pic_label')),
)) ;

if (($opt_pic ==  trim(elgg_echo('frontpage_campaign:opt_pic_label')) && $guid    )) {
	$opt_icon =  "<a href='" . $vars['entity']->getURL() ."'><img src='" . $CONFIG->wwwroot ."mod/frontpage_campaign/icon.php?recourcesguid=" . $vars['entity']->guid ."&size=medium'></a>";
}
else {
	
	$vars['size'] = "small";
	if ($guid)    {
		$img = elgg_view('output/img', array(
	                'src' => $vars['entity']->getIconURL($vars['size']),
	                'title' => 'recources',
		));
		$opt_icon = $img;
	}
	
}
echo $opt_icon;
?>

<div>
	<label><?php echo elgg_echo("frontpage_campaign:file_pic_opt"); ?> </label><br />
	<?php echo elgg_view('input/file', array('name' => 'upload_opt')); ?>
</div>
<?php 
}
?>
<div class="elgg-foot">
	<?php

	echo elgg_view('input/hidden', array('name' => 'container_guid', 'value' => $container_guid));

	if ($guid) {
	    echo elgg_view('input/hidden', array('name' => 'file_guid', 'value' => $guid));
	}

	echo elgg_view('input/submit', array('value' => $submit_label));

	?>
</div>
