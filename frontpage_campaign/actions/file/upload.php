<?php
/**
 * Elgg file uploader/edit action
 *
 * @package ElggFile
 */

// Get variables
$show_bigorsmall = get_input("show_bigorsmall");
$show_asblock = get_input("show_asblock");
if ($show_asblock ==  elgg_echo('frontpage_campaign:show_asblock_label')){
	$show_bigorsmall = elgg_echo('flipwall:smallpic');
}
$is_facebook = get_input("is_facebook");
if ($is_facebook[0] == elgg_echo('frontpage_campaign:is_facebook_label')) {
	$params = array(
	        'type' => 'object',
	        'subtype' => 'file',
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
	

	$pictures = elgg_get_entities_from_metadata($params);
	
	if ($pictures) {
		foreach($pictures as $picture) {
			// append to view them as wall entry
			$picture->is_facebook = 0;
			$picture->save();
		}
	}
}

$opt_pic = get_input("opt_pic");
$show_onindex = get_input("show_onindex");
$is_recources = get_input("is_recources");
$file_sort = get_input("file_sort");
$title = get_input("title");
$desc = get_input("description");
$access_id = (int) get_input("access_id");
$container_guid = (int) get_input('container_guid', 0);
$guid = (int) get_input('file_guid');
$tags = get_input("tags");

if ($container_guid == 0) {
    $container_guid = elgg_get_logged_in_user_guid();
}

elgg_make_sticky_form('file');

// check if upload failed
if (!empty($_FILES['upload']['name']) && $_FILES['upload']['error'] != 0) {
    register_error(elgg_echo('file:cannotload'));
    forward(REFERER);
}

// check whether this is a new file or an edit
$new_file = true;
if ($guid > 0) {
    $new_file = false;
}

if ($new_file) {
    // must have a file if a new file upload
    if (empty($_FILES['upload']['name'])) {
        $error = elgg_echo('file:nofile');
        register_error($error);
        forward(REFERER);
    }

    $file = new FilePluginFile();
    $file->subtype = "file";

    // if no title on new upload, grab filename
    if (empty($title)) {
        $title = $_FILES['upload']['name'];
    }

} else {
    // load original file object
    $file = new FilePluginFile($guid);
    if (!$file) {
        register_error(elgg_echo('file:cannotload'));
        forward(REFERER);
    }

    // user must be able to edit file
    if (!$file->canEdit()) {
        register_error(elgg_echo('file:noaccess'));
        forward(REFERER);
    }

    if (!$title) {
        // user blanked title, but we need one
        $title = $file->title;
    }
}

$file->title = $title;
$file->description = $desc;
$file->access_id = $access_id;
$file->container_guid = $container_guid;

// extended
$file->opt_pic = $opt_pic;
$file->show_onindex = $show_onindex;
$file->is_recources = $is_recources;
$file->file_sort = $file_sort;
$file->show_bigorsmall = $show_bigorsmall;
$file->show_asblock = $show_asblock ;
if ($file->show_asblock == elgg_echo('frontpage_campaign:show_asblock_label')) {
	$file->show_bigorsmall = elgg_echo('flipwall:smallpic');
}
$file->is_facebook =$is_facebook ;
if (isset($_FILES['upload_opt']['name']) && !empty($_FILES['upload_opt']['name'])) {
    // check whether this is a new file or an edit
    $file_entity = get_entity($guid);
    $prefix = "file/opt_pic/".$guid;

    $filehandler = new ElggFile();
    $filehandler->owner_guid = $file_entity->owner_guid;
    $filehandler->setFilename($prefix . ".jpg");
    $filehandler->open("write");
    $filehandler->write(get_uploaded_file('upload_opt'));
    $filehandler->close();
    $thumbtiny = get_resized_image_from_existing_file($filehandler->getFilenameOnFilestore(),60,120, false);
    $thumbsquare = get_resized_image_from_existing_file($filehandler->getFilenameOnFilestore(),60,120, true);
    $thumbsmall = get_resized_image_from_existing_file($filehandler->getFilenameOnFilestore(),80,160, false);
    $thumbmedium = get_resized_image_from_existing_file($filehandler->getFilenameOnFilestore(),100,200, false);
    $thumblarge = get_resized_image_from_existing_file($filehandler->getFilenameOnFilestore(),200,400, false);
    if ($thumbtiny)
    {
        $thumb = new ElggFile();
        $thumb->owner_guid = $file_entity->owner_guid;
        $thumb->setMimeType('image/jpeg');

        $thumb->setFilename($prefix."tiny.jpg");
        $thumb->open("write");
        $thumb->write($thumbtiny);
        $thumb->close();

        $thumb->setFilename($prefix."square.jpg");
        $thumb->open("write");
        $thumb->write($thumbsquare);
        $thumb->close();
         
        $thumb->setFilename($prefix."small.jpg");
        $thumb->open("write");
        $thumb->write($thumbsmall);
        $thumb->close();
         
        $thumb->setFilename($prefix."medium.jpg");
        $thumb->open("write");
        $thumb->write($thumbmedium);
        $thumb->close();
         
        $thumb->setFilename($prefix."large.jpg");
        $thumb->open("write");
        $thumb->write($thumblarge);
        $thumb->close();

    }

}

// end extended

$tags = explode(",", $tags);
$file->tags = $tags;

// we have a file upload, so process it
if (isset($_FILES['upload']['name']) && !empty($_FILES['upload']['name'])) {

    $prefix = "file/";

    // if previous file, delete it
    if ($new_file == false) {
        $filename = $file->getFilenameOnFilestore();
        if (file_exists($filename)) {
            unlink($filename);
        }

        // use same filename on the disk - ensures thumbnails are overwritten
        $filestorename = $file->getFilename();
        $filestorename = elgg_substr($filestorename, elgg_strlen($prefix));
    } else {
        $filestorename = elgg_strtolower(time().$_FILES['upload']['name']);
    }

    $mime_type = $file->detectMimeType($_FILES['upload']['tmp_name'], $_FILES['upload']['type']);
    $file->setFilename($prefix . $filestorename);
    $file->setMimeType($mime_type);
    $file->originalfilename = $_FILES['upload']['name'];
    $file->simpletype = file_get_simple_type($mime_type);

    // Open the file to guarantee the directory exists
    $file->open("write");
    $file->close();
    move_uploaded_file($_FILES['upload']['tmp_name'], $file->getFilenameOnFilestore());

    $guid = $file->save();

    // if image, we need to create thumbnails (this should be moved into a function)
    if ($guid && $file->simpletype == "image") {
        $file->icontime = time();

        $thumbnail = get_resized_image_from_existing_file($file->getFilenameOnFilestore(), 60, 60, true);
        if ($thumbnail) {
            $thumb = new ElggFile();
            $thumb->setMimeType($_FILES['upload']['type']);

            $thumb->setFilename($prefix."thumb".$filestorename);
            $thumb->open("write");
            $thumb->write($thumbnail);
            $thumb->close();

            $file->thumbnail = $prefix."thumb".$filestorename;
            unset($thumbnail);
        }

        $thumbsmall = get_resized_image_from_existing_file($file->getFilenameOnFilestore(), 153, 153, true);
        if ($thumbsmall) {
            $thumb->setFilename($prefix."smallthumb".$filestorename);
            $thumb->open("write");
            $thumb->write($thumbsmall);
            $thumb->close();
            $file->smallthumb = $prefix."smallthumb".$filestorename;
            unset($thumbsmall);
        }

        $thumblarge = get_resized_image_from_existing_file($file->getFilenameOnFilestore(), 600, 600, false);
        if ($thumblarge) {
            $thumb->setFilename($prefix."largethumb".$filestorename);
            $thumb->open("write");
            $thumb->write($thumblarge);
            $thumb->close();
            $file->largethumb = $prefix."largethumb".$filestorename;
            unset($thumblarge);
        }
    }
} else {
    // not saving a file but still need to save the entity to push attributes to database
    $file->save();
}

// file saved so clear sticky form
elgg_clear_sticky_form('file');


// handle results differently for new files and file updates
if ($new_file) {
    if ($guid) {
        $message = elgg_echo("file:saved");
        system_message($message);
        add_to_river('river/object/file/create', 'create', elgg_get_logged_in_user_guid(), $file->guid);
    } else {
        // failed to save file object - nothing we can do about this
        $error = elgg_echo("file:uploadfailed");
        register_error($error);
    }

    $container = get_entity($container_guid);
    if (elgg_instanceof($container, 'group')) {
        forward("file/group/$container->guid/all");
    } else {
        forward("file/owner/$container->username");
    }

} else {
    if ($guid) {
        system_message(elgg_echo("file:saved"));
    } else {
        register_error(elgg_echo("file:uploadfailed"));
    }

    forward($file->getURL());
}
