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
	$items[] = new admin_setting_configtext('block_anketka_1', 'Вопрос', 'Ответ', 'language', PARAM_TEXT, 50);
	$items[] = new admin_setting_configtext('block_anketka_2', 'Вопрос', 'Ответ', 'language', PARAM_TEXT, 50);
	$items[] = new admin_setting_configtext('block_anketka_3', 'Вопрос', 'Ответ', 'language', PARAM_TEXT, 50);
	echo ('___________________ITEMS________________');
	var_dump ($items);*/
	$settings -> add(new admin_setting_configtext('block_anketka/1', 'Вопрос', 'Ответ', 'language', PARAM_TEXT, 50));
	$settings -> add(new admin_setting_configtext('block_anketka/2', 'Вопрос1', 'Ответ1', 'simple', PARAM_TEXT, 33));
	$settings -> add(new admin_setting_configtext('block_anketka/3', 'Вопрос3', 'Ответ3', 'simple', PARAM_TEXT, 33));
}
/*if ($ADMIN->fulltree) {
    $settings->add(new admin_setting_configtext('block_anketka', 'save',
                       //get_string('apikeyinfo', 'block_tag_youtube'), '', PARAM_RAW_TRIMMED, 40));
					   'write', '', PARAM_RAW_TRIMMED, 40));
}*/

//defined('MOODLE_INTERNAL') || die;

/*if ($ADMIN->fulltree) {
    $settings->add(new admin_setting_configcheckbox('block_anketka', get_string('allowadditionalcssclasses', 'block_html'),
                       get_string('configallowadditionalcssclasses', 'block_anketka'), 0));
}*/
/*if ($ADMIN->fulltree) {
    $settings->add(new admin_setting_configcheckbox('block_anketka', 'нужно ли создать глобальную группу',
                       'нужно ли создать Глобальную ГрУппУ', 0));
}*/
/*if ($ADMIN->fulltree) {
	$settings->add(new admin_setting_configtext('block_anketka', 'вопрос', 'ОТВЕТ', 640, PARAM_INT));
	//$p = $settings->add(new admin_setting_configtext('block_anketka', 'вопрос', 'ОТВЕТ', 640, PARAM_INT));
	/*$settings -> add(new admin_setting_configtext('block_anketka', new lang_string('fullnamedisplay', 'admin'),
            new lang_string('configfullnamedisplay', 'admin'), 'language', PARAM_TEXT, 50));*/
	/*$settings -> add(new admin_setting_configtext('block_anketka', 'Вопрос', 'Ответ', 'language', PARAM_TEXT, 50));
	$settings -> add(new admin_setting_configtext('block_anketka', 'Вопрос', 'Ответ', 750, PARAM_INT));*/
    //$setting->set_force_ltr(true);
	//$temp -> add($setting);
	//$settings->add(new admin_setting_configtext('block_anketka', 'вопрос', 'ОТВЕТ', 'институт', PARAM_TEXT, 33));
	//$settings->add(new admin_setting_configtext('block_anketka', 'вопрос', 'ОТВЕТ', 'деятельность', PARAM_TEXT, 57));
	/*$settings->add(new admin_setting_configselect('block_anketka',
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



