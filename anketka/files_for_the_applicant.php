<?php
//require('../config.php');
require_once (dirname(dirname(__DIR__)).'/config.php');
require_once("$CFG->dirroot/user/files_form.php");
require_once("$CFG->dirroot/repository/lib.php");

require_login();
if (isguestuser()) {
    die();
}

$returnurl = optional_param('returnurl', '', PARAM_LOCALURL);

if (empty($returnurl)) {
    $returnurl = new moodle_url('/user/files.php');
}

$context = context_user::instance($USER->id);
require_capability('moodle/user:manageownfiles', $context);

$title = get_string('privatefiles');
$struser = get_string('user');

$PAGE->set_url('/user/files.php');
$PAGE->set_context($context);
$PAGE->set_title($title);
$PAGE->set_heading(fullname($USER));
$PAGE->set_pagelayout('standard');
$PAGE->set_pagetype('my-index');
//$PAGE->set_pagetype('user-files');
           $conkat = $DB -> get_records_sql ('SELECT * FROM {context} WHERE instanceid = ?',[$USER->id]);
			echo ('________________CONTEXTID_____________');
			var_dump ($conkat);
			foreach ($conkat as $ccc)
			{
				$contekst = $ccc -> id;
			}
			$proverka = $DB -> get_records_sql ('SELECT * FROM {files} WHERE contextid = ? and filepath = ? and filearea = ?', [$contekst, '/динозаврики/', 'private']);
			echo ('_________PROVERKA__________');
			var_dump ($proverka);
			$treska = array ();
			$treska = $proverka;
			echo ('___________TRESKA_______');
			var_dump ($treska);
			if ($proverka == [])
			{
			$papka_dlya_documentov = new stdClass();
			$papka_dlya_documentov->contenthash = 'da39a3ee5e6b4b0d3255bfef95601890afd80709';
			$stroka_dlya_patha = $contekst.'+private+0+/СТИПЕНДИЯ/+.';
			$papka_dlya_documentov->pathnamehash = sha1($stroka_dlya_patha);
			$papka_dlya_documentov->contextid = $contekst;
			$papka_dlya_documentov->component = 'user';
			$papka_dlya_documentov->filearea = 'private';
			$papka_dlya_documentov->itemid = 0;
			$papka_dlya_documentov->filepath = '/СТИПЕНДИЯ/';
			$papka_dlya_documentov->filename = '.';
			$papka_dlya_documentov->filesize = 0;
			$papka_dlya_documentov->timecreated = time();
			$papka_dlya_documentov->timemodified = time() + 5;
			$DB->insert_record('files', $papka_dlya_documentov, $returnid = true, $bulk = false);
			}
$maxbytes = $CFG->userquota;
$maxareabytes = $CFG->userquota;
if (has_capability('moodle/user:ignoreuserquota', $context)) {
    $maxbytes = USER_CAN_IGNORE_FILE_SIZE_LIMITS;
    $maxareabytes = FILE_AREA_MAX_BYTES_UNLIMITED;
}

$data = new stdClass();
$data->returnurl = $returnurl;
$options = array('subdirs' => 1, 'maxbytes' => $maxbytes, 'maxfiles' => -1, 'accepted_types' => '*',
        'areamaxbytes' => $maxareabytes);
file_prepare_standard_filemanager($data, 'files', $options, $context, 'user', 'private', 0);

// Attempt to generate an inbound message address to support e-mail to private files.
$generator = new \core\message\inbound\address_manager();
$generator->set_handler('\core\message\inbound\private_files_handler');
$generator->set_data(-1);
$data->emaillink = $generator->generate($USER->id);

$mform = new user_files_form(null, array('data' => $data, 'options' => $options));

if ($mform->is_cancelled()) {
    redirect($returnurl);
} else if ($formdata = $mform->get_data()) {
    $formdata = file_postupdate_standard_filemanager($formdata, 'files', $options, $context, 'user', 'private', 0);
    redirect($returnurl);
}

echo $OUTPUT->header();
echo $OUTPUT->box_start('generalbox');

// Show file area space usage.
if ($maxareabytes != FILE_AREA_MAX_BYTES_UNLIMITED) {
    $fileareainfo = file_get_file_area_info($context->id, 'user', 'private');
    // Display message only if we have files.
    if ($fileareainfo['filecount']) {
        $a = (object) [
            'used' => display_size($fileareainfo['filesize_without_references']),
            'total' => display_size($maxareabytes)
        ];
        $quotamsg = get_string('quotausage', 'moodle', $a);
        $notification = new \core\output\notification($quotamsg, \core\output\notification::NOTIFY_INFO);
        echo $OUTPUT->render($notification);
    }
}
			
			
echo ('Уважаемый соискатель, '.$USER -> alternatename.'! ');
echo ('<br>');
echo ('Загрузите сканы документов о достижениях в папку СТИПЕНДИЯ');
$mform->display();
echo $OUTPUT->box_end();
echo $OUTPUT->footer();
