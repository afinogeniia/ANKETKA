<?php
require_once (dirname(dirname(__DIR__)).'/config.php'); 
require_once ($CFG->dirroot . '/lib/formslib.php');
require_once ($CFG->dirroot . '/cohort/lib.php');


function creating_cohorts_begin()
{
	$scholarship_request_cohorts = array();
	$scholarship_request_cohorts[0] = 'scholarship_request_educational_activities';
	$scholarship_request_cohorts[1] = 'scholarship_request_research_activities';
	$scholarship_request_cohorts[2] = 'scholarship_request_public_activities';
	$scholarship_request_cohorts[3] = 'scholarship_request_culturalcreative_activities';
	$scholarship_request_cohorts[4] = 'scholarship_request_sports_activities';
	$scholarship_request_cohorts[5] = 'scholarship_request_isop';
	$scholarship_request_cohorts[6] = 'scholarship_request_ip';
	$scholarship_request_cohorts[7] = 'scholarship_request_iu';
	$scholarship_request_cohorts[8] = 'scholarship_request_igimp';
	$scholarship_request_cohorts[9] = 'scholarship_request_ipip';
	$scholarship_request_cohorts[10] = 'scholarship_request_students';
	return $scholarship_request_cohorts;
}

function make_cohorts_array(){
	$scholarship_request_cohorts = array();
	$scholarship_request_cohorts[0] = 'scholarship_request_educational_activities';
	$scholarship_request_cohorts[1] = 'scholarship_request_research_activities';
	$scholarship_request_cohorts[2] = 'scholarship_request_public_activities';
	$scholarship_request_cohorts[3] = 'scholarship_request_culturalcreative_activities';
	$scholarship_request_cohorts[4] = 'scholarship_request_sports_activities';
	$scholarship_request_cohorts[5] = 'scholarship_request_isop';
	$scholarship_request_cohorts[6] = 'scholarship_request_ip';
	$scholarship_request_cohorts[7] = 'scholarship_request_iu';
	$scholarship_request_cohorts[8] = 'scholarship_request_igimp';
	$scholarship_request_cohorts[9] = 'scholarship_request_ipip';
	return $scholarship_request_cohorts;
}

function make_cohorts_array_c(){
	$scholarship_request_cohorts = array();
	$scholarship_request_cohorts[0] = 'scholarship_request_educational_activities';
	$scholarship_request_cohorts[1] = 'scholarship_request_research_activities';
	$scholarship_request_cohorts[2] = 'scholarship_request_public_activities';
	$scholarship_request_cohorts[3] = 'scholarship_request_culturalcreative_activities';
	$scholarship_request_cohorts[4] = 'scholarship_request_sports_activities';
	return $scholarship_request_cohorts;
}

function make_cohorts_array_d(){
	$scholarship_request_cohorts = array();
	$scholarship_request_cohorts[5] = 'scholarship_request_isop';
	$scholarship_request_cohorts[6] = 'scholarship_request_ip';
	$scholarship_request_cohorts[7] = 'scholarship_request_iu';
	$scholarship_request_cohorts[8] = 'scholarship_request_igimp';
	$scholarship_request_cohorts[9] = 'scholarship_request_ipip';
	return $scholarship_request_cohorts;
}



function verification_group_membership_check ($userid)
{
	global $DB;
	$scholarship_request_cohorts = creating_cohorts_begin ();
	$array_global_groups = array();
	$flag = 0;
	for ($i = 0; $i <= 9; $i++)
	{
		$idcohort1 = $DB -> get_records_sql ('SELECT * FROM {cohort} WHERE (name = ?)', [$scholarship_request_cohorts[$i]]);
		foreach ($idcohort1 as $idcohort2) $idcohort = $idcohort2 -> id;
		$chekingthegroup = $DB -> get_records_sql ('SELECT * FROM {cohort_members} WHERE (cohortid = ? AND userid = ?)', [$idcohort, $userid]);
		if ($chekingthegroup !== [])
		{
			$array_global_groups[$scholarship_request_cohorts[$i]] = 1;
			$flag = 1;
		}
			else $array_global_groups[$scholarship_request_cohorts[$i]] = 0;
	}
	if ($flag == 1) return TRUE;
		else return FALSE;
}

