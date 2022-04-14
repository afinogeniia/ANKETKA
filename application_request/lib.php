<?php
// ===============
//
//	Plugin File
//
// ===============
// I M P O R T A N T
// 
// This is the most confusing part. For each plugin using a file manager will automatically
// look for this function. It always ends with _pluginfile. Depending on where you build
// your plugin, the name will change. In case, it is a local plugin called file manager.
function block_application_request_pluginfile($course, $cm, $context, $filearea, $args, $forcedownload, array $options=array()) {
    global $DB;
#    if ($context->contextlevel != CONTEXT_SYSTEM) {
#        return false;
#    }
    require_login();
    if ($filearea != 'attachment') {
        return false;
    }
    $itemid = (int) array_shift($args);
    if (!$itemid) {
        return false;
    }
    $fs = get_file_storage();
    $filename = array_pop($args);
    if (empty($args)) {
        $filepath = '/';
    } else {
        $filepath = '/' . implode('/', $args) . '/';
    }
    $file = $fs->get_file($context->id, 'block_application_request', $filearea, $itemid, $filepath, $filename);
    if (!$file) {
        return false;
    }

    // finally send the file
    send_stored_file($file, 0, 0, true, $options); // download MUST be forced - security!
    die();
}
