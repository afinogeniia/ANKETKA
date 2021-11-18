<?php
	require_once (dirname(dirname(__DIR__)).'/config.php');
	require_once ($CFG->dirroot . '/blocks/anketka/applicantslib.php');
require_once($CFG->libdir.'/gdlib.php');
require_once($CFG->dirroot.'/user/edit_form.php');
require_once($CFG->dirroot.'/user/editlib.php');
require_once($CFG->dirroot.'/user/profile/lib.php');
require_once($CFG->dirroot.'/user/lib.php');
require_once($CFG->dirroot . '/my/lib.php');
$userid = optional_param('id', $USER->id, PARAM_INT);    // User id.
$course = optional_param('course', SITEID, PARAM_INT);   // Course id (defaults to Site).
$returnto = optional_param('returnto', null, PARAM_ALPHA);  // Code determining where to return to after save.
$cancelemailchange = optional_param('cancelemailchange', 0, PARAM_INT);   // Course id (defaults to Site).

$PAGE->set_url('/blocks/anketka/skachivanie.php', array('course' => $course, 'id' => $userid));
	
	global $DB;
	global $CFG;
	global $PAGE;
	global $USER;
	global $frm;	
	global $_FILES;
//$DB -> set_debug (true);

redirect_if_major_upgrade_required();

// TODO Add sesskey check to edit
$edit   = optional_param('edit', null, PARAM_BOOL);    // Turn editing on and off
$reset  = optional_param('reset', null, PARAM_BOOL);

require_login();

$hassiteconfig = has_capability('moodle/site:config', context_system::instance());
if ($hassiteconfig && moodle_needs_upgrading()) {
    redirect(new moodle_url('/admin/index.php'));
}

$strmymoodle = get_string('myhome');

if (isguestuser()) {  // Force them to see system default, no editing allowed
    // If guests are not allowed my moodle, send them to front page.
    if (empty($CFG->allowguestmymoodle)) {
        redirect(new moodle_url('/', array('redirect' => 0)));
    }

    $userid = null;
    $USER->editing = $edit = 0;  // Just in case
    $context = context_system::instance();
    $PAGE->set_blocks_editing_capability('moodle/my:configsyspages');  // unlikely :)
    $strguest = get_string('guest');
    $header = "$SITE->shortname: $strmymoodle ($strguest)";
    $pagetitle = $header;

} else {        // We are trying to view or edit our own My Moodle page
    $userid = $USER->id;  // Owner of the page
    $context = context_user::instance($USER->id);
    $PAGE->set_blocks_editing_capability('moodle/my:manageblocks');
    $header = "$SITE->shortname: $strmymoodle";
    $pagetitle = $strmymoodle;
}

// Get the My Moodle page info.  Should always return something unless the database is broken.
if (!$currentpage = my_get_page($userid, MY_PAGE_PRIVATE)) {
    print_error('mymoodlesetup');
}

// Start setting up the page
$params = array();
$PAGE->set_context($context);
//$PAGE->set_url('/my/index.php', $params);
//$PAGE->set_pagelayout('mydashboard');
$PAGE->set_pagetype('my-index');
//$PAGE->blocks->add_region('content');
$PAGE->set_subpage($currentpage->id);
$PAGE->set_title($pagetitle);
$PAGE->set_heading($header);

echo $OUTPUT->header();	



//**************************************
	$poryadkoviinomer = $USER -> id;
	//echo '<div>'.$poryadkoviinomer.'</div>';
	$anketa = $DB -> get_records_sql ('SELECT * FROM {block_anketka_applicants} WHERE (applicantid = ?)', [$poryadkoviinomer]);
	//echo ('**********************');
	//var_dump ($anketa);
	$prilojenia = $DB -> get_records_sql ('SELECT * FROM {block_anketka_documents} WHERE (applicantid = ?)', [$poryadkoviinomer]);
	//echo ('=====================');
	//var_dump ($prilojenia);
	
	$imyachkofailika = imyazajavki ($poryadkoviinomer);
	$file = fopen ('anketka.rtf','r');
		//echo ('??????????????????');
		$text = fread ($file, filesize('anketka.rtf'));
		fclose ($file);
		$text = str_replace ('</INVENTPRY>', '', $text);
		$schetchik = 1;
		foreach ($prilojenia as $doci)
		{
			foreach ($anketa as $poryadchek)
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
				$jk = dechex($schetchik);			
				$text = str_replace ('N'."$jk", iconv("UTF-8","cp1251",$schetchik), $text);
				$text = str_replace ('Dost'."$jk", iconv ("UTF-8","cp1251",$doci -> achievementoftheapplicant), $text);
				$text = str_replace ('Data'."$jk", iconv ("UTF-8","cp1251",$doci -> dateofachievement), $text);
				$text = str_replace ('Doc'."$jk", iconv ("UTF-8","cp1251",$doci -> supportingdocument), $text);
				$text = str_replace ('Prim'."$jk", iconv ("UTF-8","cp1251",$doci -> notetoachievement), $text);
				$schetchik++;
				//echo ('::::::::::::::::::::::::::');
				//echo ($schetchik);
				//break;
			}
		}
		$file2 = fopen ($imyachkofailika, 'w');
		fwrite ($file2, $text);
		fclose ($file2);
		//echo ('SCHET');
		//echo ($schetchik);
		echo '<p><a href = "'.$imyachkofailika.'"> скачать проект заявки для просмотра </a></p>';
		//echo '<div><a href = "'.$imyachkofailika.'" download> скачать проект заявки </a></div>';
echo $OUTPUT->footer();
		?>