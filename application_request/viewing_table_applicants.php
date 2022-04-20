<?php 
	require_once (dirname(dirname(__DIR__)).'/config.php'); 
	require_once($CFG->libdir . '/outputcomponents.php');
	require_once($CFG->dirroot .'/blocks/application_request/applicantslib.php');
	require_once($CFG->dirroot.'/blocks/application_request/time_sort_application_form.php');
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
echo ('**********************');
//$mform = new time_sort_application_form();
//$datas = $mform->get_data();
//$mform->display();
//echo ('&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&');
//var_dump ($datas);
//echo ($datas -> assesstimestart);
//$taim = $datas -> assesstimestart;
$k = verification_group_membership ($USER->id);
// Массив ссылок для сортировки
		$sort_list = array(
		'fio_asc' => '`applicantlastname`',
		'fio_desc' => '`applicantlastname` DESC',
		'inst_asc' => '`applicantinstitute`',
		'inst_desc' => '`applicantinstitute` DESC',
		'napr_asc' => '`directionofactivity`',
		'napr_desc' => '`directionofactivity` DESC',
		);

// Проверка переменной GET		
		$sort = @$_GET['sort'];
		if (array_key_exists($sort, $sort_list))
		{
			$sort_sql = $sort_list[$sort];
		}
			else
			{
				$sort_sql = reset($sort_list);
			}
// Функция вывода ссылок для сортировки			
			function sort_link_bar($title, $a, $b)
			{
				$sort = @$_GET['sort'];
				if ($sort == $a)
				{
					return '<a class="active" href="?sort=' . $b . '">&nbsp;' . $title .'   '. ' <i>▲</i></a>';
				}
					elseif ($sort == $b)
					{
						return '<a class="active" href="?sort=' . $a . '">&nbsp;' . $title .'   '. ' <i>▼</i></a>';
					}
						else
						{
							return '<a href="?sort=' . $a . '">' . $title .'   '. '</a>';
						}
			}
			
echo '<div class="sort-bar">';
echo '<div class="sort-bar-title">Сортировать по:</div>';
echo '<div class="sort-bar-list">';
echo sort_link_bar ('Фамилия', 'fio_asc', 'fio_desc');
echo sort_link_bar ('Институт  ', 'inst_asc', 'inst_desc');
echo sort_link_bar ('Направление  ', 'napr_asc', 'napr_desc');
echo '</div></div>';
$sort = @$_GET['sort'];
if (array_key_exists($sort, $sort_list))
{
	$sort_sql = $sort_list[$sort];
}
else 
{
	$sort_sql = reset($sort_list);
}
//echo ('__________________________');
//var_dump($k);
//if ($datas === NULL) $k["taim"] = '';
//else $k["taim"] = $taim;
//echo ('))))))))))))))))))))))))))))))))))');
//var_dump ($k);
/*$data = $DB -> get_records_sql ('SELECT * FROM {block_app_request_applicants} where ((applicationstatus<>1)
									AND ((directionofactivity = ? OR directionofactivity = ? OR directionofactivity = ?
									OR directionofactivity = ? OR directionofactivity = ?) OR 
									(applicantinstitute = ? OR applicantinstitute = ? OR applicantinstitute = ?
									OR applicantinstitute = ? OR applicantinstitute = ?)))', $k, $sort_sql, '*');*/
									
$data = $DB -> get_records_select ('block_app_request_applicants', '((applicationstatus<>1)
									AND ((directionofactivity = ? OR directionofactivity = ? OR directionofactivity = ?
									OR directionofactivity = ? OR directionofactivity = ?) OR 
									(applicantinstitute = ? OR applicantinstitute = ? OR applicantinstitute = ?
									OR applicantinstitute = ? OR applicantinstitute = ?)))', $k, $sort_sql, '*');									

if (!empty($data))
{
    $table = new html_table();
    $table->head = array('Номер', sort_link_bar ('Фамилия', 'fio_asc', 'fio_desc').'имя, отчество', sort_link_bar ('Институт  ', 'inst_asc', 'inst_desc'), 
	get_string('telephone', 'block_application_request'), get_string('email', 'block_application_request'),sort_link_bar ('Направление  ', 'napr_asc', 'napr_desc'),
	get_string('date', 'block_application_request'), get_string('documents', 'block_application_request'),'Средний балл',"Кол. заявлений",'Статус');
    
    foreach ($data as $item)
    {
        $number = $item -> id;
		$f = $item -> applicantlastname.' '.$item -> applicantname.' '.$item -> applicantmiddlename;
		$f = html_writer::tag('a', $f, array('href' => 'application_review.php?id='.$item->id));
        $k = $item -> applicantinstitute;
        $y = $item -> applicantphone;
        $m = $item -> applicantemail;
		$grade = $item -> grade;
		$app_count = application_count($item->applicantid);
        $direct = $item -> directionofactivity;
		$d = date('d.m.y', $item->applicationsenddate);
		$docs = render_docs_list($item->id,$item->itemid,$item->contextid);
		$status = resolve_status($item -> applicationstatus);
        $table->data[] = array ($number, $f, $k, $y, $m,$direct,$d, $docs,$grade,$app_count,$status);
		
    }

	echo $OUTPUT->heading(get_string('yourapplication', 'block_application_request'), 2);
    echo html_writer::table($table);
	echo $OUTPUT -> download_dataformat_selector('Скачать данные из таблицы', 'download.php');
}

	else echo '<li> соискателей пока нет </li>';	
echo $OUTPUT->footer();		