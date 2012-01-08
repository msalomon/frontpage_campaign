<?php
/**
 * Based on Elgg demo custom index page plugin
 *
 */

elgg_register_event_handler('init', 'system', 'custom_index_init');

function custom_index_init() {
	elgg_register_library('elgg:videolist', elgg_get_plugins_path() . 'frontpage_campaign/lib/videolist.php');

	// add a site navigation item
	$item = new ElggMenuItem('videolist', elgg_echo('videolist'), 'videolist/all');
	elgg_register_menu_item('site', $item);

	// Extend system CSS with our own styles
	elgg_extend_view('css/elgg','videolist/css');

	// Register a page handler, so we can have nice URLs
	elgg_register_page_handler('videolist', 'videolist_page_handler');
	
	// Language short codes must be of the form "videolist:key"
	// where key is the array key below
	elgg_set_config('videolist', array(
		'video_url' => 'url',
		'title' => 'text',
		'description' => 'longtext',
		'tags' => 'tags',
		'access_id' => 'access',
	));

	// extend group main page
	elgg_extend_view('groups/tool_latest', 'videolist/group_module');
	
	//add a widget
	elgg_register_widget_type('videolist', elgg_echo('videolist'), elgg_echo('videolist:widget:description'));

	if (is_callable('register_notification_object')) {
		register_notification_object('object', 'videolist_item', elgg_echo('videolist:new'));
	}
	
	// Register entity type for search
	elgg_register_entity_type('object', 'videolist_item');

	// add a file link to owner blocks
	elgg_register_plugin_hook_handler('register', 'menu:owner_block', 'videolist_owner_block_menu');
	elgg_register_event_handler('annotate','all','videolist_object_notifications');

	elgg_register_plugin_hook_handler('object:notifications','object','videolist_object_notifications_intercept');

	//register entity url handler
	elgg_register_entity_url_handler('object', 'videolist_item', 'videolist_url');
	elgg_register_plugin_hook_handler('entity:icon:url', 'object', 'videolist_icon_url_override');

	// register for embed
	elgg_register_plugin_hook_handler('embed_get_sections', 'all', 'videolist_embed_get_sections');
	elgg_register_plugin_hook_handler('embed_get_items', 'videolist', 'videolist_embed_get_items');
	
	// Register actions
	$actions_path = elgg_get_plugins_path() . "frontpage_campaign/actions/videolist";
	elgg_register_action("videolist/add", "$actions_path/add.php");
	elgg_register_action("videolist/edit", "$actions_path/edit.php");
	elgg_register_action("videolist/delete", "$actions_path/delete.php");
	
	
        /**
     * CSS
     */
    $css_url = 'mod/frontpage_campaign/vendors/socialshareprivacy/socialshareprivacy/';
    elgg_register_css('socialshareprivacy-css', $css_url . 'socialshareprivacy.css', 500);
    elgg_load_css('socialshareprivacy-css');

    /**
     * JS
     */
    $js_url = 'mod/frontpage_campaign/vendors/socialshareprivacy/jquery.socialshareprivacy.min.js';
    elgg_register_js('jquery-socialshareprivacy-min', $js_url, 'head', 500);
    elgg_load_js('jquery-socialshareprivacy-min');

    /**
     * Inline JS
     */
    elgg_extend_view('page/elements/foot', 'socialshareprivacy/js/foot_extend', 500);

    /**
     * Extend Views
     */
    elgg_extend_view('page/elements/footer', 'socialshareprivacy/socialshareprivacy_div', 10);
	/**
	 * External JS
	 */
	$js_url = 'mod/frontpage_campaign/vendors/flip-wall/';
	elgg_register_js('flipwall-jquery-flip-min-js', $js_url.'jquery.flip.min.js', 'footer', 800);
	elgg_register_js('flipwall-script-js', $js_url.'script.js', 'footer', 810);

	/**
	 * External CSS
	 */
	$css_url = 'mod/frontpage_campaign/vendors/flip-wall/';
	elgg_register_css('flipwall-css', $css_url . 'styles.css');

	$css_url = 'mod/frontpage_campaign/vendors/flip-wall/';
	elgg_register_css('page-flipwall-css', $css_url . 'flipwall.css');
	// Extend system CSS with our own styles
	elgg_extend_view('css/elgg', 'frontpage_campaign/css');

	// Replace the default index page
	elgg_register_plugin_hook_handler('index', 'system', 'custom_index');
	elgg_register_page_handler('CIC', 'frontpage_campaign_handler');
}