function verification_group_membership ($userid)
{
	global $DB;
	$scholarship_request_cohorts = creating_cohorts_begin ();
	$array_global_groups = array();

	if (cohort_membership_check($userid,'scholarship_request_educational_activities')) {
		$array_global_groups['scholarship_request_educational_activities'] = 'учебная деятельность';
	}else{
		$array_global_groups['scholarship_request_educational_activities'] = 'нет';
	}
	if (cohort_membership_check($userid,'scholarship_request_research_activities')){
		$array_global_groups['scholarship_request_research_activities'] = 'научно-исследовательская деятельность';
	}else{
		$array_global_groups['scholarship_request_research_activities'] = 'yj';
	}
	if (cohort_membership_check($userid,'scholarship_request_public_activities')) {
		$array_global_groups['scholarship_request_public_activities'] = 'общественная деятельность';
	}else{
		$array_global_groups['scholarship_request_public_activities'] = '5454';
	}
	if (cohort_membership_check($userid,'scholarship_request_culturalcreative_activities')) {
		$array_global_groups['scholarship_request_culturalcreative_activities'] = 'культурно-творческая деятельность';
	}else{
		$array_global_groups['scholarship_request_culturalcreative_activities'] = 'rdsf';
	}
	if (cohort_membership_check($userid,'scholarship_request_sports_activities')) {
		$array_global_groups['scholarship_request_sports_activities'] = 'спортивная деятельность';
	}else{
		$array_global_groups['scholarship_request_sports_activities'] = 'ne to';
	}
	if (cohort_membership_check($userid,'scholarship_request_isop')) {
		$array_global_groups['scholarship_request_isop'] = 'ИСОП';
	}else{
		$array_global_groups['scholarship_request_isop'] = 'fdfds';
	}
	if (cohort_membership_check($userid,'scholarship_request_ip')) {
		$array_global_groups['scholarship_request_ip'] = 'ИП';
	}else{
		$array_global_groups['scholarship_request_ip'] = '546gdfsg';
	}
	if (cohort_membership_check($userid,'scholarship_request_iu')) {
		$array_global_groups['scholarship_request_iu'] = 'ИЮ';
	}else{
		$array_global_groups['scholarship_request_iu'] = 'dfsdfa';
	}
	if (cohort_membership_check($userid,'scholarship_request_ipip')) {
		$array_global_groups['scholarship_request_ipip'] = 'ИПИП';
	}else{
		$array_global_groups['scholarship_request_ipip'] = '4545';
	}
	if (cohort_membership_check($userid,'scholarship_request_igimp')) {
		$array_global_groups['scholarship_request_igimp'] = 'ИГИМП';
	}else{
		$array_global_groups['scholarship_request_igimp'] = 'safasdfa';
	}
	return $array_global_groups;
}

function creating_cohorts ()
{
	global $DB;
	$scholarship_request_cohorts = creating_cohorts_begin ();
	for ($i = 0; $i<= 10; $i++)
	{
		$for_creating_cohorts = $DB ->get_records_sql('SELECT * FROM {cohort} WHERE name = ?', [$scholarship_request_cohorts[$i]]);
		//Создание новой глобальной группы, если её в Moodle нет
		if ($for_creating_cohorts === [])
		{
			$global_group = new StdClass();
			$global_group->name = $global_group->idnumber = $scholarship_request_cohorts[$i];
			$global_group->contextid = context_system::instance()->id;					
			$global_group_id = cohort_add_cohort($global_group);
		}
	}

	return TRUE;
}
	
function student_membership_check($userid){
	global $DB;
	$sql = 'SELECT c.name FROM {cohort} as c INNER JOIN {cohort_members} AS cm ON c.id=cm.cohortid WHERE cm.userid = ?';
	$rows = $DB->get_records_sql($sql,[$userid]);
	foreach($rows as $row){
		if($row->name=='scholarship_request_students'){
			return TRUE;
		}
	}
	return FALSE;
}

function cohort_membership_check($userid,$cohort){
	global $DB;
	$sql = 'SELECT c.name FROM {cohort} as c INNER JOIN {cohort_members} AS cm ON c.id=cm.cohortid WHERE cm.userid = ?';
	$rows = $DB->get_records_sql($sql,[$userid]);
	foreach($rows as $row){
		if($row->name==$cohort){
			return TRUE;
		}
	}
	return FALSE;
}

function committee_membership_check($userid){
	global $DB;
	$committee = make_cohorts_array();
	$sql = 'SELECT c.name FROM {cohort} as c INNER JOIN {cohort_members} AS cm ON c.id=cm.cohortid WHERE cm.userid = ?';
	$rows = $DB->get_records_sql($sql,[$userid]);
	foreach($rows as $row){
		if(!(array_search($row->name,$committee)===FALSE)){
			return TRUE;
		}
	}
	return FALSE;
}

function committee_membership_check_c($userid,$directionofactivity){
	global $DB;
	$opt = array(
		'учебная деятельность' => 'scholarship_request_educational_activities',
		'научно-исследовательская деятельность' => 'scholarship_request_research_activities',
		'общественная деятельность' => 'scholarship_request_public_activities',
		'культурно-творческая деятельность' => 'scholarship_request_culturalcreative_activities',
		'спортивная деятельность' => 'scholarship_request_sports_activities');
	$sql = 'SELECT c.name FROM {cohort} as c INNER JOIN {cohort_members} AS cm ON c.id=cm.cohortid WHERE cm.userid = ?';
	$rows = $DB->get_records_sql($sql,[$userid]);
	foreach($rows as $row){
		if($row->name==$opt[$directionofactivity]){
			return TRUE;
		}
	}
	return FALSE;
}

