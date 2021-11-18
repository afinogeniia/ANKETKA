<?php
//require('../config.php');
global $CFG;
require_once (dirname(dirname(__DIR__)).'/config.php');
require_once("$CFG->dirroot/repository/lib.php");
require_once("$CFG->dirroot/blocks/anketka/applicantslib.php");
require_once("$CFG->dirroot/user/files_form.php");
require_once("$CFG->dirroot/mod/quiz/mod_form.php");
require_once($CFG->libdir.'/filelib.php');
require_once("$CFG->dirroot/blocks/anketka/forma_failov_dlya_skachivania.php");
require_once("$CFG->dirroot/repository/lib.php");
//require_once('lib.php');
//require_sesskey();
require_login();

//$DB -> set_debug (true);
if (isguestuser()) {
    die();
}

$returnurl = optional_param('returnurl', '', PARAM_LOCALURL);

if (empty($returnurl)) {
    $returnurl = new moodle_url('/blocks/anketka/uploading_the_applicants_documents.php');
}

$pustbudet = $_POST['poryadkovii'];

//$context = context_user::instance($USER->id);
$context = context_user::instance ($pustbudet);
require_capability('moodle/user:manageownfiles', $context);

$title = get_string('privatefiles');
$struser = get_string('user');

$PAGE->set_url('/blocks/anketka/uploading_the_applicants_documents.php');
$PAGE->set_context($context);
$PAGE -> set_title ('Загрузка документов');
$PAGE->set_heading(fullname($USER));
$PAGE->set_pagelayout('standard');


$PAGE->set_pagetype('my-index');
//repository_user();


// current context
//$contextid = '50';

//$contextid = context_user::instance($USER->id);
$contextid = context_user::instance ($pustbudet);
//$contextid = required_param('contextid', PARAM_INT);
$component = 'user';
$filearea  = 'private';
//$filepath = '/заявка/';
$itemid    = 0;

$data = new stdClass();
$options = array('subdirs'=>1, 'maxfiles'=>-1, 'accepted_types'=>'*', 'return_types'=>FILE_INTERNAL);
file_prepare_standard_filemanager($data, 'files', $options, $context, $component, $filearea, $itemid);
$form = new coursefiles_edit_form(null, array('data'=>$data, 'contextid'=>$contextid));

$returnurl = new moodle_url('/files/index.php');
if ($form->is_cancelled()) {
    redirect($returnurl);
}

if ($data = $form->get_data()) {
    $data = file_postupdate_standard_filemanager($data, 'files', $options, $context, $component, $filearea, $itemid);
    redirect($returnurl);
}
$kkk = $USER -> alternatename;

$kkky = $DB -> get_records_sql ('SELECT * FROM {user} WHERE (id = ?)', [$pustbudet]);

foreach ($kkky as $d)
{
	$ddd = $d -> alternatename;
}
$kykyk3 = explode (" ", $kkk);
echo $OUTPUT->header();

echo $OUTPUT->container_start();
echo ('<div>Уважаемый член комиссии, '.$kykyk3[0].'  '.$kykyk3[1].'!</div>');
echo ('<div>интересующие Вас документы соискателя '.$ddd.' находятся в папке СТИПЕНДИЯ</div>');
$form->display();
echo $OUTPUT->container_end();

echo $OUTPUT->footer();