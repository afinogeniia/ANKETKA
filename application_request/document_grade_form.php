<?php
if (!defined('MOODLE_INTERNAL')) {
    die('Direct access to this script is forbidden.');    //  It must be included from a Moodle page.
}

require_once($CFG->dirroot.'/lib/formslib.php');

/**
 * Class application_document_form.
 * Форма ввода документа соискателя стипендии
 * Форма используется на втором шаге заполнения анкеты
 *
 * @copyright 2021 Sergey Nidchenko  
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


class document_grade_form extends moodleform 
{
    /**
     * Констуктор класс
     * должен получать идентификатор заявления
     * для привязки документов к заявлению
     */
    public function __construct($obj){
        $this->obj = $obj;
        parent::__construct();
    }


    /**
     * Define the form.
     */
    public function definition () {
        global $CFG, $COURSE, $USER, $DB;
        $mform = $this->_form;
		
        $editoroptions = null;
        $filemanageroptions = null;
        $usernotfullysetup = user_not_fully_set_up($USER);
		# TODO внести в настройки $maxbytes = 1000000;
		$maxbytes = 4000000;
       
		$mform->addElement('hidden', 'id');
        $mform->setType('id', PARAM_INT);
		$mform -> setDefault ('id', $this->obj->applicationid);
        $mform->addElement('hidden', 'docid');
        $mform->setType('docid', PARAM_INT);
		$mform -> setDefault ('docid', $this->obj->id);
        
		$mform -> addElement('textarea', 'grade', 'Балл', 'wrap="virtual" rows = "1" cols = "30"');
		$mform -> setDefault ('grade', $this->obj->grade);
		$this->add_action_buttons(true, get_string('buttoncontinued', 'block_application_request'));
    }

	function validation ($data, $files)
		{
			return array ();
			
		}
}
		