function committee_membership_check_d($userid,$dekanat){
	global $DB;
	$opt = array(
		'ИГИМП' => 'scholarship_request_igimp',
		'ИПИП' => 'scholarship_request_ipip',
		'ИП' => 'scholarship_request_ip',
		'ИСОП' => 'scholarship_request_isop',
		'ИЮ' => 'scholarship_request_iu');
	
	$sql = 'SELECT c.name FROM {cohort} as c INNER JOIN {cohort_members} AS cm ON c.id=cm.cohortid WHERE cm.userid = ?';
	$rows = $DB->get_records_sql($sql,[$userid]);
	foreach($rows as $row){
		if($row->name==$opt[$dekanat]){
			return TRUE;
		}
	}
	return FALSE;
}

function conversion_parametr_a ($activity)
{
	switch($activity)
	{
		case 0: $activity = "учебная деятельность"; break;
		case 1: $activity = "научно-исследовательская деятельность"; break;
		case 2: $activity = "общественная деятельность"; break;
		case 3: $activity = "культурно-творческая деятельность"; break;
		case 4: $activity = "спортивная деятельность"; break;
	}
	return ($activity);
}

function conversion_parametr_y ($yesno)
{
	switch ($yesno)
	{
		case 1: $yesno = "да"; break;
		case 0: $yesno = "нет"; break;
	}
	return ($yesno);
}

/*function imyazajavki ($poryadkoviinomer)
{
	$imyavremennogofaila = "$poryadkoviinomer";
	$imyachko = ".rtf";
	$imyachkofailika = $imyavremennogofaila.$imyachko;
	return ($imyachkofailika);
}*/

/*function file_get_file_area_info_svoja($contextid, $component, $filearea, $itemid = 0, $filepath = '/заявка/') {

    $fs = get_file_storage();

    $results = array(
        'filecount' => 0,
        'foldercount' => 0,
        'filesize' => 0,
        'filesize_without_references' => 0
    );

    $draftfiles = $fs->get_directory_files($contextid, $component, $filearea, $itemid, $filepath, true, true);

    foreach ($draftfiles as $file) {
        if ($file->is_directory()) {
            $results['foldercount'] += 1;
        } else {
            $results['filecount'] += 1;
        }

        $filesize = $file->get_filesize();
        $results['filesize'] += $filesize;
        if (!$file->is_external_file()) {
            $results['filesize_without_references'] += $filesize;
        }
    }

    return $results;
}*/

/*function file_prepare_standard_filemanager_svoja($data, $field, array $options, $context=null, $component=null, $filearea=null, $itemid=null) {
    global $DB;
	$DB -> set_debug (true);
	$options = (array)$options;
    if (!isset($options['subdirs'])) {
        $options['subdirs'] = false;
    }
    if (is_null($itemid) or is_null($context)) {
        $itemid = null;
        $contextid = null;
    } else {
        $contextid = $context->id;
    }

    $draftid_editor = file_get_submitted_draft_itemid($field.'_filemanager');
    file_prepare_draft_area($draftid_editor, $contextid, $component, $filearea, $itemid, $options);
    $data->{$field.'_filemanager'} = $draftid_editor;

    return $data;
}*/

