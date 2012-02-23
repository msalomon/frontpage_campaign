<?php
// load external javascript
Global $CONFIG;
elgg_load_js('flipwall-jquery-flip-min-js');
elgg_load_js('flipwall-script-js');

// load external css
elgg_load_css('flipwall-css');
elgg_load_css('page-flipwall-css');

// get the position of the content

$right = elgg_echo('frontpage_campaign:settings:right');
$left = elgg_echo('frontpage_campaign:settings:left');
$head = elgg_echo('frontpage_campaign:settings:head');
$foot = elgg_echo('frontpage_campaign:settings:foot');
$yes = elgg_echo('frontpage_campaign:settings:yes');
$no = elgg_echo('frontpage_campaign:settings:no');

$campaign_big_pic_show = elgg_get_plugin_setting('campaign_big_pic_show', 'frontpage_campaign');
$campaign_small_pic_show = elgg_get_plugin_setting('campaign_small_pic_show', 'frontpage_campaign');
$campaign_flip_block_show = elgg_get_plugin_setting('campaign_flip_block_show', 'frontpage_campaign');
$campaign_info_position = elgg_get_plugin_setting('campaign_info_position', 'frontpage_campaign');
$content_info = elgg_get_plugin_setting('campaign_info', 'frontpage_campaign');
$campaign_events_position = elgg_get_plugin_setting('campaign_events_position', 'frontpage_campaign');
$content_events = "<div class='frontpage_campaign-events'>" . elgg_get_plugin_setting('campaign_events', 'frontpage_campaign') . "</div>";
$campaign_recources_show = elgg_get_plugin_setting('campaign_recources_show', 'frontpage_campaign');
$campaign_videos_show = elgg_get_plugin_setting('campaign_videos_show', 'frontpage_campaign');
$campaign_numberofshownvideos = elgg_get_plugin_setting('campaign_numberofshownvideos', 'frontpage_campaign');
$campaign_recource_text = elgg_echo('frontpage_campaign:copyright');

$vars['search_input'] = '10px';

// get current site entity
$site = elgg_get_site_entity();

// set site entity as page owner
elgg_set_page_owner_guid($site->getGUID());

//$title = elgg_echo('flipwall:example:title');
//elgg_push_breadcrumb($title); // breadcrumbs 'file'

if ((int) elgg_get_plugin_setting('campaign_numberofshownrecources', 'frontpage_campaign') ){
	$limit=  (int) elgg_get_plugin_setting('campaign_numberofshownrecources', 'frontpage_campaign');
}
else {
	$limit=3;
}

