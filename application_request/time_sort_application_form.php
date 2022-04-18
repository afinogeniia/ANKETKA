<?php
if (!defined('MOODLE_INTERNAL')) {
    die('Direct access to this script is forbidden.');    //  It must be included from a Moodle page.
}

require_once($CFG->dirroot.'/lib/formslib.php');

/**
 * Class grant_proposals_application_form.
 * Форма ввода персональных данных соискателя стипендии
 * Первый шаг заполнения анкеты
 *
 * @copyright 2021 Sergey Nidchenko  
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class time_sort_application_form extends moodleform 
{   
    /**
     * Конструктор класс
     * может получать идентификатор заявления
     * для предзаполнения формы для редактирования
     */
    public function __construct(){
        parent::__construct();
    }

    /**
     * Define the form.
     */
    public function definition () 
	{
        global $CFG, $COURSE, $USER, $DB;
        $mform = $this->_form;
        $editoroptions = null;
        $filemanageroptions = null;
		$mform->addElement('date_selector', 'assesstimestart', get_string('from'));
		$mform->addElement('date_selector', 'assesstimefinish', get_string('to'));
		$this->add_action_buttons(true, 'Выбрать');
	}
    # TODO: валидацию данных
	function validation ($data, $files)
		{
			return array ();
		}
}