/*
Функция проверяет наличие у текущего пользователя заявлений
*/
function is_application_exists(){
    global $DB;
    global $USER;
    $data = $DB -> get_records_sql ('SELECT * FROM {block_app_request_applicants} where applicantid = ? order by id',[$USER->id]);
    if(!$data){
        return FALSE;
    }
    else{
        return TRUE;
    }
}
/*
Функция готовит текст завляения заполняя шаблон данными из базы.
*/
function create_application_print(int $id){
    global $DB;
    $data = $DB -> get_records_sql ('SELECT * FROM {block_app_request_applicants} WHERE (id = ?)', [$id]);
	foreach ($data as $oops)
	{
		$applicationid = $oops -> id;
	}
	$data1 = $DB -> get_records_sql ('SELECT * FROM {block_app_request_documents} WHERE (applicationid = ?)', [$applicationid]);
    $file = fopen ('anketka.rtf','r');
    $text = fread ($file, filesize('anketka.rtf'));
    fclose ($file);
    $text = str_replace ('</INVENTPRY>', '', $text);
	$i = 1;
	foreach ($data1 as $item1)
	{
		foreach ($data as $item)
		{
			$text = str_replace ('Familia', iconv("UTF-8","cp1251",$item -> applicantlastname), $text);
			$text = str_replace ('imya', iconv ("UTF-8","cp1251",$item -> applicantname), $text);
			$text = str_replace ('otchestvo', iconv ("UTF-8","cp1251",$item -> applicantmiddlename), $text);
			$text = str_replace ('Institut', iconv ("UTF-8","cp1251",$item -> applicantinstitute), $text);
			$text = str_replace ('Kurs', iconv ("UTF-8","cp1251",$item -> applicantcourse), $text);
			$text = str_replace ('gruppa', iconv ("UTF-8","cp1251",$item -> applicantgroup), $text);
			$text = str_replace ('phone', iconv ("UTF-8","cp1251",$item -> applicantphone), $text);
			$text = str_replace ('email', iconv ("UTF-8","cp1251",$item -> applicantemail), $text);
			$direction = $item -> directionofactivity;
			//$n = conversion_parametr_direct ($n);
			switch($direction)
			{
				case "учебная деятельность": $direction = "учебной"; break;
				case "научно-исследовательская деятельность": $direction = "научно-исследовательской"; break;
				case "общественная деятельность": $direction = "общественной"; break;
				case "культурно-творческая деятельность": $direction = "культурно-творческой"; break;
				case "спортивная деятельность": $direction = "спортивной"; break;
			}
			//$n = coversion_parametr_direct ($item -> directionofactivity);
			$text = str_replace ('direction', iconv ("UTF-8","cp1251",$direction), $text);
			$text = str_replace ('deyatelnost', iconv ("UTF-8","cp1251",$item -> directionofactivity), $text);
			$text = str_replace ('poluchenie', iconv ("UTF-8","cp1251",$item -> scholarshipholder), $text);
			//заполнение приложения к заявке
			$jk = dechex($i);			
			$text = str_replace ('N'."$jk", iconv("UTF-8","cp1251",$i), $text);
			$text = str_replace ('Dost'."$jk", iconv ("UTF-8","cp1251",$item1 -> achievement), $text);
			$text = str_replace ('Data'."$jk", iconv ("UTF-8","cp1251",$item1 -> documentdate), $text);
			$text = str_replace ('Doc'."$jk", iconv ("UTF-8","cp1251",$item1 -> supportingdocument), $text);
			$text = str_replace ('Prim'."$jk", iconv ("UTF-8","cp1251",$item1 -> comment), $text);
			$i++;
		}
	}
	for ($c = $i; $c <= 13; $c++)
		{
			$jk = dechex($c);
			$text = str_replace ('N'."$jk", "", $text);
			$text = str_replace ('Dost'."$jk", "", $text);
			$text = str_replace ('Data'."$jk", "", $text);
			$text = str_replace ('Doc'."$jk", "", $text);
			$text = str_replace ('Prim'."$jk", "", $text);	
		}
    return $text;
}

/*function checking_validity_phone ($phone)
{
	if (preg_match ('/^[0-9]$/', $phone))
	{
		$mess = '';
	}
		else $mess = '<div>неверно указан номер</div>';
	return $mess;
}*/

function create_table_doclist(int $id,bool $dellnk=TRUE){
    global $DB;
	global $USER;
    $data = $DB -> get_records_sql('SELECT * FROM {block_app_request_documents} where applicationid = ? order by supportingdocument',[$id]);
    if(empty($data)){
        return NULL;
    }
	$data1 = $DB->get_record('block_app_request_applicants', array('id' => $id), '*', MUST_EXIST);
    $table = new html_table();
    //$table->head = array('Достижение', 'Подтвержающий документ', 'Дата документа','Скачать', '');
	if($dellnk){
		$table->head = array(get_string('achievement', 'block_application_request'), get_string('confirmation', 'block_application_request'),
			get_string('documentdate', 'block_application_request'), get_string('download', 'block_application_request'), '');
	}else{
		$table->head = array(get_string('achievement', 'block_application_request'), get_string('confirmation', 'block_application_request'),
			get_string('documentdate', 'block_application_request'), get_string('download', 'block_application_request'),'Балл', '');

	}
	$grade_sum = 0.0;
    
    foreach ($data as $item)
    {
        $f = $item -> achievement;
        $k = $item -> supportingdocument;
        $y = $item -> documentdate;
        $itemid = $item->itemid;
        $contextid = $item->contextid;
		$grade = $item->grade===null? 0 : $item->grade+0;
		$grade_sum = $grade_sum+$grade;

        $link = display_files($contextid,$itemid);
		if($dellnk){
			$del = html_writer::start_tag( 'a', array( 'href' => "./upload_documents_del.php?id={$id}&docid={$item->id}" ) )
            .format_string( get_string('delete', 'block_application_request') )
            .html_writer::end_tag( 'a' );
			$table->data[] = array ($f, $k, $y, $link,$del);
		}elseif(committee_membership_check_c($USER->id,$data1->directionofactivity)){
			$del = html_writer::start_tag( 'a', array( 'href' => "./upload_documents_grade.php?id={$id}&docid={$item->id}" ) )
            .format_string('Оценить')
            .html_writer::end_tag( 'a' );
			$table->data[] = array ($f, $k, $y, $link,$grade,$del);
		}else{
			$del = "";
			$table->data[] = array ($f, $k, $y, $link,$grade,$del);
		}
        
    }
	if(!$dellnk){
		$table->data[] = array ("", "", "", "<b>Итого</b>",$grade_sum,"");
	}

    return $table;    
}

