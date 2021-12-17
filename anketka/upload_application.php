<?php 
require_once (dirname(dirname(__DIR__)).'/config.php'); 
//require_once ($CFG->dirroot . '/lib/formslib.php'); 
//require_once($CFG->libdir.'/ddl/database_manager.php');
//require_once ($CFG -> libdir.'/adminlib.php');
//require_once($CFG->libdir . '/classes/filetypes.php');
//require_once($CFG->dirroot . '/lib/classes/filetypes.php');
//require_once($CFG->dirroot.'/repository/lib.php');
require_once ($CFG->dirroot . '/blocks/application_request/applicantslib.php');
//require_once($CFG->dirroot.'/blocks/edit_form.php');
require_once($CFG->dirroot.'/blocks/application_request/upload_application_form.php');
//require_once($CFG->dirroot.'/user/profile/lib.php');
//require_once($CFG->dirroot.'/user/lib.php');
//require_once($CFG->libdir . '/filelib.php');
//require_once($CFG->libdir . '/badgeslib.php');
//require_once($CFG->libdir.'/gdlib.php');
//require_once($CFG->dirroot.'/user/edit_form.php');
//require_once($CFG->dirroot.'/user/editlib.php');
//require_once($CFG->dirroot.'/user/profile/lib.php');
//require_once($CFG->dirroot.'/user/lib.php');
//require_once($CFG->dirroot . '/my/lib.php');
//require_once($CFG->dirroot."/repository/lib.php");
global $CFG;
global $DB;
global $PAGE;
global $USER;
global $frm;	
global $_FILES;	
	
require_login();
if (isguestuser()) {
    die();
}
$returnurl = optional_param('returnurl', '', PARAM_LOCALURL);
$applicationid = optional_param('id', 0, PARAM_INT);
if (empty($returnurl)) {
    $returnurl = new moodle_url('/blocks/application_request/add_application.php');
}
$context = context_user::instance($USER->id);
$struser = get_string('user');
$PAGE->set_url('/blocks/application_request/add_application.php');
$PAGE->set_context($context);
//$PAGE->set_title($title);
$PAGE->set_heading(fullname($USER));
$PAGE->set_pagelayout('standard');
$PAGE->set_pagetype('my-index');
echo $OUTPUT->header();	
	
$mform = new application_request_upload_application_form($applicationid);
if ($mform->is_cancelled()) {
    //Handle form cancel operation, if cancel button is present on form
    redirect('./checkandsend.php?id='.$applicationid);
} else if ($data = $mform->get_data()) {
    //In this case you process validated data. $mform->get_data() returns data posted in form
    //var_dump($data);
    $draftitemid = file_get_submitted_draft_itemid('attachments'); //Получим itemid 
    $obj = $DB->get_record('block_app_request_applicants', array('id' => $applicationid), '*', MUST_EXIST);

    $obj->contextid = $context->id;
    $obj->itemid = $draftitemid;
    # заносим информацию о скане заявленяи в таблицу
    $DB->update_record('block_app_request_applicants', $obj);
    # сохраняем файл
    # TODO вынести в настройки $maxbytes
    $maxbytes=1000000;
    file_save_draft_area_files($data->attachments, $context->id, 'block_application_request', 'attachment',
    $draftitemid, array('subdirs' => 0, 'maxbytes' => $maxbytes, 'maxfiles' => 1));
    redirect('./checkandsend.php?id='.$applicationid);


} else {
    // this branch is executed if the form is submitted but the data doesn't validate and the form should be redisplayed
    // or on the first display of the form.
    $mform->display();

}            
   
echo $OUTPUT->footer();