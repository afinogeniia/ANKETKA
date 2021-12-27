<?php 
	require_once (dirname(dirname(__DIR__)).'/config.php'); 
	
    require_once($CFG->dirroot.'/blocks/application_request/applicantslib.php');
	
require_once($CFG->libdir . '/outputcomponents.php');
	global $PAGE;
	global $USER;
	
	global $DB;
	
require_login();


if (isguestuser()) {
    die();
}

$returnurl = optional_param('returnurl', '', PARAM_LOCALURL);

if (empty($returnurl)) {
    $returnurl = new moodle_url('/blocks/application_request/view_applications_list.php');
}



$context = context_user::instance($USER->id);
//$context = context_user::instance ($pustbudet);
require_capability('moodle/user:manageownfiles', $context);

$title = get_string('privatefiles');
$struser = get_string('user');

$PAGE->set_url('/blocks/application_request/view_application_list.php');
$PAGE->set_context($context);
$PAGE->set_title($title);
$PAGE->set_heading(fullname($USER));
$PAGE->set_pagelayout('standard');


$PAGE->set_pagetype('my-index');

echo $OUTPUT->header();	

$data = $DB -> get_records_sql ('SELECT * FROM {block_app_request_applicants} where applicantid = ? order by id',[$USER->id]);

if (!empty($data))
{
    $table = new html_table();
    //$table->head = array('Фамилия, имя, отчество', 'Институт', 'Телефон','Почта', 'Документы','Статус','');
    $table->head = array(get_string('fio', 'block_application_request'), get_string('institute', 'block_application_request'), 
	get_string('telephone', 'block_application_request'), get_string('email', 'block_application_request'),
	get_string('documents', 'block_application_request'),get_string('status', 'block_application_request'),'');
    foreach ($data as $item)
    {
        $f = $item -> applicantlastname.' '.$item -> applicantname.' '.$item -> applicantmiddlename;
        $k = $item -> applicantinstitute;
        $y = $item -> applicantphone;
        $m = $item -> applicantemail;
        $docs = render_docs_list($item->id,$item->itemid,$item->contextid);
        $status = resolve_status($item->applicationstatus);
        if($item->applicationstatus==1){
            $link = html_writer::tag('a', 'Edit', array('href' => '/blocks/application_request/add_application.php?id='.$item->id));
        }
        else{
            $link = '';
        }
        
        $table->data[] = array ($f, $k, $y, $m,$docs,$status,$link);
    }
    //echo $OUTPUT->heading('Ваши заявления', 2);
	echo $OUTPUT->heading(get_string('yourapplication', 'block_application_request'), 2);
    echo html_writer::table($table);
}
else 
{
    echo '<li> Заявлений нет</li>';	
}
echo $OUTPUT->footer();		