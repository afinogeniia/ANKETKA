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


class application_document_form extends moodleform 
{
    /**
     * Констуктор класс
     * должен получать идентификатор заявления
     * для привязки документов к заявлению
     */
    public function __construct(int $appid){
        $this->applicationid = $appid;
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
		$maxbytes = 1000000;
       
		$mform->addElement('hidden', 'id');
        $mform->setType('id', PARAM_INT);
		$mform -> setDefault ('id', $this->applicationid);
		$mform -> addElement('header', 'moodle', 'Информация о достижениях соискателя');
		
		$mform -> addElement('textarea', 'achievement', 'Достижение', 'wrap="virtual" rows = "1" cols = "30"');
		$mform->addRule('achievement', get_string('required'), 'required', null, 'client');		
		
		$mform -> addElement ('date_selector', 'date_achievement', 'Дата');
		$mform->addRule('date_achievement', get_string('required'), 'required', null, 'client');
		
		$mform -> addElement('textarea', 'document_name', 'Документ', 'wrap="virtual" rows = "1" cols = "30"');
		$mform->addRule('document_name', get_string('required'), 'required', null, 'client');		
		
		$mform -> addElement('textarea', 'comment', 'Примечание', 'wrap="virtual" rows = "1" cols = "30"');
		
		$mform->addElement('filemanager', 'attachments', 'Подтверждающий документ', null,
                    array('subdirs' => 0, 'maxbytes' => $maxbytes, 'areamaxbytes' => 10485760, 'maxfiles' => 1,
                          'accepted_types' => array('document')));
		$mform->addRule('attachments', get_string('required'), 'required', null, 'client');
		
		$this->add_action_buttons(true, 'Далее');
    }

	function validation ($data, $files)
		{
			return array ();
			
		}
}
		
