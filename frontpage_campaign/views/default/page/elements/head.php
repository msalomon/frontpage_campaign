<?php
/**
 * The standard HTML head
 *
 * @uses $vars['title'] The page title
 */
global $CONFIG;
$context = elgg_get_context();


$params = array(
        'type' => 'object',
        'subtype' => 'file',
        'limit' => 1,
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

// limit = 1
$pictures = elgg_get_entities_from_metadata($params);

if ($pictures) {
    foreach($pictures as $picture) {
        // append to view them as wall entry
        $og_image =  elgg_get_site_url() . "file/download/". $picture->guid ;
        $og_description = strip_tags($picture->description);
        $og_title = strip_tags($picture->title);
    }
}
else {
    $og_image = elgg_get_site_url();
}

$og_site_name =	elgg_get_config('sitename');
$og_type = "website";
$og_url	= elgg_get_site_url() ;

//@todo ts_get_secrets('fb_admins')

if ($pictures) {
    $vars['title'] = $og_title;
    $title = elgg_get_config('sitename');
}

// Set title
if (empty($vars['title'])) {
    $title = elgg_get_config('sitename');
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
$site_url = elgg_get_site_url();
$href = "{$site_url}mod/frontpage_campaign/_graphics/favicon.ico";


?>
	<link rel="shortcut icon" href="<?php echo $href; ?>">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="ElggRelease" content="<?php echo $release; ?>" />
	<meta name="ElggVersion" content="<?php echo $version; ?>" />
	<meta property="og:title" content="<?php echo $og_title ?>" />
	<meta property="og:type" content="<?php echo $og_type ?>" />
	<meta property="og:url" content="<?php echo $og_url ?>" />
	<meta property="og:image" content="<?php echo $og_image ?>" />
	<meta property="og:site_name" content="<?php echo $og_site_name ?>" />
	<meta property="og:description" content="<?php echo $og_description ?>" />
	<meta property="og:locale" content="de_DE" />


	<title><?php echo $title; ?></title>

	
	
	
	<?php echo elgg_view('page/elements/shortcut_icon', $vars); ?>

<?php foreach ($css as $link) { ?>
	<link rel="stylesheet" href="<?php echo $link; ?>" type="text/css" />
<?php } ?>

<?php
	$ie_url = elgg_get_simplecache_url('css', 'ie');
	$ie7_url = elgg_get_simplecache_url('css', 'ie7');
	$ie6_url = elgg_get_simplecache_url('css', 'ie6');
?>
	<!--[if gt IE 7]>
		<link rel="stylesheet" type="text/css" href="<?php echo $ie_url; ?>" />
	<![endif]-->
	<!--[if IE 7]>
		<link rel="stylesheet" type="text/css" href="<?php echo $ie7_url; ?>" />
	<![endif]-->
	<!--[if IE 6]>
		<link rel="stylesheet" type="text/css" href="<?php echo $ie6_url; ?>" />
	<![endif]-->

<?php foreach ($js as $script) { ?>
	<script type="text/javascript" src="<?php echo $script; ?>"></script>
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