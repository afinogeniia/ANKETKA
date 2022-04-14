<?php
//This file is part of Moodle - http://moodle.org/
//
//Moodle is free software: you can redistrivute it and/or modify
//it under the terms of the GNU General Public License as published by
//the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
//Moodle is distributed in the hope that it will be useful,
//but WITHOUT ANY WAARANTY; without evey the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
// GNY General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle. If not, see <http://www.gnu.org/licenses/>.

/**
* Block for ИНФОРМАЦИИ О СОДЕРЖАЩИХСЯ в данной папке из FILEDIR - подкаталогах и файлах.
*
*@package bolck_user_groups
*@copyright 2017 USPTU
*@license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later*/
//require_once ($CFG->dirroot . '/lib/formslib.php');
require_once ($CFG->dirroot . '/config.php');
require_once ($CFG->dirroot . '/blocks/application_request/applicantslib.php');

class block_application_request extends block_list
{
	public function init()
	{
		$this -> title = 'Соискание стипендии';
	}
	
	function has_config() 
	{
        return true;
    }
	
	public function get_content()
	{	
		global $DB;
		global $USER;
		//$idcohort1 = $DB -> get_records_sql ('SELECT * FROM {cohort} WHERE (name = ?)', ['Заявление']);
		//foreach ($idcohort1 as $idcohort2) $idcohort = $idcohort2 -> id;
		//$chekingthegroup = $DB -> get_records_sql ('SELECT * FROM {cohort_members} WHERE (cohortid = ? AND userid = ?)', [$idcohort, $USER -> id]);
		
		
		//$n1 = verification_group_membership ($USER -> id);

// Получение информации из настроек блока
//$pluginconfigs = get_config('block_application_request');		
//$n = $pluginconfigs -> kafedra1;

	/*1*/ //Определяю права пользователя, - if - admin; else - все остальные.
		$context = context_system::instance();		
		$this -> content = new stdClass();
		$this -> content->text = '';
		$this -> content -> items = array();
		if (student_membership_check($USER -> id)){
			//$this -> content -> items[] = html_writer::tag('a', 'Создать заявку для получения повышенной стипендии', array('href' => '../blocks/application_request/add_application.php'));
			if (is_application_exists()){
				$this -> content -> items[] = html_writer::tag('a', 'Посмотреть существующие заявки на получение повышенной стипендии', array('href' => '../blocks/application_request/view_applications_list.php'));
			}
		}
		if(committee_membership_check($USER -> id)){
			$this -> content -> items[] = html_writer::tag('a', 'Сводная таблица данных о студентах', array('href' => '../blocks/application_request/viewing_table_applicants.php'));			
		}	
#		if(nsn001_check($USER -> id)){
#	$this -> content -> items[] = html_writer::tag('a', 'Добавить студентов в группу доступа', array('href' => '../blocks/application_request/add_students.php'));			
#		}	
		return $this -> content;	
	}

	 public function get_config_for_external() 
	 {
		creating_cohorts();
	 }
	
}
