<?php 
require_once (dirname(dirname(__DIR__)).'/config.php'); 
//require_once ($CFG->dirroot . '/lib/formslib.php'); 
require_once ($CFG->dirroot . '/blocks/application_request/applicantslib.php');
global $DB;
global $PAGE;
# TODO нужно почистить require_once их явно больше чем надо	
require_login();


if (isguestuser()) {
    die();
}

$returnurl = optional_param('returnurl', '', PARAM_LOCALURL);
$applicationid = optional_param('id', 0, PARAM_INT);
$action = optional_param('action', '', PARAM_RAW);


if (empty($returnurl)) {
    $returnurl = new moodle_url('/blocks/application_request/view_applications_list.php');
}



$context = context_user::instance($USER->id);
//$context = context_user::instance ($pustbudet);



$struser = get_string('user');

$PAGE->set_url('/blocks/application_request/application_del.php');
$PAGE->set_context($context);
//$PAGE->set_title($title);
$PAGE->set_heading(fullname($USER));
$PAGE->set_pagelayout('standard');


$PAGE->set_pagetype('my-index');

echo $OUTPUT->header();	

//$DB -> set_debug (true);
	
if ($action == 'DELETE' ) {
    try{
        $data = $DB->get_record('block_app_request_applicants', array('id' => $applicationid), '*', MUST_EXIST);
    }catch(Exeption $e){
        redirect("./view_applications_list.php");
    }
    $data = $DB -> get_records_sql ('SELECT * FROM {block_app_request_documents} WHERE applicationid = ?', [$applicationid]);
    $fs = get_file_storage();
    foreach($data as $row){
        $itemid = $row->itemid;
        $contextid = $row->contextid;
        $docid = $row->id;
        $DB->delete_records( 'block_app_request_documents', array( "id" => $docid ) );
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

    }
    # Удаляем запись о заявлении
    $DB->delete_records( 'block_app_request_applicants', array( "id" => $applicationid ) );
    redirect("./view_applications_list.php");    
    }
    
echo $OUTPUT->confirm( format_string( "Вы уверены, что хотите удалить заявку" ),
    "application_del.php?id={$applicationid}&action=DELETE", "./view_applications_list.php" );

echo $OUTPUT->footer();

