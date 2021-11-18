<?php 
	require_once (dirname(dirname(__DIR__)).'/config.php'); 
	require_once($CFG->libdir . '/outputcomponents.php');
	require_once($CFG->dirroot .'/blocks/anketka/applicantslib.php');
	global $PAGE;
require_login();

if (isguestuser()) {
    die();
}

$returnurl = optional_param('returnurl', '', PARAM_LOCALURL);

if (empty($returnurl)) {
    $returnurl = new moodle_url('/blocks/anketka/preparation_of_the_applicants_questionnaire.php');
}



$context = context_user::instance($USER->id);
//$context = context_user::instance ($pustbudet);
require_capability('moodle/user:manageownfiles', $context);

$title = get_string('privatefiles');
$struser = get_string('user');

$PAGE->set_url('/blocks/anketka/viewing_table_applicants.php');
$PAGE->set_context($context);
$PAGE->set_title($title);
$PAGE->set_heading(fullname($USER));
$PAGE->set_pagelayout('standard');


$PAGE->set_pagetype('my-index');

echo $OUTPUT->header();	

$data = $DB -> get_records_sql ('SELECT * FROM {block_anketka_applicants} where applicationstatus=2');

if (!empty($data))
{
    $table = new html_table();
    $table->head = array('Фамилия, имя, отчество', 'Институт', 'Телефон','Почта','Дата', 'Документы');
    
    foreach ($data as $item)
    {
        $f = $item -> applicantlastname.' '.$item -> applicantname.' '.$item -> applicantmiddlename;
        $k = $item -> applicantinstitute;
        $y = $item -> applicantphone;
        $m = $item -> applicantemail;
		$d = date('d.m.y', $item->applicationsenddate);
		$docs = render_docs_list($item->id,$item->itemid,$item->contextid);
		
		# TODO Сделать нормальный формат дат
        $table->data[] = array ($f, $k, $y, $m,$d, $docs);
    }
    echo $OUTPUT->heading('Ваши заявления', 2);
    echo html_writer::table($table);
}

	else echo '<li> соискателей пока нет </li>';	
echo $OUTPUT->footer();		