function create_table_applicant_date(int $id){
    global $DB;
	global $USER;
	$data = $DB -> get_records_sql('SELECT * FROM {block_app_request_applicants} where id = ?',[$id]);
    if(empty($data)){
        return NULL;
    }

    $table = new html_table();
    $table->head = array('', '');
    
    foreach ($data as $item)
    {
        $number = $item -> id;
		$f = $item -> applicantlastname;
		$i = $item -> applicantname;
		$o = $item -> applicantmiddlename;
		$ii = $item -> applicantinstitute;
		$k = $item -> applicantcourse;
		$g = $item -> applicantgroup;
		$t = $item -> applicantphone;
		$p = $item -> applicantemail;
		$d = $item -> directionofactivity;
		$iii = $item -> scholarshipholder;
		$grade = $item->grade;
		$status = $item->applicationstatus;
    }
	$table->data[] = array ('Номер заявления', $number);
	$table->data[] = array ('Фамилия', $f);
	//$table->data[] = array (get_string('lastname', block_anketka), $f);
	$table->data[] = array ('Имя', $i);
	//$table->data[] = array (get_string('firstname', block_anketka), $i);
	$table->data[] = array ('Отчество', $o);
	//$table->data[] = array (get_string('middlename', block_anketka), $o);
	$table->data[] = array ('Институт', $ii);
	//$table->data[] = array (get_string('institute', block_anketka), $ii);
	$table->data[] = array ('Курс', $k);
	//$table->data[] = array (get_string('course', block_anketka), $k);
	$table->data[] = array ('Группа', $g);
	//$table->data[] = array (get_string('group', block_anketka), $g);
	$table->data[] = array ('Номер телефона', $t);
	//$table->data[] = array (get_string('telephone', block_anketka), $t);
	$table->data[] = array ('Адрес электронной почты', $p);
	//$table->data[] = array (get_string('email', block_anketka), $p);
	$table->data[] = array ('Направление деятельности', $d);
	//$table->data[] = array (get_string('type', block_anketka), $d);
	$table->data[] = array ('Получали ли стипендию в прошлом семестре', $iii);
	$table->data[] = array ('Средний балл', $grade);
	$table->data[] = array ('Статус', resolve_status($status));
	//$table->data[] = array (get_string('flag', block_anketka), $iii);
    return $table;    
}


function display_files(int $contextid,int $itemid){
    $out = array();
        
$fs = get_file_storage();
$files = $fs->get_area_files($contextid, 'block_application_request', 'attachment', $itemid);
            
foreach ($files as $file) {
    $filename = $file->get_filename();
    if ($filename!='.'){
        $url = moodle_url::make_pluginfile_url( $file->get_contextid(), 'block_application_request', 'attachment',
                $file->get_itemid(), $file->get_filepath(), $filename);
        $out[] = html_writer::link($url, $filename);
    }
}
$br = html_writer::empty_tag('br');
        
return implode($br, $out);
}

function display_file(int $contextid,int $itemid){
    $fs = get_file_storage();
    $files = $fs->get_area_files($contextid, 'block_application_request', 'attachment', $itemid);
    foreach ($files as $file) {
        $filename = $file->get_filename();
        if ($filename!='.'){
            $url = moodle_url::make_pluginfile_url( $file->get_contextid(), 'block_application_request', 'attachment',
                    $file->get_itemid(), $file->get_filepath(), $filename);
            return html_writer::link($url, $filename);
        }
    }
    return '';
}

function make_file_url(int $contextid,int $itemid){
    $fs = get_file_storage();
    $files = $fs->get_area_files($contextid, 'block_application_request', 'attachment', $itemid);
    foreach ($files as $file) {
        $filename = $file->get_filename();
        if ($filename!='.'){
            return moodle_url::make_pluginfile_url( $file->get_contextid(), 'block_application_request', 'attachment',
                    $file->get_itemid(), $file->get_filepath(), $filename);
            
        }
    }
    return '';
}