function custom_index($hook, $type, $return, $params) {
	if ($return == true) {
		// another hook has already replaced the front page
		return $return;
	}

	if (!include_once(dirname(__FILE__) . "/index.php")) {
		return false;
	}

	// return true to signify that we have handled the front page
	return true;
}
function frontpage_campaign_handler($page) {
	elgg_load_library('elgg:bookmarks');

	elgg_push_breadcrumb(elgg_echo('Start'), 'index');



	// user usernames
	$user = get_user_by_username($page[0]);
	if ($user) {
		bookmarks_url_forwarder($page);
	}

	$pages = dirname(__FILE__) . '/pages';

	switch ($page[0]) {
		case "videos":
			include "$pages/allvideos.php";
			break;

		default:
			return false;
	}

	elgg_pop_context();
	return true;
}
function videolist_page_handler($page) {
	
	if (!isset($page[0])) {
		$page[0] = 'all';
	}

	$videolist_dir = elgg_get_plugins_path() . 'frontpage_campaign/pages/videolist';

	$page_type = $page[0];
	switch ($page_type) {
		case 'owner':
			include "$videolist_dir/owner.php";
			break;
		case 'friends':
			include "$videolist_dir/friends.php";
			break;
		case 'watch':
			set_input('guid', $page[1]);
			include "$videolist_dir/watch.php";
			break;
		case 'add':
			include "$videolist_dir/add.php";
			break;
		case 'edit':
			set_input('guid', $page[1]);
			include "$videolist_dir/edit.php";
			break;
		case 'group':
			include "$videolist_dir/owner.php";
			break;
		case 'all':
		default:
			include "$videolist_dir/all.php";
			break;
	}
	return true;
}

/**
 * Add a menu item to the user ownerblock
 */
function videolist_owner_block_menu($hook, $type, $return, $params) {
	if (elgg_instanceof($params['entity'], 'user')) {
		$url = "videolist/owner/{$params['entity']->username}";
		$item = new ElggMenuItem('videolist', elgg_echo('videolist'), $url);
		$return[] = $item;
	} else {
		if ($params['entity']->videolist_enable != "no") {
			$url = "videolist/group/{$params['entity']->guid}/all";
			$item = new ElggMenuItem('videolist', elgg_echo('videolist:group'), $url);
			$return[] = $item;
		}
	}

	return $return;
}

function videolist_url($videolist_item) {
	$guid = $videolist_item->guid;
	$title = elgg_get_friendly_title($videolist_item->title);
	return elgg_get_site_url() . "videolist/watch/$guid/$title";
}

/**
 * Event handler for videolist
 *
 */
function videolist_object_notifications($event, $object_type, $object) {
	static $flag;
	if (!isset($flag)) {
		$flag = 0;
	}

	if (is_callable('object_notifications')) {
		if ($object instanceof ElggObject) {
			if ($object->getSubtype() == 'videolist_item') {
				if ($flag == 0) {
					$flag = 1;
					object_notifications($event, $object_type, $object);
				}
			}
		}
	}
}

/**
 * Intercepts the notification on an event of new video being created and prevents a notification from going out
 * (because one will be sent on the annotation)
 *
 * @param unknown_type $hook
 * @param unknown_type $entity_type
 * @param unknown_type $returnvalue
 * @param unknown_type $params
 * @return unknown
 */
function videolist_object_notifications_intercept($hook, $entity_type, $returnvalue, $params) {
	if (isset($params)) {
		if ($params['event'] == 'create' && $params['object'] instanceof ElggObject) {
			if ($params['object']->getSubtype() == 'videolist_item') {
				return true;
			}
		}
	}
	return null;
}


/**
 * Register videolist as an embed type.
 *
 * @param unknown_type $hook
 * @param unknown_type $type
 * @param unknown_type $value
 * @param unknown_type $params
 */
function videolist_embed_get_sections($hook, $type, $value, $params) {
	$value['videolist'] = array(
		'name' => elgg_echo('videolist'),
		'layout' => 'list',
		'icon_size' => 'medium',
	);

	return $value;
}

/**
 * Return a list of videos for embedding
 *
 * @param unknown_type $hook
 * @param unknown_type $type
 * @param unknown_type $value
 * @param unknown_type $params
 */
function videolist_embed_get_items($hook, $type, $value, $params) {
	$options = array(
		'owner_guid' => get_loggedin_userid(),
		'type_subtype_pair' => array('object' => 'videolist_item'),
		'count' => TRUE
	);

	$count = elgg_get_entities($options);
	$value['count'] += $count;

	unset($options['count']);
	$options['offset'] = $params['offset'];
	$options['limit'] = $params['limit'];

	$items = elgg_get_entities($options);

	$value['items'] = array_merge($items, $value['items']);

	return $value;
}

/**
 * Override the default entity icon for videoslist items
 *
 * @return string Relative URL
 */
function videolist_icon_url_override($hook, $type, $returnvalue, $params) {
	$videolist_item = $params['entity'];
	$size = $params['size'];
	
	if($videolist_item->getSubtype() != 'videolist_item'){
		return $returnvalue;
	}
	
	// tiny thumbnails are too small to be useful, so give a generic video icon
	if ($size != 'tiny' && isset($videolist_item->thumbnail)) {
		return $videolist_item->thumbnail;
	}

	if (in_array($size, array('tiny', 'small', 'medium'))){
		return "mod/frontpage_campaign/graphics/videolist_icon_{$size}.png";
	}
}
