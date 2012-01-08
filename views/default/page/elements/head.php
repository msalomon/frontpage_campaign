<?php
/**
 * The standard HTML head
 *
 * @uses $vars['title'] The page title
 */
global $CONFIG;
$context = elgg_get_context();
$campaign_twitter_tag=elgg_get_plugin_setting('campaign_twitter_tag', 'frontpage_campaign');
$campaign_facebook_group=elgg_get_plugin_setting('campaign_facebook_group', 'frontpage_campaign');
$campaign_facebooksite_og_title=elgg_get_plugin_setting('campaign_facebooksite_og_title', 'frontpage_campaign');
$campaign_facebooksite_og_site_name=elgg_get_plugin_setting('campaign_facebooksite_og_site_name', 'frontpage_campaign');
$campaign_facebooksite_og_description=elgg_get_plugin_setting('campaign_facebooksite_og_description', 'frontpage_campaign');
$campaign_facebooksite_og_site_image=elgg_get_plugin_setting('campaign_facebooksite_og_site_image', 'frontpage_campaign');

$params = array(
	'type' => 'object',
	'subtype' => 'file',
	'container_guid' => elgg_get_plugin_setting('campaign_admin_id', 'frontpage_campaign'),
    'offset' => 0,
    'limit'  => 100,
		 "joins" => "INNER JOIN {$CONFIG->dbprefix}objects_entity o ON (o.guid = e.guid)",
	"wheres" => array("(o.title like '%" . $campaign_facebooksite_og_site_image ."%')"),
    "order_by" => "o.title ASC",
);
$pictures = elgg_get_entities($params);
if ($pictures) {
	foreach($pictures as $picture) {
		// append to view them as wall entry
		$og_image =  elgg_get_site_url() . "mod/frontpage_campaign/thumbnail.php?picture_guid=" . $picture->guid . "&size=medium";
	}
}
else {
	$og_image = elgg_get_site_url();
}

$og_title =	$campaign_facebooksite_og_title;
$og_type = "non_profit";
$og_url	= elgg_get_site_url() ;
$og_site_name =	$campaign_facebooksite_og_site_name;
$og_description = $campaign_facebooksite_og_description;

//@todo ts_get_secrets('fb_admins')

if ($pictures) {
	$vars['title'] = $campaign_facebooksite_og_title;
}

// Set title
if (empty($vars['title'])) {
	$title = elgg_get_config('sitename');
} else {
	if ($pictures) {
		$title = $campaign_facebooksite_og_title;
	}
	else {
		$title = elgg_get_config('sitename') . ": " . $vars['title'];
	}
}

global $autofeed;
if (isset($autofeed) && $autofeed == true) {
	$url = full_url();
	if (substr_count($url,'?')) {
		$url .= "&view=rss";
	} else {
		$url .= "?view=rss";
	}
	$url = elgg_format_url($url);
	$feedref = <<<END

	<link rel="alternate" type="application/rss+xml" title="RSS" href="{$url}" />

END;
} else {
	$feedref = "";
}

$js = elgg_get_loaded_js('head');
$css = elgg_get_loaded_css();

$version = get_version();
$release = get_version(true);

?>
<meta
	http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta
	property="og:locale:alternate" content="de_DE" />
<meta property="og:locale"
	content="de_DE" />
<meta
	name="ElggRelease" content="<?php echo $release; ?>" />
<meta
	name="ElggVersion" content="<?php echo $version; ?>" />
<meta
	property="og:title" content="<?php echo $og_title ?>" />
<meta
	property="og:type" content="<?php echo $og_type ?>" />
<meta
	property="og:url" content="<?php echo $og_url ?>" />
<meta
	property="og:image" content="<?php echo $og_image ?>" />
<meta
	property="og:image:url" content="<?php echo $og_image ?>" />
<meta
	property="og:site_name" content="<?php echo $og_site_name ?>" />
<meta
	property="og:description" content="<?php echo $og_description ?>" />
<meta
	property="fb:admins" content="<?php echo $fb_admins ?>" />
<meta
	property="DC.title"
	content="<?php echo $og_site_name . '&nbsp;' . $campaign_twitter_tag ?>" />
<?php


?>
<title><?php echo $title; ?></title>
<link
	rel="SHORTCUT ICON"
	href="<?php echo elgg_get_site_url(); ?>_graphics/favicon.ico" />

<?php foreach ($css as $link) { ?>
<link
	rel="stylesheet" href="<?php echo $link; ?>" type="text/css" />
<?php } ?>

<?php
$ie_url = elgg_get_simplecache_url('css', 'ie');
$ie6_url = elgg_get_simplecache_url('css', 'ie6');
?>
<!--[if gt IE 6]>
		<link rel="stylesheet" type="text/css" href="<?php echo $ie_url; ?>" />
	<![endif]-->
<!--[if IE 6]>
		<link rel="stylesheet" type="text/css" href="<?php echo $ie6_url; ?>" />
	<![endif]-->

<?php foreach ($js as $script) { ?>
<script
	type="text/javascript" src="<?php echo $script; ?>"></script>
<?php } ?>

<script type="text/javascript">
	<?php echo elgg_view('js/initialize_elgg'); ?>
</script>

	<?php
	echo $feedref;


	$metatags = elgg_view('metatags', $vars);
	if ($metatags) {
		elgg_deprecated_notice("The metatags view has been deprecated. Extend page/elements/head instead", 1.8);
		echo $metatags;
	}