function render_application_document_page(html_table $table,int $applicationid){
    global $OUTPUT;
    //echo $OUTPUT->heading('Ваши достижения', 2);
	echo $OUTPUT->heading(get_string('yourachievements', 'block_application_request'), 2);
    echo html_writer::start_tag( 'a', array( 'href' => "./upload_documents.php?id={$applicationid}&action=ADD" ) )
    .html_writer::start_tag( 'button', array( 'type' => 'button', 'class' => 'btn btn-primary', 'style' =>'margin:3%; width:20%' ) )
    //.format_string( 'Добавить достижение' )
	.format_string( get_string('addachievement', 'block_application_request') )
    .html_writer::end_tag('button')
    .html_writer::end_tag( 'a' );

    echo html_writer::table($table);
    echo html_writer::start_tag( 'a', array( 'href' => "./add_application.php?id={$applicationid}" ) )
    .html_writer::start_tag( 'button', array( 'type' => 'button', 'class' => 'btn btn-primary', 'style' =>'margin:3%; width:20%' ) )
    //.format_string( 'Назад' )
	.format_string( get_string('toreturn', 'block_application_request') )
    .html_writer::end_tag('button')
    .html_writer::end_tag( 'a' );

    echo html_writer::start_tag( 'a', array( 'href' => "./checkandsend.php?id={$applicationid}" ) )
    .html_writer::start_tag( 'button', array( 'type' => 'button', 'class' => 'btn btn-primary', 'style' =>'margin:3%; width:20%' ) )
    //.format_string( 'Далее' )
	.format_string( get_string('buttoncontinued', 'block_application_request') )
    .html_writer::end_tag('button')
    .html_writer::end_tag( 'a' );

    echo html_writer::start_tag( 'a', array( 'href' => "./view_applications_list.php" ) )
    .html_writer::start_tag( 'button', array( 'type' => 'button', 'class' => 'btn btn-primary', 'style' =>'margin:3%; width:20%' ) )
    //.format_string( 'Отмена' )
	.format_string( get_string('cancel', 'block_application_request') )
    .html_writer::end_tag('button')
    .html_writer::end_tag( 'a' );

}

function render_checkandsend_page_bottom(int $applicationid){
    global $DB;
    echo html_writer::start_tag( 'a', array( 'href' => "./upload_documents.php?id={$applicationid}" ))
    .html_writer::start_tag( 'button', array( 'type' => 'button', 'class' => 'btn btn-primary', 'style' =>'margin:3%; width:20%' ))
	.format_string( get_string('toreturn', 'block_application_request') )
    .html_writer::end_tag('button')
    .html_writer::end_tag( 'a' );

	echo html_writer::start_tag( 'a', array( 'href' => "./checkandsendconfirmd.php?id={$applicationid}" ) )
	.html_writer::start_tag( 'button', array( 'type' => 'button', 'class' => 'btn btn-primary', 'style' =>'margin:3%; width:35%' ) )
	//.format_string( 'Отправить заявление в отборочную комиссию' )
	.format_string( get_string('sendapplication', 'block_application_request') )
	.html_writer::end_tag('button')
	.html_writer::end_tag( 'a' );

    echo html_writer::start_tag( 'a', array( 'href' => "./view_applications_list.php" ) )
    .html_writer::start_tag( 'button', array( 'type' => 'button', 'class' => 'btn btn-primary', 'style' =>'margin:3%; width:20%' ) )
    //.format_string( 'Отмена' )
	.format_string( get_string('cancel', 'block_application_request') )
    .html_writer::end_tag('button')
    .html_writer::end_tag( 'a' );

}

function resolve_status($status){
    switch($status){
        //case 1: return 'Формируется';
		case 1: return get_string('isbeingformed', 'block_application_request');
        //case 2: return 'Отправлено';
		case 2: return get_string('hasbeensent', 'block_application_request');
		case 3: return "Назначена";
		case 4: return "Отказано";
		case 5: return "На рассмотрении";
        default: return '';
    }
}

function render_docs_list(int $id,int $itemid=null,int $contextid=null){
    $out = array();
    global $DB;
    if(!empty($itemid)){
        $url = make_file_url($contextid,$itemid);
        //$out[] = html_writer::link($url, 'Заявление на стипенидию');
		$out[] = html_writer::link($url, get_string('scholarshipapplication', 'block_application_request'));

    }
    $data = $DB -> get_records_sql('SELECT * FROM {block_app_request_documents} where applicationid = ? order by supportingdocument',[$id]);
    foreach($data as $item){
        $url = make_file_url($item->contextid,$item->itemid);
        $out[] = html_writer::link($url, $item->supportingdocument);
    }
    $br = html_writer::empty_tag('br');
    return implode($br,$out);

}

function protection_unauthorized($data)
{
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}



//Получает название группы из файла csv
function group_name ($codegroup)
{
			$fh = fopen('groups.csv', 'r');
			fgetcsv($fh, 0, ';');
			$data_groups = [];
			$k = 0;
			while (($row = fgetcsv($fh, 0, ';')) !== false)
			{
				list ($code_group, $name_group) = $row;
				//$code_group = iconv ("UTF-8", "cp1251", $code_group1);
				$data_groups[] =
				[
					'codegroup' => $code_group,
					'namegroup' => $name_group
				];
			}
			foreach ($data_groups as $row)
			{
				if ( $row['codegroup'] == $codegroup)
				{
					$namegroup = $row['namegroup'];
					$k = 1;
				}
			}
	if ($k == 0) $namegroup = "*";
	return ($namegroup);
}

function application_count($userid){
	global $DB;
	$data = $DB -> get_records_sql ('SELECT count(*) as c FROM {block_app_request_applicants} where applicantid=? and applicationstatus<>1', [$userid]);
	foreach ($data as $item){
		return $item->c;
	}
	return null;
}

