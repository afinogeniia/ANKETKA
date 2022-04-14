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
require_once($CFG->dirroot.'/blocks/application_request/status_grade_form.php');
require_once($CFG->dirroot.'/blocks/application_request/grade_form.php');

global $PAGE;
global $USER;	
	
require_login();

if (isguestuser()) {
    die();
}
$applicationid = optional_param('id', 0, PARAM_INT);
$context = context_user::instance($USER->id);

$PAGE->set_url('/blocks/application_request/application_review.php?id={$applicationid}');
$PAGE->set_context($context);
$PAGE->set_heading(fullname($USER));
$PAGE->set_pagelayout('standard');
$PAGE->set_pagetype('my-index');

echo $OUTPUT->header();	
$data = $DB->get_record('block_app_request_applicants', array('id' => $applicationid), '*', MUST_EXIST);
echo ('<b>Сведения о кандидате на получение повышенной государственной академической стипендии</b>');


# TODO сделать красивое отображение данных заявления


$flg_c = committee_membership_check_c($USER -> id,$data->directionofactivity);
$flg_d = committee_membership_check_d($USER -> id,$data->applicantinstitute);

if($flg_c&&$flg_d){
    $mform = new status_grade_form($applicationid,$data->applicationstatus,$data->grade);
    if ($mform->is_cancelled()) {
        //Handle form cancel operation, if cancel button is present on form
        redirect('./viewing_table_applicants.php');
    } else if ($mdata = $mform->get_data()) {
        $mform = new status_grade_form($applicationid,$data->applicationstatus,$data->grade);
        $data->applicationstatus = $mdata->applicationstatus;
        $data->grade = $mdata->grade;
        $DB->update_record('block_app_request_applicants', $data);
        display_study_card_tables($applicationid);
        display_study_card_bottom($applicationid);
        $mform->display();
    }else{
        display_study_card_tables($applicationid);
        display_study_card_bottom($applicationid);
        $mform->display();
    }

}elseif($flg_c){
    $mform = new status_form($applicationid,$data->applicationstatus);
    if ($mform->is_cancelled()) {
        //Handle form cancel operation, if cancel button is present on form
        redirect('./viewing_table_applicants.php');
    } else if ($mdata = $mform->get_data()) {
        $mform = new status_form($applicationid,$data->applicationstatus);
        $data->applicationstatus = $mdata->applicationstatus;
        $DB->update_record('block_app_request_applicants', $data);
        display_study_card_tables($applicationid);
        $mform->display();
    }else{
        display_study_card_tables($applicationid);
        $mform->display();
    }
}elseif($flg_d){
    $mform = new grade_form($applicationid,$data->grade);
    if ($mform->is_cancelled()) {
        //Handle form cancel operation, if cancel button is present on form
        redirect('./viewing_table_applicants.php');
    } else if ($mdata = $mform->get_data()) {
        $mform = new grade_form($applicationid,$data->grade);
        $data->grade = $mdata->grade;
        $DB->update_record('block_app_request_applicants', $data);
        display_study_card_tables($applicationid);
        display_study_card_bottom($applicationid);
        
    }else{
        display_study_card_tables($applicationid);
        display_study_card_bottom($applicationid);
        $mform->display();
    }

}else{
    redirect('./viewing_table_applicants.php');
}
echo $OUTPUT->footer();
