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
class status_form extends moodleform 
{   
    /**
     * Констуртор класс
     * может получать идентификатор заявления
     * для предзаполнения формы для редактирования
     */
    public function __construct(int $appid,int $status){
        $this->applicationid = $appid;
        $this->applicationstatus = $status;
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
		$mform -> addElement('select', 'applicationstatus', 'Статус', array(2 => "Отправлено",
        3=>"Назначена",4=>"Отказано", 5=>"На рассмотрении"));
      
			$mform -> setDefault('applicationstatus', $this->applicationstatus);
            $this->add_action_buttons(true, "Сохранить");
		
	}
    # TODO: валидацию данных
	function validation ($data, $files)
		{
			return array ();
		}
}


