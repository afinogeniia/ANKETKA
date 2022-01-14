<?php 
require_once (dirname(dirname(__DIR__)).'/config.php'); 
//require_once ($CFG->dirroot . '/lib/formslib.php'); 
require_once ($CFG->dirroot . '/blocks/application_request/applicantslib.php');
require_once($CFG->dirroot.'/blocks/application_request/document_grade_form.php');
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



if (empty($returnurl)) {
    $returnurl = new moodle_url('/blocks/application_request/upload_documents_grade.php');
}



$context = context_user::instance($USER->id);
//$context = context_user::instance ($pustbudet);



$struser = get_string('user');

$PAGE->set_url('/blocks/application_request/upload_documents_grade.php');
$PAGE->set_context($context);
//$PAGE->set_title($title);
$PAGE->set_heading(fullname($USER));
$PAGE->set_pagelayout('standard');


$PAGE->set_pagetype('my-index');

echo $OUTPUT->header();	

$obj = $DB->get_record('block_app_request_documents', array('id' => $docid), '*', MUST_EXIST);
$mform = new document_grade_form($obj);
if ($mform->is_cancelled()) {
    //Handle form cancel operation, if cancel button is present on form
    redirect("./application_review.php?id={$applicationid}");
} else if ($mdata = $mform->get_data()) {
    var_dump($mdata);
    $obj->grade = $mdata->grade;
    $DB->update_record('block_app_request_documents', $obj);
    #redirect("./application_review.php?id={$applicationid}");
}else{
    $mform->display();
}    


echo $OUTPUT->footer();

