<?php
if (!defined('MOODLE_INTERNAL')) {
    die('Direct access to this script is forbidden.');    //  It must be included from a Moodle page.
}

require_once($CFG->dirroot.'/lib/formslib.php');

/**
 * Class status_form.
 * Форма ввода персональных данных соискателя стипендии
 * Первый шаг заполнения анкеты
 *
 * @copyright 2021 Sergey Nidchenko  
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class grade_form extends moodleform 
{   
    /**
     * Констуртор класс
     * может получать идентификатор заявления
     * для предзаполнения формы для редактирования
     */
    public function __construct(int $appid,$grade){
        $this->applicationid = $appid;
        $this->grade = $grade;
        parent::__construct();
    }

    /**
     * Define the form.
     */
    public function definition () 
	{

        $mform = $this->_form;
        $editoroptions = null;
        $filemanageroptions = null;

		
        $mform->addElement('hidden', 'id');
        $mform->setType('id', PARAM_INT);
        $mform -> setDefault('id', $this->applicationid);
        $mform -> addElement('textarea', 'grade', "Средний балл", 'wrap="virtual" rows = "1" cols = "30"');
        $mform -> setDefault('grade', $this->grade);
        $this->add_action_buttons(true, "Сохранить");
		
	}
    # TODO: валидацию данных
	function validation ($data, $files)
		{
			return array ();
		}
}


