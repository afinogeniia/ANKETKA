<?php 
## На этой странице должно быть отображение всех данных заявления
# и возможность скачать печатную форму заявления
# здесь член комиссии оценивает заявление и выставляет стаутс
#После загрузки заявления появляется кнопка отправить заявления
# это вызов следующго шага
require_once(dirname(dirname(__DIR__)).'/config.php'); 
require_once($CFG->dirroot . '/blocks/application_request/applicantslib.php');
require_once($CFG->dirroot.'/blocks/application_request/application_form.php');
require_once($CFG->dirroot.'/blocks/application_request/status_form.php');

global $PAGE;
global $USER;	
	
require_login();

if (isguestuser()) {
    die();
}
$applicationid = optional_param('id', 0, PARAM_INT);
$context = context_user::instance($USER->id);

$PAGE->set_url('/blocks/application_request/application_review.php');
$PAGE->set_context($context);
$PAGE->set_heading(fullname($USER));
$PAGE->set_pagelayout('standard');
$PAGE->set_pagetype('my-index');

echo $OUTPUT->header();	
echo ('<b>Сведения о кандидате на получение повышенной государственной академической стипендии</b>');
$data = $DB->get_record('block_app_request_applicants', array('id' => $applicationid), '*', MUST_EXIST);
$table1 = create_table_applicant_date($applicationid);
echo html_writer::table($table1);
# TODO сделать красивое отображение данных заявления


$table = create_table_doclist($applicationid,FALSE);	
echo html_writer::table($table);
$mform = new status_form($applicationid,$data->applicationstatus);
if ($mform->is_cancelled()) {
    //Handle form cancel operation, if cancel button is present on form
    redirect('./viewing_table_applicants.php');
} else if ($mdata = $mform->get_data()) {
$mform = new status_form($applicationid,$data->applicationstatus);
    $data->applicationstatus = $mdata->applicationstatus;
    $DB->update_record('block_app_request_applicants', $data);
    $mform->display();
}else{
    $mform->display();
}
echo $OUTPUT->footer();
