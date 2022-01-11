<?php 
require_once (dirname(dirname(__DIR__)).'/config.php'); 
require_once ($CFG->dirroot . '/blocks/application_request/applicantslib.php');
# TODO нужно почистить require_once их явно больше чем надо	
require_login();


if (isguestuser()) {
    die();
}

$returnurl = optional_param('returnurl', '', PARAM_LOCALURL);
$applicationid = optional_param('id', 0, PARAM_INT);
$action = optional_param('action', '', PARAM_RAW);



$text = create_application_print($applicationid);



header('Content-Type: application/rtf');	


// Он будет называться downloaded.pdf
header('Content-Disposition: attachment; filename="downloaded.rtf"');

// Исходный PDF-файл original.pdf
echo $text;



