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

$data = $DB -> get_records_sql ('SELECT * FROM {block_app_request_applicants}',[]);
if (!empty($data))
{
	foreach ($data as $item)
    {
		if (($item -> directionofactivity) == 'культурно-творческая деятельность')
		{
			$data1 = $DB -> get_record_sql('SELECT SUM(grade) from {block_app_request_documents} where applicationid = ?',[$item -> id]);
			foreach ($data1 as $summa1)	$cult_creat[] = array ($item -> id, $summa1);
		}
			
		if (($item -> directionofactivity) == 'спортивная деятельность')
		{
			$data2 = $DB -> get_record_sql('SELECT SUM(grade) from {block_app_request_documents} where applicationid = ?',[$item -> id]);
			foreach ($data2 as $summa2) $sport[] = array ($item -> id, $summa2);
		}
		if (($item -> directionofactivity) == 'общественная деятельность')
		{
			$data3 = $DB -> get_record_sql('SELECT SUM(grade) from {block_app_request_documents} where applicationid = ?',[$item -> id]);
			foreach ($data3 as $summa3) $publ[] = array ($item -> id, $summa3);
		}
		if (($item -> directionofactivity) == 'учебная деятельность')
		{
			$data4 = $DB -> get_record_sql('SELECT SUM(grade) from {block_app_request_documents} where applicationid = ?',[$item -> id]);
			foreach ($data4 as $summa4) $educ[] = array ($item -> id, $summa4);
		}
		if (($item -> directionofactivity) == 'научно-исследовательская деятельность')
		{
			$data5 = $DB -> get_record_sql('SELECT SUM(grade) from {block_app_request_documents} where applicationid = ?',[$item -> id]);
			foreach ($data5 as $summa5) $scien_res[] = array ($item -> id, $summa5);
		}
	}
}

/*function sorting_array_elements ($a, $b)
{
	if ($a[1] == $b[1]) return 0;
	if ($a[1] > $b[1]) return -1;
		else return 1;
}*/

usort ($cult_creat, 'sorting_array_elements');
usort ($sport, 'sorting_array_elements');
usort ($publ, 'sorting_array_elements');
usort ($scien_res, 'sorting_array_elements');
usort ($educ, 'sorting_array_elements');

$quantity = max(count($cult_creat), count($sport), count($publ), count($scien_res), count($educ));

$table = new html_table();
	$table->head = array ('Учебная', 'деятельность', 'Научно-исследовтельская', 'деятельность',
						  'Общественная', 'деятельность', 'Культурно-творческая', 'деятельность',
						  'Спортивная', 'деятельность');
    /*$table->head = array('number', 'rating', 'number', 'rating', 'number', 'rating', 'number', 'rating', 
						 'number', 'rating');
	$table->data[] = array('cult_creat number', 'cult_creat rating', 'sport number', 'sport rating', 
						 'publ number', 'publ rating', 'scien_res number', 'scien_res rating', 
						 'educ number', 'educ rating');*/
	$table->data[] = array('Номер заявления', 'Рейтинг обучающегося', 'Номер заявления', 'Рейтинг обучающегося', 
						   'Номер заявления', 'Рейтинг обучающегося', 'Номер заявления', 'Рейтинг обучающегося', 
						   'Номер заявления', 'Рейтинг обучающегося');				 
	for ($q = 0; $q < $quantity; $q++)
	{
		if (empty($cult_creat[$q]))
		{
			$ccn = ''; 
			$ccr = '';
		}
			else 
			{
				$ccn = $cult_creat[$q][0];
				$ccr = $cult_creat[$q][1];
			}
if (empty($sport[$q]))
		{
			$sn = ''; 
			$sr = '';
		}
			else 
			{
				$sn = $sport[$q][0];
				$sr = $sport[$q][1];
			}
if (empty($publ[$q]))
		{
			$pn = ''; 
			$pr = '';
		}
			else 
			{
				$pn = $publ[$q][0];
				$pr = $publ[$q][1];
			}
if (empty($scien_res[$q]))
		{
			$srn = ''; 
			$srr = '';
		}
			else 
			{
				$srn = $scien_res[$q][0];
				$srr = $scien_res[$q][1];
			}
if (empty($educ[$q]))
		{
			$en = ''; 
			$er = '';
		}
			else 
			{
				$en = $educ[$q][0];
				$er = $educ[$q][1];
			}
			
			
			
			
			/*$table->data[] = array ($ccn, $ccr,
								$sn, $sr,
								$pn, $pr,
								$srn, $srr,
								$en, $er);*/
			/*$table->data[] = array ($cult_creat[$q][0], $cult_creat[$q][1],
								$sport[$q][0], $sport[$q][1],
								$publ[$q][0], $publ[$q][1],
								$scien_res[$q][0], $scien_res[$q][1],
								$educ[$q][0], $educ[$q][1]);*/
			$table->data[] = array ($en, $er,
									$srn, $srr,
									$pn, $pr,
									$ccn, $ccr,
									$sn, $sr);
	}
 echo $OUTPUT->heading('Рейтинг заявлений обучающихся по грантам Университета (осенний семестр 2021-22 учебного года)', 2);
 //$table->sortable(true, 'Учебная', SORT_ASC);
 echo html_writer::table($table);
 echo $OUTPUT -> download_dataformat_selector('Скачать данные из таблицы', 'download_rating.php');
 echo $OUTPUT->footer();
 
 /*    foreach ($columns as $column) {
        $string[$column] = get_user_field_name($column);
        if ($sort != $column) {
            $columnicon = "";
            if ($column == "lastaccess") {
                $columndir = "DESC";
            } else {
                $columndir = "ASC";
            }
        } else {
            $columndir = $dir == "ASC" ? "DESC":"ASC";
            if ($column == "lastaccess") {
                $columnicon = ($dir == "ASC") ? "sort_desc" : "sort_asc";
            } else {
                $columnicon = ($dir == "ASC") ? "sort_asc" : "sort_desc";
            }
            $columnicon = $OUTPUT->pix_icon('t/' . $columnicon, get_string(strtolower($columndir)), 'core',
                                            ['class' => 'iconsort']);

        }
        $$column = "<a href=\"user.php?sort=$column&amp;dir=$columndir\">".$string[$column]."</a>$columnicon";
    }*/