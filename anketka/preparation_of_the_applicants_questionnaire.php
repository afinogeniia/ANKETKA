<?php 
require_once (dirname(dirname(__DIR__)).'/config.php'); 
require_once ($CFG->dirroot . '/lib/formslib.php'); 
require_once($CFG->libdir.'/ddl/database_manager.php');
require_once ($CFG -> libdir.'/adminlib.php');
require_once($CFG->libdir . '/classes/filetypes.php');
require_once($CFG->dirroot . '/lib/classes/filetypes.php');
require_once($CFG->dirroot.'/repository/lib.php');
require_once ($CFG->dirroot . '/blocks/anketka/applicantslib.php');
require_once($CFG->dirroot.'/blocks/edit_form.php');
require_once($CFG->dirroot.'/blocks/anketka/applicants_application_form.php');
require_once($CFG->dirroot.'/user/profile/lib.php');
require_once($CFG->dirroot.'/user/lib.php');
require_once($CFG->libdir . '/filelib.php');
require_once($CFG->libdir . '/badgeslib.php');
require_once($CFG->libdir.'/gdlib.php');
require_once($CFG->dirroot.'/user/edit_form.php');
require_once($CFG->dirroot.'/user/editlib.php');
require_once($CFG->dirroot.'/user/profile/lib.php');
require_once($CFG->dirroot.'/user/lib.php');
require_once($CFG->dirroot . '/my/lib.php');
require_once($CFG->dirroot."/repository/lib.php");
global $CFG;
global $DB;
global $PAGE;
global $USER;
global $frm;	
global $_FILES;	
	
	require_login();

//$DB -> set_debug (true);
if (isguestuser()) {
    die();
}

$returnurl = optional_param('returnurl', '', PARAM_LOCALURL);

if (empty($returnurl)) {
    $returnurl = new moodle_url('/blocks/anketka/preparation_of_the_applicants_questionnaire.php');
}



$context = context_user::instance($USER->id);
//$context = context_user::instance ($pustbudet);



$struser = get_string('user');

$PAGE->set_url('/blocks/anketka/uploading_the_applicants_documents.php');
$PAGE->set_context($context);
//$PAGE->set_title($title);
$PAGE->set_heading(fullname($USER));
$PAGE->set_pagelayout('standard');


$PAGE->set_pagetype('my-index');

echo $OUTPUT->header();	

