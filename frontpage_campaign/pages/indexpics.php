<?php
$params = array(
        'type' => 'object',
        'subtype' => 'file',
        'limit' => 100,
		"metadata_name_value_pairs" => array(
array(
										'name' => "is_facebook",
										'value' => elgg_echo('frontpage_campaign:is_facebook_label'),
										'operand' => '='
),

),
				'metadata_name_value_pairs_operator' => 'AND',
		'order_by_metadata' => array('name' => 'file_sort', 'direction' => ASC)
);


$share_pic = elgg_list_entities_from_metadata($params);

$params = array(
        'type' => 'object',
        'subtype' => 'file',
		"metadata_name_value_pairs" => array(
array(
										'name' => "show_onindex",
										'value' => elgg_echo('frontpage_campaign:show_onindex_label'),
										'operand' => '='
),
array(
										'name' => "show_bigorsmall",
										'value' => elgg_echo('flipwall:bigpic'),
										'operand' => '='
),
),
				'metadata_name_value_pairs_operator' => 'AND',
		'order_by_metadata' => array('name' => 'file_sort', 'direction' => ASC)
);


$big_flip_pics = elgg_list_entities_from_metadata($params);


$params = array(
        'type' => 'object',
        'subtype' => 'file',
		"metadata_name_value_pairs" => array(
array(
										'name' => "show_onindex",
										'value' => elgg_echo('frontpage_campaign:show_onindex_label'),
										'operand' => '='
),
array(
										'name' => "show_bigorsmall",
										'value' => elgg_echo('flipwall:smallpic'),
										'operand' => '='
),
array(
										'name' => "show_asblock",
										'value' => elgg_echo('frontpage_campaign:show_asblock_label'),
										'operand' => '='
),
),
				'metadata_name_value_pairs_operator' => 'AND',
		'order_by_metadata' => array('name' => 'file_sort', 'direction' => ASC)
);

$flipPicsBlock = elgg_list_entities_from_metadata($params);

$params = array(
        'type' => 'object',
        'subtype' => 'file',
		"metadata_name_value_pairs" => array(
array(
										'name' => "show_onindex",
										'value' => elgg_echo('frontpage_campaign:show_onindex_label'),
										'operand' => '='
),
array(
										'name' => "show_bigorsmall",
										'value' => elgg_echo('flipwall:smallpic'),
										'operand' => '='
),
array(
										'name' => "show_asblock",
										'value' => elgg_echo('frontpage_campaign:show_asblock_label'),
										'operand' => '!='
),
),
				'metadata_name_value_pairs_operator' => 'AND',
		'order_by_metadata' => array('name' => 'file_sort', 'direction' => ASC)
);

$small_flip_pics = elgg_list_entities_from_metadata($params);


$params = array(
        'type' => 'object',
        'subtype' => 'file',
        "metadata_name_value_pairs" => array(
array(
								'name' => "show_onindex",
								'value' => elgg_echo('frontpage_campaign:show_onindex_label'),
								'operand' => '='
),
array(
								'name' => "is_recources",
								'value' => elgg_echo('frontpage_campaign:is_recources_label'),
								'operand' => '='
),
),
		'metadata_name_value_pairs_operator' => 'AND',
		'order_by_metadata' => array('name' => 'file_sort', 'direction' => ASC)
);
$recources = elgg_list_entities_from_metadata($params);

$options = array(
        'type' => 'object',
        'subtypes' => 'videolist_item',
		"metadata_name_value_pairs" => array(
array(
			'name' => "index_page",
			'value' => elgg_echo('videolist:index_page'),
			'operand' => '='
),
),
		'metadata_name_value_pairs_operator' => 'AND',
		'order_by_metadata' => array('name' => 'index_sort', 'direction' => ASC)
);

$videos = elgg_list_entities_from_metadata($options);

if (elgg_is_admin_logged_in()) {
	$body .= "<div class='elgg-col elgg-col-1of1' style='margin:10px 0px 0px 0px'>";

	$body .= "<div class='c_i_c_bar'>" . elgg_echo('frontpage_campaign:frontpage_picture') . "</div>";
	$body .= ($share_pic ? $share_pic : elgg_echo('frontpage_campaign:messages:no_files'));
	$body .= "<div>";
	$body .= "<div class='c_i_c_bar'>" . elgg_echo('frontpage_campaign:frontpage_flip_pics_block') . "</div>";
	$body .= ($flipPicsBlock ? $flipPicsBlock : elgg_echo('frontpage_campaign:messages:no_files'));
	$body .= "<div>";		
	$body .= "<div class='c_i_c_bar'>" . elgg_echo('frontpage_campaign:frontpage_big_flip_pics') . "</div>";
	$body .= ($big_flip_pics ? $big_flip_pics : elgg_echo('frontpage_campaign:messages:no_files'));
	$body .= "<div>";
	$body .= "<div class='c_i_c_bar'>" . elgg_echo('frontpage_campaign:frontpage_small_flip_pics') . "</div>";
	$body .= ($small_flip_pics ? $small_flip_pics : elgg_echo('frontpage_campaign:messages:no_files'));
	$body .= "<div>";
	$body .= "<div class='c_i_c_bar'>" . elgg_echo('frontpage_campaign:frontpage_recources') . "</div>";
	$body .= ($recources ? $recources : elgg_echo('frontpage_campaign:messages:no_files'));
	$body .= "<div>";
	$body .= "<div class='c_i_c_bar'>" . elgg_echo('frontpage_campaign:frontpage_videos') . "</div>";
	$body .= ($videos ? $videos : elgg_echo('frontpage_campaign:messages:no_files'));
	$body .= "<div>";	
	
	$page_content = elgg_view_layout('one_column', array(
            'content' => $body,
	));

	echo elgg_view_page('', $page_content);
}
else {
	echo elgg_view_page('', '.');

}