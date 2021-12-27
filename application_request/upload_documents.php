<?php 
require_once (dirname(dirname(__DIR__)).'/config.php'); 
require_once ($CFG->dirroot . '/blocks/anketka/applicantslib.php');
require_once($CFG->dirroot.'/blocks/anketka/document_form.php');
global $DB;
global $USER;

require_login();


if (isguestuser()) {
    die();
}

$returnurl = optional_param('returnurl', '', PARAM_LOCALURL);
$applicationid = optional_param('id', 0, PARAM_INT);
$action = optional_param('action', '', PARAM_RAW);
$delete = optional_param('delete', '', PARAM_RAW);


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
	
$mform = new application_document_form($applicationid);
if ($mform->is_cancelled()) {
    //Handle form cancel operation, if cancel button is present on form
} else if ($data = $mform->get_data()) {
	$preobr_dati = $data->date_achievement;
	$nastojashee = date('d.m.y', $preobr_dati);
	
    //In this case you process validated data. $mform->get_data() returns data posted in form
    $draftitemid = file_get_submitted_draft_itemid('attachments'); //Получим itemid 
    $obj = new stdClass();
    $obj->applicationid = $data->id;
	//$obj->applicationid = $USER -> id;
    $obj->achievement = protection_unauthorized ($data->achievement);
    $obj->documentdate = $nastojashee;
    $obj->supportingdocument = protection_unauthorized ($data->document_name);
    $obj->comment = protection_unauthorized ($data->comment);
    $obj->documentpath = '';
    $obj->contextid = $context->id;
    $obj->itemid = $draftitemid;
    $doc_id = $DB->insert_record('block_anketka_documents', $obj, $returnid = false, $bulk = false);
    # TODO вынести $maxbytes = 1000000; в настройки
    $maxbytes = 1000000;
    file_save_draft_area_files($data->attachments, $context->id, 'block_anketka', 'attachment',
        $draftitemid, array('subdirs' => 0, 'maxbytes' => $maxbytes, 'maxfiles' => 1));
    $table = create_table_doclist($applicationid);
    render_application_document_page($table,$applicationid);


} else {
    // this branch is executed if the form is submitted but the data doesn't validate and the form should be redisplayed
    // or on the first display of the form.
    # Если у нас нет достижений, показываем форму по добовлению достижений или если есть команда на добавление
    $table = create_table_doclist($applicationid);
    if(empty($table)||$action=='ADD'){
        $mform->display();
    }
    else{
        # TODO Здесь вначале должно быть удаление достижения
        # TODO Когда-нибудь надо сделать редактирование достижения

        # Если у нас достижения есть, и нет команды на добавление, показываем список достижений
        # над списком будет кнопка добавиь достижение, а под - вернуться к редактированию
        # заявления и кнопка перехода к следующему шагу
        render_application_document_page($table,$applicationid);
    }

}
   
echo $OUTPUT->footer();