/*if (core_userfeedback::should_display_reminder()) {
    core_userfeedback::print_reminder_block();
}

echo $OUTPUT->custom_block_region('content');

echo $OUTPUT->footer();8/

// Trigger dashboard has been viewed event.
/*$eventparams = array('context' => $context);
$event = \core\event\dashboard_viewed::create($eventparams);
$event->trigger();

	
	//*********************
$userid = optional_param('id', $USER->id, PARAM_INT);    // User id.
$course = optional_param('course', SITEID, PARAM_INT);   // Course id (defaults to Site).
$returnto = optional_param('returnto', null, PARAM_ALPHA);  // Code determining where to return to after save.
$cancelemailchange = optional_param('cancelemailchange', 0, PARAM_INT);   // Course id (defaults to Site).

$PAGE->set_url('/user/edit.php', array('course' => $course, 'id' => $userid));
$context = context_user::instance($USER->id);
$PAGE->set_context($context);*/	
//$DB -> set_debug (true);
	
	$mform = new anketa_soiskatelya_form ();
	$mform->display(); 
	//$p = $_POST['poryadkovii'];
	$poryadkoviinomer = $USER -> id;
	$k = '<form action = "information_about_achievements.php" method = "POST">';
	$k .= '<input type = "submit" name ="'.$poryadkoviinomer.'" value ="заполнить ПРИЛОЖЕНИЕ к заявке"/input>';
	$k .= '<input type = "hidden" name = "poryadkovii" value = "'.$poryadkoviinomer.'"></form>';
	echo ($k);
	$danniye = $mform -> get_data ();	
	
	
	if ((isset($danniye -> imya)) & (isset($danniye -> otchestwo)) & (isset($danniye -> familija)) & (isset($danniye -> institut)) & (isset($danniye -> kurs)) & (isset($danniye -> gruppa)) & (isset($danniye -> telephon)) & (isset($danniye -> email)))
	{	
		if (($danniye -> imya !== "") & ($danniye -> otchestwo !== "") & ($danniye -> familija !== "") & ($danniye -> institut !== "") & ($danniye -> kurs !== "") & ($danniye -> gruppa !== "") & ($danniye -> telephon !== "") & ($danniye -> email !== ""))
		{
			if (($danniye -> imya !== NULL) & ($danniye -> otchestwo !== NULL) & ($danniye -> familija !== NULL) & ($danniye -> institut !== NULL) & ($danniye -> kurs !== NULL) & ($danniye -> gruppa !== NULL) & ($danniye -> telephon !== NULL) & ($danniye -> email !== NULL))
			{
				$poryadok = $DB -> get_records_sql ('SELECT * FROM {block_anketka_applicants} WHERE (applicantid = ?)', [$poryadkoviinomer]);
//Проверить, существует ли уже в таблице запись с таким id
				if ($poryadok == [])
				{
					$dannyesoiskatelya = new stdClass();
					$dannyesoiskatelya->applicantid = $poryadkoviinomer;
					$dannyesoiskatelya->applicantsname = $danniye -> imya;
					$dannyesoiskatelya->applicantspatronymic = $danniye -> otchestwo;
					$dannyesoiskatelya->applicantslastname = $danniye -> familija;
					$dannyesoiskatelya->applicantsinstitute = $danniye -> institut;
					$dannyesoiskatelya->applicantscourse = $danniye -> kurs;
					$dannyesoiskatelya->applicantsgroup = $danniye -> gruppa;
					$dannyesoiskatelya->applicantsphonenumber = $danniye -> telephon;
					$dannyesoiskatelya->applicantsmailingaddress = $danniye -> email;
					$deyat = $danniye -> dejatelnist;
					$deyat = preobrazovanie ($deyat);
					$dannyesoiskatelya->directionofactivity = $deyat;
					$danet = $danniye -> poluchalli;
					$danet = preobrdanet ($danet);
					$dannyesoiskatelya->scholarshipholder = $danet;
					echo ('___________DANNYE______________');
					var_dump ($dannyesoiskatelya);
					$DB->insert_record('block_anketka_applicants', $dannyesoiskatelya, $returnid = true, $bulk = false);
				}
					else
					{
						echo ('такая запись уже есть!!!!!!!!!!!!!!!!!!!!! будем обновлять');	
						$dannyesoiskatelya = new stdClass();
						foreach ($poryadok as $poryadochek)
						{
							$poryadokid = $poryadochek -> id;
						}
					$dannyesoiskatelya->id = $poryadokid;
					$dannyesoiskatelya->applicantid = $poryadkoviinomer;
					$dannyesoiskatelya->applicantsname = $danniye -> imya;
					$dannyesoiskatelya->applicantspatronymic = $danniye -> otchestwo;
					$dannyesoiskatelya->applicantslastname = $danniye -> familija;
					$dannyesoiskatelya->applicantsinstitute = $danniye -> institut;
					$dannyesoiskatelya->applicantscourse = $danniye -> kurs;
					$dannyesoiskatelya->applicantsgroup = $danniye -> gruppa;
					$dannyesoiskatelya->applicantsphonenumber = $danniye -> telephon;
					$dannyesoiskatelya->applicantsmailingaddress = $danniye -> email;
					$deyat = $danniye -> dejatelnist;
					$deyat = preobrazovanie ($deyat);
					$dannyesoiskatelya->directionofactivity = $deyat;
					$danet = $danniye -> poluchalli;
					$danet = preobrdanet ($danet);
					$dannyesoiskatelya->scholarshipholder = $danet;
					$DB->update_record('block_anketka_applicants', $dannyesoiskatelya);
					}
	
			}
		}
	}
		else ('Заполните все поля формы, пожалуйста!');
		
		$imyachkofailika = imyazajavki ($poryadkoviinomer);
		$poryadok1 = $DB -> get_records_sql ('SELECT * FROM {block_anketka_applicants} WHERE (applicantid = ?)', [$poryadkoviinomer]);
		$file = fopen ('anketka.rtf','r');
		$text = fread ($file, filesize('anketka.rtf'));
		fclose ($file);
		$text = str_replace ('</INVENTPRY>', '', $text);
		foreach ($poryadok1 as $poryadchek)
		{
			$text = str_replace ('Familia', iconv("UTF-8","cp1251",$poryadchek -> applicantslastname), $text);
			$text = str_replace ('imya', iconv ("UTF-8","cp1251",$poryadchek -> applicantsname), $text);
			$text = str_replace ('otchestvo', iconv ("UTF-8","cp1251",$poryadchek -> applicantspatronymic), $text);
			$text = str_replace ('Institut', iconv ("UTF-8","cp1251",$poryadchek -> applicantsinstitute), $text);
			$text = str_replace ('Kurs', iconv ("UTF-8","cp1251",$poryadchek -> applicantscourse), $text);
			$text = str_replace ('gruppa', iconv ("UTF-8","cp1251",$poryadchek -> applicantsgroup), $text);
			$text = str_replace ('phone', iconv ("UTF-8","cp1251",$poryadchek -> applicantsphonenumber), $text);
			$text = str_replace ('email', iconv ("UTF-8","cp1251",$poryadchek -> applicantsmailingaddress), $text);
			$text = str_replace ('deyatelnost', iconv ("UTF-8","cp1251",$poryadchek -> directionofactivity), $text);
			$text = str_replace ('poluchenie', iconv ("UTF-8","cp1251",$poryadchek -> scholarshipholder), $text);
		}
		$file2 = fopen ($imyachkofailika, 'w');
		fwrite ($file2, $text);
		fclose ($file2);
echo $OUTPUT->footer();
		//echo ($poryadok1 -> poryadkovii);
		//$k = '<form action = "information_about_achievements.php" method = "POST">';
		//$k .= '<input type = "submit" name ="'.$poryadkoviinomer.'" value ="заполнить ПРИЛОЖЕНИЕ к заявке"/input>';
		//$k .= '<input type = "hidden" name = "poryadkovii" value = "'.$poryadkoviinomer.'"></form>';
		//echo ($k);
		//unlink ($imyachkofailika);