function get_study_card($applicationid){
	global $DB;
	try{
		$data = $DB->get_record('block_app_request_documents', array('applicationid' => $applicationid,'achievement'=>'Учебная карточка'), '*', MUST_EXIST);
	}catch(Exception $e){
		return -1;
	}
	
	if(!empty($data)){
		return $data->id;
	}
	return -1;
}

function display_study_card_bottom($applicationid){
	$study_card_id = get_study_card($applicationid);
	if($study_card_id==-1){
		echo html_writer::start_tag( 'a', array( 'href' => "./upload_study_card.php?id={$applicationid}&action=ADD" ) )
		.html_writer::start_tag( 'button', array( 'type' => 'button', 'class' => 'btn btn-primary', 'style' =>'margin:3%; width:20%' ) )
		.format_string( 'Добавить учебную карточку' )
		.html_writer::end_tag('button')
		.html_writer::end_tag( 'a' );
	}else{
		echo html_writer::start_tag( 'a', array( 'href' => "./upload_study_card_del.php?id={$applicationid}&docid={$study_card_id}" ) )
		.html_writer::start_tag( 'button', array( 'type' => 'button', 'class' => 'btn btn-primary', 'style' =>'margin:3%; width:20%' ) )
		.format_string( 'Удалить учебную карточку' )
		.html_writer::end_tag('button')
		.html_writer::end_tag( 'a' );
	}

}
function display_study_card_tables($applicationid){
	$table1 = create_table_applicant_date($applicationid);
	echo html_writer::table($table1);
	$table = create_table_doclist($applicationid,FALSE);	
	echo html_writer::table($table);
	echo html_writer::tag('a', 'скачать проект заявки для получения стипендии', array('href' => "./download_application_project.php?id={$applicationid}"));
}

function nsn001_check($userid){
	global $DB;
	try{
        $user_obj = $DB -> get_record('user', array('username' => "admin",'id'=>$userid), '*', MUST_EXIST);
    }catch(Exception $e){
        return FALSE;
    }
	return TRUE;
}

function require_table_download ($u)
{
	global $DB;
	global $USER;
	
	$k1 = verification_group_membership ($u);
	$data = $DB -> get_records_sql ('SELECT * FROM {block_app_request_applicants} where ((applicationstatus<>1)
									AND ((directionofactivity = ? OR directionofactivity = ? OR directionofactivity = ?
									OR directionofactivity = ? OR directionofactivity = ?) OR 
									(applicantinstitute = ? OR applicantinstitute = ? OR applicantinstitute = ?
									OR applicantinstitute = ? OR applicantinstitute = ?)))', $k1);

	$sv = array();
	if (!empty($data))
	{
		foreach ($data as $item)
		{
			$f = $item -> applicantlastname.' '.$item -> applicantname.' '.$item -> applicantmiddlename;
			$k = $item -> applicantinstitute;
			$y = $item -> applicantphone;
			$m = $item -> applicantemail;
			$grade = $item -> grade;
			$app_count = application_count($item->applicantid);
			$direct = $item -> directionofactivity;
			$d = date('d.m.y', $item->applicationsenddate);
			$docs = render_docs_list1($item->id,$item->itemid,$item->contextid);
			$status = resolve_status($item -> applicationstatus);
			$sv[] = array ($f, $k, $y, $m, $direct, $d, $docs, $grade, $app_count, $status);
		}
	}
	return $sv;
}

function render_docs_list1(int $id,int $itemid=null,int $contextid=null){
    $out = array();
    global $DB;
    /*if(!empty($itemid)){
        $url = make_file_url($contextid,$itemid);
        //$out[] = html_writer::link($url, 'Заявление на стипенидию');
		$out[] = html_writer::link($url, get_string('scholarshipapplication', 'block_application_request'));

    }*/
    $data = $DB -> get_records_sql('SELECT * FROM {block_app_request_documents} where applicationid = ? order by supportingdocument',[$id]);
    foreach($data as $item){
        $url = make_file_url($item->contextid,$item->itemid);
        //$out[] = html_writer::link($url, $item->supportingdocument);
		$out[] = $item->supportingdocument;
    }
    //$br = html_writer::empty_tag(';  ');
	$br = ';  ';
    return implode($br,$out);

}
/**
 * Функция определяет правило сортировки элементов массива.
 * Вспомогательна функция для стандартной usort.
 * 
 * @param элемент массива $a.
 * @param элемент массива $b.
 *
 * @return int 0, если элементы массива равны, -1, если элемент $a больше $b и 1, если элемент $a меньше элемента $b.
 */
function sorting_array_desc ($a, $b)
{
	if ($a[1] == $b[1]) return 0;
	if ($a[1] > $b[1]) return -1;
		else return 1;
}

/**
 * Функция скачивает таблицу в виде файла.
 *
 * @param int $u идентификационный номер члена комиссии в mdl_user.
 *
 * @return array ???.
 */
