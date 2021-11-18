<?php 
	require_once (dirname(dirname(__DIR__)).'/config.php'); 
	//require_once ($CFG->dirroot . '/lib/formslib.php'); 
	//require_once($CFG->libdir.'/ddl/database_manager.php');
	//require_once ($CFG -> libdir.'/adminlib.php');
	//require_once($CFG->libdir . '/classes/filetypes.php');
	//require_once($CFG->dirroot . '/lib/classes/filetypes.php');
	//require_once($CFG->dirroot.'/blocks/edit_form.php');
    require_once($CFG->dirroot.'/blocks/anketka/applicantslib.php');
	//require_once($CFG->dirroot . '/my/lib.php');
require_once($CFG->libdir . '/outputcomponents.php');
	global $PAGE;
	global $USER;
	//global $frm;	
	global $DB;
	//global $CFG;
	//global $_FILES;
require_login();

//$DB -> set_debug (true);
if (isguestuser()) {
    die();
}

$returnurl = optional_param('returnurl', '', PARAM_LOCALURL);

if (empty($returnurl)) {
    $returnurl = new moodle_url('/blocks/anketka/view_applications_list.php');
}



$context = context_user::instance($USER->id);
//$context = context_user::instance ($pustbudet);
require_capability('moodle/user:manageownfiles', $context);

$title = get_string('privatefiles');
$struser = get_string('user');

$PAGE->set_url('/blocks/anketka/view_application_list.php');
$PAGE->set_context($context);
$PAGE->set_title($title);
$PAGE->set_heading(fullname($USER));
$PAGE->set_pagelayout('standard');


$PAGE->set_pagetype('my-index');

echo $OUTPUT->header();	

$data = $DB -> get_records_sql ('SELECT * FROM {block_anketka_applicants} where applicantid = ? order by id',[$USER->id]);

if (!empty($data))
{
    $table = new html_table();
    $table->head = array('Фамилия, имя, отчество', 'Институт', 'Телефон','Почта', 'Документы','Статус','');
    
    foreach ($data as $item)
    {
        $f = $item -> applicantlastname.' '.$item -> applicantname.' '.$item -> applicantmiddlename;
        $k = $item -> applicantinstitute;
        $y = $item -> applicantphone;
        $m = $item -> applicantemail;
        $docs = render_docs_list($item->id,$item->itemid,$item->contextid);
        $status = resolve_status($item->applicationstatus);
        if($item->applicationstatus!=2){
            $link = html_writer::tag('a', 'Edit', array('href' => '/blocks/anketka/add_application.php?id='.$item->id));
        }
        else{
            $link = '';
        }
        
        $table->data[] = array ($f, $k, $y, $m,$docs,$status,$link);
    }
    echo $OUTPUT->heading('Ваши заявления', 2);
    echo html_writer::table($table);
}
else 
{
    echo '<li> Заявлений нет</li>';	
}
echo $OUTPUT->footer();		