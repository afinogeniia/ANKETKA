<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Settings for the HTML block
 *
 * @copyright 2012 Aaron Barnes
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @package   block_html
 */

defined('MOODLE_INTERNAL') || die;

if ($ADMIN->fulltree) {
	/*$items = array();
	$items[] = new admin_setting_configtext('block_application_request_1', 'Вопрос', 'Ответ', 'language', PARAM_TEXT, 50);
	$items[] = new admin_setting_configtext('block_application_request_2', 'Вопрос', 'Ответ', 'language', PARAM_TEXT, 50);
	$items[] = new admin_setting_configtext('block_application_request_3', 'Вопрос', 'Ответ', 'language', PARAM_TEXT, 50);
	echo ('___________________ITEMS________________');
	var_dump ($items);*/
	//$settings -> add(new admin_setting_configtext('block_application_request/kafedra1', get_string('lastname', 'block_application_request'), 'Ответ', 'language', PARAM_TEXT, 50));
	//$settings -> add(new admin_setting_configtext('block_application_request/kafedra2', 'Вопрос543', 'Ответ1', 'simple', PARAM_TEXT, 33));
	//$settings -> add(new admin_setting_configtext('block_application_request/kafedra3', 'Вопрос3', 'Ответ3', 'simple', PARAM_TEXT, 33));
	//$settings->add(new admin_setting_configcheckbox('block_application_request/enrollment', get_string('allowadditionalcssclasses', 'block_html'),
                       //get_string('configallowadditionalcssclasses', 'block_application_request'), 0));
	$settings->add(new admin_setting_configcheckbox('block_application_request/enrollment', 'Зачислить ли студентов в группу?',
                       '', 0));
}
global $DB;
// файл enrollmetn.csv временно определила сюда - D:\server\moodle\admin
$fh = fopen('enrollment.csv', 'r');
$pluginconfigs = get_config('block_application_request');		
$n = $pluginconfigs -> enrollment;
var_dump ($n);
$data = $DB -> get_records_sql ('SELECT * FROM {user} where id = ?', [723]);
$data1 = $DB -> get_records_sql ('SELECT id FROM {cohort} where name = ?', ['scholarship_request_students']);
var_dump ($data);
echo ('__________________');
var_dump ($data1);
echo getcwd()."\n";
			fgetcsv($fh, 0);
			$data_groups = [];
			$k = 0;
			while (($row = fgetcsv($fh, 0)) !== false)
			{
				list ($enrollment_login) = $row;
				//$code_group = iconv ("UTF-8", "cp1251", $code_group1);
				$data_groups[] =
				[
					'enrollmentlogin' => $enrollment_login
				];
			}
			echo ('***************************************');
			var_dump ($data_groups);
			foreach ($data_groups as $row)
			{
				$data3 = $DB -> get_records_sql ('SELECT id FROM {user} WHERE username = ?', [$row['enrollmentlogin']]);
				//if empty($data3);
					//else $DB -> get_records_sql ('INSERT cohortid, userid FROM {cohort_members} VALUES ($data1, $data3);')
			/*$papka_dlya_documentov = new stdClass();
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
			$DB->insert_record('files', $papka_dlya_documentov, $returnid = true, $bulk = false);*/
			}
	
/*if ($ADMIN->fulltree) {
    $settings->add(new admin_setting_configtext('block_application_request', 'save',
                       //get_string('apikeyinfo', 'block_tag_youtube'), '', PARAM_RAW_TRIMMED, 40));
					   'write', '', PARAM_RAW_TRIMMED, 40));
}*/

//defined('MOODLE_INTERNAL') || die;

/*if ($ADMIN->fulltree) {
    $settings->add(new admin_setting_configcheckbox('block_application_request', get_string('allowadditionalcssclasses', 'block_html'),
                       get_string('configallowadditionalcssclasses', 'block_application_request'), 0));
}*/
/*if ($ADMIN->fulltree) {
    $settings->add(new admin_setting_configcheckbox('block_application_request', 'нужно ли создать глобальную группу',
                       'нужно ли создать Глобальную ГрУппУ', 0));
}*/
/*if ($ADMIN->fulltree) {
	$settings->add(new admin_setting_configtext('block_application_request', 'вопрос', 'ОТВЕТ', 640, PARAM_INT));
	//$p = $settings->add(new admin_setting_configtext('block_application_request', 'вопрос', 'ОТВЕТ', 640, PARAM_INT));
	/*$settings -> add(new admin_setting_configtext('block_application_request', new lang_string('fullnamedisplay', 'admin'),
            new lang_string('configfullnamedisplay', 'admin'), 'language', PARAM_TEXT, 50));*/
	/*$settings -> add(new admin_setting_configtext('block_application_request', 'Вопрос', 'Ответ', 'language', PARAM_TEXT, 50));
	$settings -> add(new admin_setting_configtext('block_application_request', 'Вопрос', 'Ответ', 750, PARAM_INT));*/
    //$setting->set_force_ltr(true);
	//$temp -> add($setting);
	//$settings->add(new admin_setting_configtext('block_application_request', 'вопрос', 'ОТВЕТ', 'институт', PARAM_TEXT, 33));
	//$settings->add(new admin_setting_configtext('block_application_request', 'вопрос', 'ОТВЕТ', 'деятельность', PARAM_TEXT, 57));
	/*$settings->add(new admin_setting_configselect('block_application_request',
            get_string('decimalplacesingrades', 'question'), '', 2, array(0, 1, 2, 3, 4, 5, 6, 7)));*/
	/*$setting = new admin_setting_configtext('fullnamedisplay', new lang_string('fullnamedisplay', 'admin'),
            new lang_string('configfullnamedisplay', 'admin'), 'language', PARAM_TEXT, 50);*/
//$temp = new admin_settingpage('commonfiltersettings', new lang_string('commonfiltersettings', 'admin'));
	/*if ($ADMIN->fulltree) 
	{
        $items = array();
        $items[] = new admin_setting_configselect('filteruploadedfiles', new lang_string('filteruploadedfiles', 'admin'), new lang_string('configfilteruploadedfiles', 'admin'), 0,
                array('0' => new lang_string('none'), '1' => new lang_string('allfiles'), '2' => new lang_string('htmlfilesonly')));
        $items[] = new admin_setting_configcheckbox('filtermatchoneperpage', new lang_string('filtermatchoneperpage', 'admin'), new lang_string('configfiltermatchoneperpage', 'admin'), 0);
        $items[] = new admin_setting_configcheckbox('filtermatchonepertext', new lang_string('filtermatchonepertext', 'admin'), new lang_string('configfiltermatchonepertext', 'admin'), 0);
        //foreach ($items as $item) {
            //$item->set_updatedcallback('reset_text_filters_cache');
            //$temp->add($item);
        //}
	}*/



