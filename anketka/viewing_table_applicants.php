<?php 
	require_once (dirname(dirname(__DIR__)).'/config.php'); 
	require_once($CFG->libdir . '/outputcomponents.php');
	require_once($CFG->dirroot .'/blocks/application_request/applicantslib.php');
	global $PAGE;
require_login();

if (isguestuser()) {
    die();
}

$returnurl = optional_param('returnurl', '', PARAM_LOCALURL);

if (empty($returnurl)) {
    $returnurl = new moodle_url('/blocks/application_request/preparation_of_the_applicants_questionnaire.php');
}



$context = context_user::instance($USER->id);
//$context = context_user::instance ($pustbudet);
require_capability('moodle/user:manageownfiles', $context);

$title = get_string('privatefiles');
$struser = get_string('user');

$PAGE->set_url('/blocks/application_request/viewing_table_applicants.php');
$PAGE->set_context($context);
$PAGE->set_title($title);
$PAGE->set_heading(fullname($USER));
$PAGE->set_pagelayout('standard');


$PAGE->set_pagetype('my-index');

echo $OUTPUT->header();	
$k = verification_group_membership ($USER->id);
var_dump($k);
$data = $DB -> get_records_sql ('SELECT * FROM {block_app_request_applicants} where ((applicationstatus=2)
									AND ((directionofactivity = ? OR directionofactivity = ? OR directionofactivity = ?
									OR directionofactivity = ? OR directionofactivity = ?) OR 
									(applicantinstitute = ? OR applicantinstitute = ? OR applicantinstitute = ?
									OR applicantinstitute = ? OR applicantinstitute = ?)))', $k);

if (!empty($data))
{
    $table = new html_table();
    //$table->head = array('Фамилия, имя, отчество', 'Институт', 'Телефон','Почта','Дата', 'Документы');
	$table->head = array(get_string('fio', 'block_application_request'), get_string('institute', 'block_application_request'), 
	get_string('telephone', 'block_application_request'), get_string('email', 'block_application_request'),'Направление',
	get_string('date', 'block_application_request'), get_string('documents', 'block_application_request'));
    
    foreach ($data as $item)
    {
        $f = $item -> applicantlastname.' '.$item -> applicantname.' '.$item -> applicantmiddlename;
        $k = $item -> applicantinstitute;
        $y = $item -> applicantphone;
        $m = $item -> applicantemail;
        $direct = $item -> directionofactivity;
		$d = date('d.m.y', $item->applicationsenddate);
		$docs = render_docs_list($item->id,$item->itemid,$item->contextid);
		
		# TODO Сделать нормальный формат дат
        $table->data[] = array ($f, $k, $y, $m,$direct,$d, $docs);
		
    }
    //echo $OUTPUT->heading('Ваши заявления', 2);
	echo $OUTPUT->heading(get_string('yourapplication', 'block_application_request'), 2);
    echo html_writer::table($table);
}

	else echo '<li> соискателей пока нет </li>';	
echo $OUTPUT->footer();		