<?php



Global $CONFIG;
// load external javascript
elgg_load_js('flipwall-jquery-flip-min-js');
elgg_load_js('flipwall-script-js');

// load external css
elgg_load_css('flipwall-css');
elgg_load_css('page-flipwall-css');

// get current site entity
$site = elgg_get_site_entity();

// set site entity as page owner
elgg_set_page_owner_guid($site->getGUID());

//$title = elgg_echo('flipwall:example:title');
//elgg_push_breadcrumb($title); // breadcrumbs 'file'

//get user entities
$params = array(
	'type' => 'object',
	'subtype' => 'file',
	'container_guid' => elgg_get_plugin_setting('campaign_admin_id', 'frontpage_campaign'),
    'offset' => 0,
    'limit'  => 100,
		 "joins" => "INNER JOIN {$CONFIG->dbprefix}objects_entity o ON (o.guid = e.guid)",
"wheres" => array("(o.title like '#1#')"),
    "order_by" => "o.title ASC",
);

$files = elgg_get_entities($params);

$values = array(); // flip wall entry array
$rowbreak = 1;
$rowbreak = 0;
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

// display files as flip wall
$content .= elgg_view('output/flipwall', array(
	'values' => $values,
	'shuffle' => false,
));

$values = null;

$params = array(
	'type' => 'object',
	'subtype' => 'file',
	'container_guid' => elgg_get_plugin_setting('campaign_admin_id', 'frontpage_campaign'),
    'offset' => 0,
    'limit'  => 100,
		 "joins" => "INNER JOIN {$CONFIG->dbprefix}objects_entity o ON (o.guid = e.guid)",
"wheres" => array("(o.title like '#2#' or o.title like '#3#' or o.title like '#4#')"),
    "order_by" => "o.title ASC",
);

$files = elgg_get_entities($params);

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
$content2 .= elgg_view('output/flipwall-small', array(
	'values' => $values,
	'shuffle' => false,
));

$content3 = "<div class='frontpage_campaign-events'>" . elgg_get_plugin_setting('campaign_events', 'frontpage_campaign')  ;

if (elgg_get_plugin_setting('numberofshownvideos', 'frontpage_campaign')){
    $limit= elgg_get_plugin_setting('numberofshownvideos', 'frontpage_campaign');
}
else {
    $limit=2;
}

$options = array(
	'container_guid' => elgg_get_plugin_setting('campaign_admin_id', 'frontpage_campaign'),
    'count' => true,
	'type' => 'object',
	'subtypes' => 'videolist_item',
	'full_view' => false,
	'pagination' => true,
		 "joins" => "INNER JOIN {$CONFIG->dbprefix}objects_entity o ON (o.guid = e.guid)",
"wheres" => array("(o.title like '#%')"),
    "order_by" => "o.title ASC",
);

$videolistcount = elgg_get_entities($options);

$options = array(
	'container_guid' => elgg_get_plugin_setting('campaign_admin_id', 'frontpage_campaign'),
	'limit' => $limit,
	'type' => 'object',
	'subtypes' => 'videolist_item',
	'full_view' => false,
	'pagination' => false,
		 "joins" => "INNER JOIN {$CONFIG->dbprefix}objects_entity o ON (o.guid = e.guid)",
"wheres" => array("(o.title like '#%')"),
    "order_by" => "o.title ASC",
);
elgg_push_context('gallery');
$videolist = elgg_list_entities($options);
elgg_pop_context('gallery');

$videolist = elgg_view_module('aside', $title, $videolist);

if($videolist){

	$content3 .= $videolist;
}




if ( (int)$limit < (int)$videolistcount  ) {
$all_link = elgg_view('output/url', array(
	'href' => "CIC/videos",
	'text' => elgg_echo('frontpage_campaign:morevideos'),
));    
    $content3 .= $all_link . "</div>";
    
}
else {
    $content3 .=  "</div>";
}
$col1 = elgg_view_layout('one_column', array(
	'filter' => '',
	'content' => $content . $content2  ,
	'title' => $title,
	'sidebar' => '',
	'class'=>'elgg-col elgg-col-1of2',
));
$col2 = elgg_view_layout('one_column', array(
	'filter' => '',
	'content' => $content3,
	'title' => '',
	'sidebar' => '',
	'class'=>'elgg-col elgg-col-1of2'

));

$col3 =  elgg_view('donation/donation');



elgg_set_context('index-page');
$body = $col1  . $col2 . $col3;
echo elgg_view_page($title, $body);
