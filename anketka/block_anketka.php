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
require_once ($CFG->dirroot . '/blocks/anketka/applicantslib.php');

class block_anketka extends block_list
{
	/*function specialozation() 
	{
		if(!empty($this -> config -> title))
		{
			$this -> title = $this -> config -> title;
		}
		else 
		{
			//$this -> config -> title = 'Заголовок по умолчанию ...';
		}
		if (empty ($this -> config -> text))
		{
			//$this -> config -> text = 'Текст по умолчанию ...';
		}
	}*/
	
	public function init()
	{
		$this -> title = 'Соискание стипендии';
        //$this->config = new stdClass();
	}
	
	function has_config() 
	{
        return true;
    }
	
	public function get_content()
	{	
		global $DB;
		global $USER;
		$idcohort1 = $DB -> get_records_sql ('SELECT * FROM {cohort} WHERE (name = ?)', ['Заявление']);
		foreach ($idcohort1 as $idcohort2) $idcohort = $idcohort2 -> id;
		$chekingthegroup = $DB -> get_records_sql ('SELECT * FROM {cohort_members} WHERE (cohortid = ? AND userid = ?)', [$idcohort, $USER -> id]);
		$pluginconfigs = get_config('block_anketka');
$n = creating_cohorts();
var_dump ($n);
		//echo ('_________PLUGINCONFIG__________');
//var_dump ($pluginconfigs);
//echo ('___________________PLUGINCONFIG____________');
$n = $pluginconfigs -> kafedra1;
echo ($n);
	/*1*/ //Определяю права пользователя, - if - admin; else - все остальные.
		$context = context_system::instance();		
		//if (has_capability('mod/folder:managefiles', $context))
		if ($chekingthegroup !== [])
		{
			$this -> content = new stdClass();
			$this -> content->text = '';
			$this -> content -> items = array();
			$this -> content -> items[] = html_writer::tag('a', 'Сводная таблица данных о студентах', array('href' => '../blocks/anketka/viewing_table_applicants.php'));
			return $this -> content;
		}
		else
		{
			$this -> content = new stdClass();
			$this -> content->text = '';
			$this -> content -> items = array();
			$this -> content -> items[] = html_writer::tag('a', 'Сводная таблица данных о студентах', array('href' => '../blocks/anketka/viewing_table_applicants.php'));
			$this -> content -> items[] = html_writer::tag('a', 'Создать заявку для получения повышенной стипендии', array('href' => '../blocks/anketka/add_application.php'));
			
			if (is_application_exists()){
				$this -> content -> items[] = html_writer::tag('a', 'Посмотреть существующие заявки на получение повышенной стипендии', array('href' => '../blocks/anketka/view_applications_list.php'));
			}
			return $this -> content;
		}		
	}

	 public function get_config_for_external() 
	 {
        // Return all settings for all users since it is safe (no private keys, etc..).
        $configs = get_config('block_anketka');
		echo ('________________CONFIGS__________________');
		var_dump ($configs);
	 }
	
}