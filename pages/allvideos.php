<?php
Global $CONFIG;
$options = array(
	'container_guid' => elgg_get_plugin_setting('campaign_admin_id', 'frontpage_campaign'),
	'limit' => $limit,
	'type' => 'object',
	'subtypes' => 'videolist_item',
    'list_type' => 'list',
	'full_view' => false,
    'cic_gallery' => true,
	'pagination' => true,
		 "joins" => "INNER JOIN {$CONFIG->dbprefix}objects_entity o ON (o.guid = e.guid)",
"wheres" => array("(o.title like '#%')"),
    "order_by" => "o.title ASC",
);
elgg_push_context('cic_gallery');
$videolist = elgg_list_entities($options);
elgg_pop_context('cic_gallery');
$body = $videolist;
echo elgg_view_page($title, $body);
