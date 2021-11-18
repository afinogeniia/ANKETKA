<?php
require_once (dirname(dirname(__DIR__)).'/config.php');
require_once ($CFG->dirroot . '/lib/formslib.php');
require_once ($CFG->dirroot . '/blocks/anketka/applicants_application_form.php');
global $CFG, $COURSE, $USER, $DB;
//$DB -> set_debug (true);
require_login();

//$DB -> set_debug (true);
if (isguestuser()) {
    die();
}

$returnurl = optional_param('returnurl', '', PARAM_LOCALURL);

if (empty($returnurl)) {
    $returnurl = new moodle_url('/blocks/anketka/preparation_of_the_applicants_questionnaire.php');
}



$context = context_user::instance($USER->id);
//$context = context_user::instance ($pustbudet);

require_capability('moodle/user:manageownfiles', $context);


$struser = get_string('user');

$PAGE->set_url('/blocks/anketka/uploading_the_applicants_documents.php');
$PAGE->set_context($context);
//$PAGE->set_title($title);
$PAGE->set_heading(fullname($USER));
$PAGE->set_pagelayout('standard');


$PAGE->set_pagetype('my-index');

echo $OUTPUT->header();	
$mform = new applicants_test_file ();
	$mform->display();
$fs = get_file_storage();
$mf = $mform -> get_data();
echo ('------------MF---------------');
var_dump ($mf);
$relativepath  = get_file_argument();
$hasuploadedpicture = ($fs->file_exists($context->id, 'user', 'icon', 0, '/', 'f2.png') || $fs->file_exists($context->id, 'user', 'icon', 0, '/', 'f2.jpg'));
$user = $DB->get_record('user', array('id' => $USER -> id));
//$imagevalue = $OUTPUT->user_picture($user, array('courseid' => SITEID, 'size' => 64));
$maxbytes = $CFG->userquota;
$maxareabytes = $CFG->userquota;
if (has_capability('moodle/user:ignoreuserquota', $context)) {
    $maxbytes = USER_CAN_IGNORE_FILE_SIZE_LIMITS;
    $maxareabytes = FILE_AREA_MAX_BYTES_UNLIMITED;
}

$data = new stdClass();
$data->returnurl = $returnurl;
$options = array('subdirs' => 1, 'maxbytes' => $maxbytes, 'maxfiles' => -1, 'accepted_types' => '*',
        'areamaxbytes' => $maxareabytes);
file_prepare_standard_filemanager($data, 'files', $options, $context, 'user', 'private', 0);
if ($mform->is_cancelled()) {
    //redirect($returnurl);
} else if ($formdata = $mform->get_data()) {
    $formdata = file_postupdate_standard_filemanager($formdata, 'files', $options, $context, 'user', 'private', 0);
    //redirect($returnurl);
}

echo $OUTPUT->footer();