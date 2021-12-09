<?php
require_once (dirname(dirname(__DIR__)).'/config.php'); 
require_once ($CFG->dirroot . '/lib/formslib.php');
require_once ($CFG->dirroot . '/cohort/lib.php');

function creating_cohorts_begin ()
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
	return ($scholarship_request_cohorts);
}

function verification_group_membership ($userid)
{
	global $DB;
	$scholarship_request_cohorts = creating_cohorts_begin ();
	$array_global_groups = array();
	for ($i = 0; $i <= 9; $i++)
	{
		$idcohort1 = $DB -> get_records_sql ('SELECT * FROM {cohort} WHERE (name = ?)', [$scholarship_request_cohorts[$i]]);
		foreach ($idcohort1 as $idcohort2) $idcohort = $idcohort2 -> id;
		$chekingthegroup = $DB -> get_records_sql ('SELECT * FROM {cohort_members} WHERE (cohortid = ? AND userid = ?)', [$idcohort, $userid]);
		if ($chekingthegroup !== []) $array_global_groups[$scholarship_request_cohorts[$i]] = 1;
			else $array_global_groups[$scholarship_request_cohorts[$i]] = 0;
	}
	if ($array_global_groups['scholarship_request_educational_activities'] == 1) $array_global_groups['scholarship_request_educational_activities'] = 'учебная деятельность';
	if ($array_global_groups['scholarship_request_research_activities'] == 1) $array_global_groups['scholarship_request_research_activities'] = 'научно-исследовательская деятельность';
	if ($array_global_groups['scholarship_request_public_activities'] == 1) $array_global_groups['scholarship_request_public_activities'] = 'общественная деятельность';
	if ($array_global_groups['scholarship_request_culturalcreative_activities'] == 1) $array_global_groups['scholarship_request_culturalcreative_activities'] = 'культурно-творческая деятельность';
	if ($array_global_groups['scholarship_request_sports_activities'] == 1) $array_global_groups['scholarship_request_sports_activities'] = 'спортивная деятельность';
	if ($array_global_groups['scholarship_request_isop'] == 1) $array_global_groups['scholarship_request_isop'] = 'ИСОП';
	if ($array_global_groups['scholarship_request_ip'] == 1) $array_global_groups['scholarship_request_ip'] = 'ИП';
	if ($array_global_groups['scholarship_request_iu'] == 1) $array_global_groups['scholarship_request_iu'] = 'ИЮ';
	if ($array_global_groups['scholarship_request_ipip'] == 1) $array_global_groups['scholarship_request_ipip'] = 'ИПИП';
	if ($array_global_groups['scholarship_request_igimp'] == 1) $array_global_groups['scholarship_request_igimp'] = 'ИГИМП';
	return ($array_global_groups);
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

function conversion_parametr_k ($kurs)
{
	switch($kurs)
	{
		case 0: $kurs = 1; break;
		case 1: $kurs = 2; break;
		case 2: $kurs = 3; break;
		case 3: $kurs = 4; break;
		case 4: $kurs = 5; break;
		case 5: $kurs = 6; break;
	}
	return ($kurs);
}


function conversion_parametr_i ($institut)
{
	switch($institut)
	{
		case 0: $institut = "Институт государственного и международного права"; break;
		case 1: $institut = "Институт дополнительного образования"; break;
		case 2: $institut = "Институт права и предпринимательства"; break;
		case 3: $institut = "Институт прокуратуры"; break;
		case 4: $institut = "Институт специальных образовательных программ"; break;
		case 5: $institut = "Институт юстиции"; break;
		case 6: $institut = "Институт довузовской подготовки"; break;
	}
	return ($institut);
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
    $data = $DB -> get_records_sql ('SELECT * FROM {block_anketka_applicants} where applicantid = ? order by id',[$USER->id]);
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
/*не заполняет приложение к заявке информацией о документах*/
function create_application_print(int $id){
    global $DB;
    $data = $DB -> get_records_sql ('SELECT * FROM {block_anketka_applicants} WHERE (id = ?)', [$id]);
	foreach ($data as $oops)
	{
		$applicationid = $oops -> id;
	}
	$data1 = $DB -> get_records_sql ('SELECT * FROM {block_anketka_documents} WHERE (applicationid = ?)', [$applicationid]);
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
    return $text;
}

function checking_validity_phone ($phone)
{
	if (preg_match ('/^[0-9]$/', $phone))
	{
		$mess = '';
	}
		else $mess = '<div>неверно указан номер</div>';
	return $mess;
}

function create_table_doclist(int $id){
    global $DB;
    $data = $DB -> get_records_sql('SELECT * FROM {block_anketka_documents} where applicationid = ? order by supportingdocument',[$id]);
    if(empty($data)){
        return NULL;
    }

    $table = new html_table();
    //$table->head = array('Достижение', 'Подтвержающий документ', 'Дата документа','Скачать', '');
	$table->head = array(get_string('achievement', 'block_anketka'), get_string('confirmation', 'block_anketka'),
						 get_string('documentdate', 'block_anketka'), get_string('download', 'block_anketka'), '');
    
    foreach ($data as $item)
    {
        $f = $item -> achievement;
        $k = $item -> supportingdocument;
        $y = $item -> documentdate;
        $itemid = $item->itemid;
        $contextid = $item->contextid;
        $link = display_files($contextid,$itemid);
        $del = html_writer::start_tag( 'a', array( 'href' => "./upload_documents_del.php?id={$id}&docid={$item->id}" ) )
            .format_string( get_string('delete', 'block_anketka') )
            .html_writer::end_tag( 'a' );
        $table->data[] = array ($f, $k, $y, $link,$del);
    }
    return $table;    
}

function create_table_applicant_date(int $id){
    global $DB;
	global $USER;
	$data = $DB -> get_records_sql('SELECT * FROM {block_anketka_applicants} where applicantid = ?',[$USER -> id]);
    if(empty($data)){
        return NULL;
    }

    $table = new html_table();
    $table->head = array('', '');
    
    foreach ($data as $item)
    {
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
    }
	$table->data[] = array ('Фамилия', $i);
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
	//$table->data[] = array (get_string('flag', block_anketka), $iii);
    return $table;    
}


function display_files(int $contextid,int $itemid){
    $out = array();
        
$fs = get_file_storage();
$files = $fs->get_area_files($contextid, 'block_anketka', 'attachment', $itemid);
            
foreach ($files as $file) {
    #var_dump($file);
    $filename = $file->get_filename();
    if ($filename!='.'){
        $url = moodle_url::make_pluginfile_url( $file->get_contextid(), 'block_anketka', 'attachment',
                $file->get_itemid(), $file->get_filepath(), $filename);
        $out[] = html_writer::link($url, $filename);
    }
}
$br = html_writer::empty_tag('br');
        
return implode($br, $out);
}

function display_file(int $contextid,int $itemid){
    $fs = get_file_storage();
    $files = $fs->get_area_files($contextid, 'block_anketka', 'attachment', $itemid);
    foreach ($files as $file) {
        #var_dump($file);
        $filename = $file->get_filename();
        if ($filename!='.'){
            $url = moodle_url::make_pluginfile_url( $file->get_contextid(), 'block_anketka', 'attachment',
                    $file->get_itemid(), $file->get_filepath(), $filename);
            return html_writer::link($url, $filename);
        }
    }
    return '';
}

function make_file_url(int $contextid,int $itemid){
    $fs = get_file_storage();
    $files = $fs->get_area_files($contextid, 'block_anketka', 'attachment', $itemid);
    foreach ($files as $file) {
        #var_dump($file);
        $filename = $file->get_filename();
        if ($filename!='.'){
            return moodle_url::make_pluginfile_url( $file->get_contextid(), 'block_anketka', 'attachment',
                    $file->get_itemid(), $file->get_filepath(), $filename);
            
        }
    }
    return '';
}

function render_application_document_page(html_table $table,int $applicationid){
    global $OUTPUT;
    //echo $OUTPUT->heading('Ваши достижения', 2);
	echo $OUTPUT->heading(get_string('yourachievements', 'block_anketka'), 2);
    echo html_writer::start_tag( 'a', array( 'href' => "./upload_documents.php?id={$applicationid}&action=ADD" ) )
    .html_writer::start_tag( 'button', array( 'type' => 'button', 'class' => 'btn btn-primary', 'style' =>'margin:3%; width:20%' ) )
    //.format_string( 'Добавить достижение' )
	.format_string( get_string('addachievement', 'block_anketka') )
    .html_writer::end_tag('button')
    .html_writer::end_tag( 'a' );

    echo html_writer::table($table);
    echo html_writer::start_tag( 'a', array( 'href' => "./add_application.php?id={$applicationid}" ) )
    .html_writer::start_tag( 'button', array( 'type' => 'button', 'class' => 'btn btn-primary', 'style' =>'margin:3%; width:20%' ) )
    //.format_string( 'Назад' )
	.format_string( get_string('toreturn', 'block_anketka') )
    .html_writer::end_tag('button')
    .html_writer::end_tag( 'a' );

    echo html_writer::start_tag( 'a', array( 'href' => "./checkandsend.php?id={$applicationid}" ) )
    .html_writer::start_tag( 'button', array( 'type' => 'button', 'class' => 'btn btn-primary', 'style' =>'margin:3%; width:20%' ) )
    //.format_string( 'Далее' )
	.format_string( get_string('buttoncontinued', 'block_anketka') )
    .html_writer::end_tag('button')
    .html_writer::end_tag( 'a' );

    echo html_writer::start_tag( 'a', array( 'href' => "./view_applications_list.php" ) )
    .html_writer::start_tag( 'button', array( 'type' => 'button', 'class' => 'btn btn-primary', 'style' =>'margin:3%; width:20%' ) )
    //.format_string( 'Отмена' )
	.format_string( get_string('cancel', 'block_anketka') )
    .html_writer::end_tag('button')
    .html_writer::end_tag( 'a' );

}

function render_checkandsend_page_bottom(int $applicationid){
    global $DB;
    echo html_writer::start_tag( 'a', array( 'href' => "./upload_documents.php?id={$applicationid}" ) )
    .html_writer::start_tag( 'button', array( 'type' => 'button', 'class' => 'btn btn-primary', 'style' =>'margin:3%; width:20%' ) )
    //.format_string( 'Назад' )
	.format_string( get_string('toreturn', 'block_anketka') )
    .html_writer::end_tag('button')
    .html_writer::end_tag( 'a' );
    $data = $DB->get_record('block_anketka_applicants', array('id' => $applicationid), '*', MUST_EXIST);
	//$data = $DB->get_record('block_anketka_applicants', array('applicantid' => $applicationid), '*', MUST_EXIST);
#    $data = $DB -> get_records_sql ('SELECT itemid FROM {block_anketka_applicants} where id = ?',[$applicationid]);

    if(!is_null($data->itemid)){
        echo html_writer::start_tag( 'a', array( 'href' => "./checkandsendconfirmd.php?id={$applicationid}" ) )
        .html_writer::start_tag( 'button', array( 'type' => 'button', 'class' => 'btn btn-primary', 'style' =>'margin:3%; width:35%' ) )
        //.format_string( 'Отправить заявление в отборочную комиссию' )
		.format_string( get_string('sendapplication', 'block_anketka') )
        .html_writer::end_tag('button')
        .html_writer::end_tag( 'a' );
    }
    echo html_writer::start_tag( 'a', array( 'href' => "./view_applications_list.php" ) )
    .html_writer::start_tag( 'button', array( 'type' => 'button', 'class' => 'btn btn-primary', 'style' =>'margin:3%; width:20%' ) )
    //.format_string( 'Отмена' )
	.format_string( get_string('cancel', 'block_anketka') )
    .html_writer::end_tag('button')
    .html_writer::end_tag( 'a' );

}

function resolve_status($status){
    switch($status){
        //case 1: return 'Формируется';
		case 1: return get_string('isbeingformed', 'block_anketka');
        //case 2: return 'Отправлено';
		case 2: return get_string('hasbeensent', 'block_anketka');
        default: return '';
    }
}

function render_docs_list(int $id,int $itemid=null,int $contextid=null){
    $out = array();
    global $DB;
    if(!empty($itemid)){
        $url = make_file_url($contextid,$itemid);
        //$out[] = html_writer::link($url, 'Заявление на стипенидию');
		$out[] = html_writer::link($url, get_string('scholarshipapplication', 'block_anketka'));

    }
    $data = $DB -> get_records_sql('SELECT * FROM {block_anketka_documents} where applicationid = ? order by supportingdocument',[$id]);
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
?>