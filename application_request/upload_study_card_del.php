<?php 
require_once (dirname(dirname(__DIR__)).'/config.php'); 
//require_once ($CFG->dirroot . '/lib/formslib.php'); 
require_once ($CFG->dirroot . '/blocks/application_request/applicantslib.php');
require_once($CFG->dirroot.'/blocks/application_request/document_form.php');
global $DB;
global $PAGE;
# TODO нужно почистить require_once их явно больше чем надо	
require_login();


if (isguestuser()) {
    die();
}

$returnurl = optional_param('returnurl', '', PARAM_LOCALURL);
$applicationid = optional_param('id', 0, PARAM_INT);
$docid = optional_param('docid', 0, PARAM_INT);
$action = optional_param('action', '', PARAM_RAW);


if (empty($returnurl)) {
    $returnurl = new moodle_url("./application_review.php?id={$applicationid}");
}

$context = context_user::instance($USER->id);

$struser = get_string('user');

$PAGE->set_url('/blocks/application_request/upload_study_card_del.php');
$PAGE->set_context($context);
$PAGE->set_heading(fullname($USER));
$PAGE->set_pagelayout('standard');


$PAGE->set_pagetype('my-index');

echo $OUTPUT->header();	

//$DB -> set_debug (true);
	
if ($action == 'DELETE' ) {
    $data = $DB->get_record('block_app_request_documents', array('id' => $docid), '*', MUST_EXIST);
    $itemid = $data->itemid;
    $contextid = $data->contextid;
    
    $DB->delete_records( 'block_app_request_documents', array( "id" => $docid ) );
    

    $fs = get_file_storage();
# Удаляем файлы из блока application_request
    $files = $fs->get_area_files($contextid, 'block_app_request', 'attachment', $itemid);
                
    foreach ($files as $file) {
        // Delete it if it exists
        if ($file) {
            $file->delete();
        }
    }
# Файлы так же храняться у пользователя, их надо почистить
    $files = $fs->get_area_files($contextid, 'user', 'draft', $itemid);
                
    foreach ($files as $file) {
        // Delete it if it exists
        if ($file) {
            $file->delete();
        }
    }
 

    
    redirect("./application_review.php?id={$applicationid}");    
    }
    
echo $OUTPUT->confirm( format_string( "Вы уверены, что хотите удалить Учебную карточку?" ),
    "upload_study_card_del.php?id={$applicationid}&docid={$docid}&action=DELETE", "./application_review.php?id={$applicationid}" );

echo $OUTPUT->footer();