function require_table_download_grant ($u)
{
	global $DB;
	global $USER;
	
	$k1 = verification_group_membership_grant ($u);
	$data = $DB -> get_records_sql ('SELECT * FROM {block_grant_proposals_stud} where ((applicationstatus<>1)
									AND ((directionofactivity = ? OR directionofactivity = ? OR directionofactivity = ?
									OR directionofactivity = ? OR directionofactivity = ?) OR 
									(applicantinstitute = ? OR applicantinstitute = ? OR applicantinstitute = ?
									OR applicantinstitute = ? OR applicantinstitute = ?)))', $k1);

	$sv = array();
	if (!empty($data))
	{
		foreach ($data as $item)
		{
			$f = $item -> applicantlastname.' '.$item -> applicantname.' '.$item -> applicantmiddlename;
			$k = $item -> applicantinstitute;
			$y = $item -> applicantphone;
			$m = $item -> applicantemail;
			$grade = $item -> grade;
			$app_count = application_count_grant($item->applicantid);
			$direct = $item -> directionofactivity;
			$d = date('d.m.y', $item->applicationsenddate);
			$docs = render_docs_list1_grant($item->id,$item->itemid,$item->contextid);
			$status = resolve_status_grant($item -> applicationstatus);
			$sv[] = array ($f, $k, $y, $m, $direct, $d, $docs, $grade, $app_count, $status);
		}
	}
	return $sv;
}

function table_grant_rating_download ($u)
{
	global $DB;
	global $USER;
	$data = $DB -> get_records_sql ('SELECT * FROM {block_grant_proposals_stud}',[]);
if (!empty($data))
{
	
	foreach ($data as $item)
    {
		if (($item -> directionofactivity) == 'культурно-творческая деятельность')
		{
			$data1 = $DB -> get_record_sql('SELECT SUM(grade) from {block_grant_proposals_doc} where applicationid = ?',[$item -> id]);
			foreach ($data1 as $summa1)	$cult_creat[] = array ($item -> id, $summa1);
		}
			
		if (($item -> directionofactivity) == 'спортивная деятельность')
		{
			$data2 = $DB -> get_record_sql('SELECT SUM(grade) from {block_grant_proposals_doc} where applicationid = ?',[$item -> id]);
			foreach ($data2 as $summa2) $sport[] = array ($item -> id, $summa2);
		}
		if (($item -> directionofactivity) == 'общественная деятельность')
		{
			$data3 = $DB -> get_record_sql('SELECT SUM(grade) from {block_grant_proposals_doc} where applicationid = ?',[$item -> id]);
			foreach ($data3 as $summa3) $publ[] = array ($item -> id, $summa3);
		}
		if (($item -> directionofactivity) == 'учебная деятельность')
		{
			$data4 = $DB -> get_record_sql('SELECT SUM(grade) from {block_grant_proposals_doc} where applicationid = ?',[$item -> id]);
			foreach ($data4 as $summa4) $educ[] = array ($item -> id, $summa4);
		}
		if (($item -> directionofactivity) == 'научно-исследовательская деятельность')
		{
			$data5 = $DB -> get_record_sql('SELECT SUM(grade) from {block_grant_proposals_doc} where applicationid = ?',[$item -> id]);
			foreach ($data5 as $summa5) $scien_res[] = array ($item -> id, $summa5);
		}
	}
}
usort ($cult_creat, 'sorting_array_elements');
usort ($sport, 'sorting_array_elements');
usort ($publ, 'sorting_array_elements');
usort ($scien_res, 'sorting_array_elements');
usort ($educ, 'sorting_array_elements');

$quantity = max(count($cult_creat), count($sport), count($publ), count($scien_res), count($educ));
	$sv = array();
	$sv[] = array('Номер заявления', 'Рейтинг обучающегося', 'Номер заявления', 'Рейтинг обучающегося', 
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
			
			$sv[] = array ($en, $er,
									$srn, $srr,
									$pn, $pr,
									$ccn, $ccr,
									$sn, $sr);
	}
	//echo ('************************');
	//var_dump($sv);
	/*if (!empty($data))
	{
		foreach ($data as $item)
		{
			$f = $item -> applicantlastname.' '.$item -> applicantname.' '.$item -> applicantmiddlename;
			$k = $item -> applicantinstitute;
			$y = $item -> applicantphone;
			$m = $item -> applicantemail;
			$grade = $item -> grade;
			$app_count = application_count_grant($item->applicantid);
			$direct = $item -> directionofactivity;
			$d = date('d.m.y', $item->applicationsenddate);
			$docs = render_docs_list1_grant($item->id,$item->itemid,$item->contextid);
			$status = resolve_status_grant($item -> applicationstatus);
			$sv[] = array ($f, $k, $y, $m, $direct, $d, $docs, $grade, $app_count, $status);
		}
	}*/
	return $sv;
}
?>
