<?php 
require_once (dirname(dirname(__DIR__)).'/config.php'); 
require_once ($CFG->dirroot . '/lib/formslib.php'); 
require_once($CFG->libdir.'/ddl/database_manager.php');
require_once ($CFG -> libdir.'/adminlib.php');
require_once($CFG->libdir . '/classes/filetypes.php');
require_once($CFG->dirroot . '/lib/classes/filetypes.php');
require_once($CFG->dirroot.'/repository/lib.php');
require_once ($CFG->dirroot . '/blocks/anketka/applicantslib.php');
require_once($CFG->dirroot.'/blocks/edit_form.php');
require_once($CFG->dirroot.'/blocks/anketka/document_form.php');
require_once($CFG->dirroot.'/user/profile/lib.php');
require_once($CFG->dirroot.'/user/lib.php');
require_once($CFG->libdir . '/filelib.php');
require_once($CFG->libdir . '/badgeslib.php');
require_once($CFG->libdir.'/gdlib.php');
require_once($CFG->dirroot.'/user/edit_form.php');
require_once($CFG->dirroot.'/user/editlib.php');
require_once($CFG->dirroot.'/user/profile/lib.php');
require_once($CFG->dirroot.'/user/lib.php');
require_once($CFG->dirroot . '/my/lib.php');
require_once($CFG->dirroot."/repository/lib.php");
global $CFG;
global $DB;
global $PAGE;
global $USER;
global $frm;	
global $_FILES;	
# TODO нужно почистить require_once их явно больше чем надо	
require_login();


if (isguestuser()) {
    die();
}

$returnurl = optional_param('returnurl', '', PARAM_LOCALURL);
$applicationid = optional_param('id', 0, PARAM_INT);
$action = optional_param('action', '', PARAM_RAW);


if (empty($returnurl)) {
    $returnurl = new moodle_url('/blocks/anketka/upload_documents.php');
}



$context = context_user::instance($USER->id);
//$context = context_user::instance ($pustbudet);



$struser = get_string('user');

$PAGE->set_url('/blocks/anketka/upload_documents.php');
$PAGE->set_context($context);
//$PAGE->set_title($title);
$PAGE->set_heading(fullname($USER));
$PAGE->set_pagelayout('standard');


$PAGE->set_pagetype('my-index');

echo $OUTPUT->header();	

//$DB -> set_debug (true);
	
if ($action == 'DELETE' ) {
    $data = $DB->get_record('block_anketka_applicants', array('id' => $applicationid), '*', MUST_EXIST);
    $itemid = $data->itemid;
    $contextid = $data->contextid;
    $data->itemid = NULL;
    $data->contextid = NULL;
    $data->applicationmodifieddate = time();
    $DB->update_record('block_anketka_applicants', $data);

    $fs = get_file_storage();
# Удаляем файлы из блока anketka
    $files = $fs->get_area_files($contextid, 'block_anketka', 'attachment', $itemid);
                
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
 

    
    redirect("./checkandsend.php?id={$applicationid}");    
    }
    
echo $OUTPUT->confirm( format_string( "Вы уверены, что хотите удалить заявку" ),
    "checkandsenddel.php?id={$applicationid}&action=DELETE", "./checkandsend.php?id={$applicationid}" );

echo $OUTPUT->footer();

