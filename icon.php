<?php

/**
 * Elgg campaign Plugin
 * @package campaign
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author manfred salomon
 * @copyright manfred salomon
 * @link www.tschirps.de
 */

// Load the Elgg framework
require_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");

// Get the campaign guid
$picid = get_input('recourcesguid');
$recourcesguid = (int) get_input('recourcesguid');
// Get the size
$size = strtolower(get_input('size'));
$picdefault = strtolower(get_input('picdefault'));
// Get entity data
$object = get_entity($recourcesguid);
if($object){
    $owner = $object->getOwnerEntity()->guid;
}

if (!in_array($size,array('tiny','small','medium','large','square'))) {
    $size = "small";
}


// Use master if we need the full size
if ($size == "master")
    $size = "";

// Try and get the icon

$filehandler = new ElggFile();
$filehandler->owner_guid = $object->owner_guid;
$filepic = $picid . $size;
$filehandler->setFilename("file/opt_pic/" . $filepic  . ".jpg");

$success = false;
if ($filehandler->open("read")) {
    if ($contents = $filehandler->read($filehandler->size())) {
        $success = true;
    }
}
if ($success) {

    header("Content-type: image/jpeg");
    header('Expires: ' . date('r',time() + 86400));
    header("Pragma: public");
    header("Cache-Control: public");
    header("Content-Length: " . strlen($contents));
    echo $contents;
}
else
{
    $file_guid = (int) get_input('recourcesguid',0);

    // Get file thumbnail size
    $size = get_input('size', 'small');

    $file = get_entity($file_guid);
    if (!$file || $file->getSubtype() != "file") {
        exit;
    }

    $simpletype = $file->simpletype;
    if ($simpletype == "image") {

        // Get file thumbnail
        switch ($size) {
            case "small":
                $thumbfile = $file->thumbnail;
                break;
            case "medium":
                $thumbfile = $file->smallthumb;
                break;
            case "large":
            default:
                $thumbfile = $file->largethumb;
                break;
        }

        // Grab the file
        if ($thumbfile && !empty($thumbfile)) {
            $readfile = new ElggFile();
            $readfile->owner_guid = $file->owner_guid;
            $readfile->setFilename($thumbfile);
            $mime = $file->getMimeType();
            $contents = $readfile->grabFile();

            // caching images for 10 days
            header("Content-type: $mime");
            header('Expires: ' . date('r',time() + 864000));
            header("Pragma: public", true);
            header("Cache-Control: public", true);
            header("Content-Length: " . strlen($contents));

            echo $contents;
            exit;
        }


    }
}

?>