$params = array(
        'type' => 'object',
        'subtype' => 'file',
        "metadata_name_value_pairs" => array(
			array(
							'name' => 'universal_categories',
							'value' => '',
							'operand' => '<>'
			),
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
		'order_by_metadata' => array('name' => 'universal_categories', 'direction' => ASC)
);
$recources_with_category = elgg_get_entities_from_metadata($params);
$go = false;
foreach($recources_with_category as $recource) {
	if ($go) {
		if (strtolower($category) <> strtolower($recource->universal_categories)) {
			$content_recources .= "<div class='clearfix'>"."</div><div class='c_i_c_bar_category'>" . ucfirst($recource->universal_categories) . "</div>";
		}
	
	}
	if (!$go) {
		$category = $recource->universal_categories;
		$content_recources .= "<div class='clearfix'>". "<div class='frontpage_campaign-bar' >" . "<div class='c_i_c_bar'>" . elgg_echo('frontpage_campaign:recources') ."</div>" . "<div class='frontpage_image_block_wrapper' style='font-size:9px; line-height:9px;'>" . $campaign_recource_text . "</div>" ;
		$content_recources .=   "<div class='c_i_c_bar_category'>" . ucfirst($recource->universal_categories) . "</div>"  ;
	}
	$content_recources .= "<div class='frontpage_image_block_wrapper'>";
	$content_recources .= elgg_view('output/recources', array(
            'entity' => $recource,
            'category' => true,
	));
	$content_recources .= "</div>";


	$go= true;
	$category =$recource->universal_categories;
}
if ($go){
	$content_recources .= "</div></div>";
}

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
$recources_all = elgg_get_entities_from_metadata($params);
$go = false;
$diverse = false;
foreach($recources_all as $recource) {

	if (!$go) {
		$category = $recource->universal_categories;
		$content_recources_diverse .= "<div class='clearfix'>". "<div class='frontpage_campaign-bar' >"; 
		if (!$recources_with_category) {
			$content_recources_diverse .= "<div class='c_i_c_bar'>" . elgg_echo('frontpage_campaign:recources') ."</div>" . "<div class='frontpage_image_block_wrapper' style='padding-bottom:3px; font-size:9px; line-height:9px; '>" . $campaign_recource_text . "</div>" ;
		}
		if ($recources_with_category) {
			$content_recources_diverse .=   "<div class='c_i_c_bar_category'>" . elgg_echo("frontpage_campaign:recources_nocategory") . "</div>"  ;
		}
	}
	if ($recource->universal_categories ==''){
	$content_recources_diverse .= "<div class='frontpage_image_block_wrapper'>";	
	$diverse = elgg_view('output/recources', array(
            'entity' => $recource,
            'category' => true,
	));
	$content_recources_diverse .= $diverse ;

	$content_recources_diverse .= "</div>";
	}

	$go= true;

}
if ($go){
	$content_recources_diverse .= "</div></div>";
}


if ($diverse) {
$content_recources .= $content_recources_diverse;
}























$params = array(
        'type' => 'object',
        'subtype' => 'file',
        'count' => true,
        "metadata_name_value_pairs" => array("
                name" => "is_recources",
                "value" => elgg_echo('frontpage_campaign:is_recources_label'),
                "name" => "show_onindex",
                "value" => elgg_echo('frontpage_campaign:show_onindex_label'),
),
        'container_guid' => elgg_get_plugin_setting('campaign_admin_id', 'frontpage_campaign'),
);
$recourcescount = elgg_get_entities_from_metadata($params);

if ( (int)$limit < (int)$recourcescount  ) {
	$all_link = elgg_view('output/url', array(
	            'href' => "cic/recources",
	            'text' => elgg_echo('frontpage_campaign:morerecources'),
	));
	$more_recources .= "<div class='c_i_c_more'>" .$all_link ."</div>";

}



// on index page AND big-flip

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


$files = elgg_get_entities_from_metadata($params);


foreach($files as $file) {
	// append to view them as wall entry
	$values[] = array(
	// get the view for the front side of the flip entry
            'front' => elgg_view('flip/front', array(
                    'entity' => $file,
	)),
	// view of the backside of the flip entr
            'back' => elgg_view('flip/back', array(
                    'entity' => $file,
	)),
	);
}


$content_big_flip .= elgg_view('output/flipwall', array(
        'values' => $values,
        'shuffle' => false,
));


// on index page AND big-flip-block

$params = array(
        'type' => 'object',
        'subtype' => 'file',
		'limit' => 100,
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

$files = elgg_get_entities_from_metadata($params);

$values = array(); // flip wall entry array
$rowbreak = 1;
$rowbreak = 0;
foreach($files as $file) {
	// append to view them as wall entry
	$values[] = array(
	// get the view for the front side of the flip entry
            'front' => elgg_view('flip/front-small', array(
                    'entity' => $file,
	)),
	// view of the backside of the flip entr
            'back' => elgg_view('flip/back-small', array(
                    'entity' => $file,
	)),
	);
}

// display files as flip wall
$content_smallpic_block .= elgg_view('output/flipwall-small', array(
        'values' => $values,
        'shuffle' => false,
));

$params = array(
        'type' => 'object',
        'subtype' => 'file',
        'limit' => 100,
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

$files = elgg_get_entities_from_metadata($params);

$values = array(); // flip wall entry array
$rowbreak = 1;
$rowbreak = 0;
foreach($files as $file) {
	// append to view them as wall entry
	$values[] = array(
	// get the view for the front side of the flip entry
            'front' => elgg_view('flip/front-small', array(
                    'entity' => $file,
	)),
	// view of the backside of the flip entr
            'back' => elgg_view('flip/back-small', array(
                    'entity' => $file,
	)),
	);
}

// display files as flip wall
$content_smallpic_other.= elgg_view('output/flipwall-small', array(
        'values' => $values,
        'shuffle' => false,
));

/* $content_videos = "<div class='frontpage_campaign-events'>" . elgg_get_plugin_setting('campaign_events', 'frontpage_campaign')  ;
$content_videos .= $content_recources; */
if (!$campaign_numberofshownvideos){
	$campaign_numberofshownvideos = 3;
}


$options = array(
        'count' => true,
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

$videolistcount = elgg_get_entities_from_metadata($options);

$options = array(
        'limit' => $campaign_numberofshownvideos,
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
elgg_push_context('gallery');
$videolist = elgg_list_entities_from_metadata($options);
elgg_pop_context('gallery');

$content_videos = elgg_view_module('aside', $title, $videolist);






if ( (int)$limit < (int)$videolistcount  ) {
	$all_link = elgg_view('output/url', array(
            'href' => "cic/videos",
            'text' => elgg_echo('frontpage_campaign:morevideos'),
	));
	$more_videos .= "<div class='c_i_c_more'>" . $all_link . "</div>";

}

$content_info = "<div class='frontpage_campaign-events'><div class='clearfix'>" . $content_info  . "</div></div>" ;
$content_smallpic_block = "<div class='frontpage_campaign-flips'>" . $content_smallpic_block  ."</div>";
$content_smallpic_other = "<div class='frontpage_campaign-flips'>" . $content_smallpic_other  ."</div>";

if ((int) $recourcescount > 0 ) {
$content_recources = "<div class='frontpage_campaign-bar'>" . $content_recources . "</div>"   ;
}


if ((int) $videolistcount > 0 ) {
	$content_videos = "<div class='frontpage_campaign-bar'><div class='clearfix'>" . "<div class='c_i_c_bar'>" . elgg_echo('frontpage_campaign:videos') . "</div><div class='frontpage_campaign-wrapper'>" .$content_videos  . "</div></div>"  . "</div>" ;
}

//$content_videos = '';
//$content_recources = '';

$col_left = elgg_view_layout('one_column', array(
        'filter' => '',
        'content' => 
        ($campaign_info_position == $left ? $content_info : "")  .
		// relative to BIG flip-picture
		($campaign_events_position == $head && $campaign_big_pic_show == $left ? $content_events : '').
        ($campaign_big_pic_show == $left ? $content_big_flip : "")  . 
		// relative to BIG flip-picture
		($campaign_events_position == $foot && $campaign_big_pic_show == $left ? $content_events : '').
        ($campaign_flip_block_show == $left ? $content_smallpic_block : "") .
        ($campaign_small_pic_show == $left ? $content_smallpic_other : "") .
      	($campaign_recources_show == $left ? $content_recources : "") .
		($campaign_videos_show == $left ? $content_videos : "")
        ,

        'class'=>'elgg-col elgg-col-1of2',
));
$col_right = elgg_view_layout('one_column', array(
        'filter' => '',
        'content' => 
		($campaign_info_position == $right ? $content_info : "")  .
		// relative to BIG flip-picture
		($campaign_events_position == $head && $campaign_big_pic_show == $right ? $content_events : '').
        ($campaign_big_pic_show == $right ? $content_big_flip : "") .
		// relative to BIG flip-picture
		($campaign_events_position == $foot && $campaign_big_pic_show == $right ? $content_events : '').
        ($campaign_flip_block_show == $right ? $content_smallpic_block : "") .
        ($campaign_small_pic_show == $right ? $content_smallpic_other : "")  .
		($campaign_recources_show == $right ? $content_recources : "") .
		($campaign_videos_show == $right ? $content_videos : "")
        ,

        'class'=>'elgg-col elgg-col-1of2'

));





elgg_set_context('index-page');
$body = $col_left  . $col_right ;
if (empty($campaign_big_pic_show)) {
	$help_url = elgg_get_site_url() . 'mod/frontpage_campaign/graphics/help.gif';
	$body = elgg_view('output/url', array(
	        'href' => 'http://youtu.be/9bNxEuGPC3w',
	        'text' => "&nbsp;&nbsp;" ."<img src=\"$help_url\" title=\"Click to look Help-Video\" width=\"970\" />" . "&nbsp;&nbsp;",
	        'is_trusted' => true,
	));
	
}
echo elgg_view_page($title, $body);
