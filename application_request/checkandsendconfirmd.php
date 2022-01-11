<?php 
require_once (dirname(dirname(__DIR__)).'/config.php'); 
require_once($CFG->dirroot.'/blocks/application_request/document_form.php');

require_login();


if (isguestuser()) {
    die();
}

$returnurl = optional_param('returnurl', '', PARAM_LOCALURL);
$applicationid = optional_param('id', 0, PARAM_INT);
$action = optional_param('action', '', PARAM_RAW);
$delete = optional_param('delete', '', PARAM_RAW);


if (empty($returnurl)) {
    $returnurl = new moodle_url('/blocks/application_request/upload_documents.php');
}



$context = context_user::instance($USER->id);
//$context = context_user::instance ($pustbudet);



$struser = get_string('user');

$PAGE->set_url('/blocks/application_request/upload_documents.php');
$PAGE->set_context($context);
//$PAGE->set_title($title);
$PAGE->set_heading(fullname($USER));
$PAGE->set_pagelayout('standard');


$PAGE->set_pagetype('my-index');

echo $OUTPUT->header();	

//$DB -> set_debug (true);
	
if ($action == 'SEND' ) {
    $data = $DB->get_record('block_app_request_applicants', array('id' => $applicationid), '*', MUST_EXIST);
    $data->applicationstatus = 2;
    $data->applicationsenddate = time();
    $data->applicationmodifieddate = time();
    $DB->update_record('block_app_request_applicants', $data);
    redirect($CFG->wwwroot . '/blocks/application_request/view_applications_list.php');    
    }
    
    echo $OUTPUT->confirm( format_string( "Вы уверены, что хотите отправить заявку" ),
            "checkandsendconfirmd.php?id={$applicationid}&action=SEND", "./checkandsend.php?id={$applicationid}" );

    echo $OUTPUT->footer();
    die();


    
echo $OUTPUT->footer();

