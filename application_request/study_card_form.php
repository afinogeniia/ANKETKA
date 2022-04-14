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


class application_study_card_form extends moodleform 
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
		$maxbytes = 4000000;
       
		$mform->addElement('hidden', 'id');
        $mform->setType('id', PARAM_INT);
		$mform -> setDefault ('id', $this->applicationid);
		$mform -> addElement('header', 'moodle','Учебная карточка');
		
		$mform -> addElement('hidden', 'achievement', 'Учебная карточка');
		$mform->setType('achievement', PARAM_NOTAGS);
		
		$mform -> addElement ('hidden', 'date_achievement', time());
        $mform->setType('date_achievement', PARAM_NOTAGS);				
		$mform -> addElement('hidden', 'document_name','Учебная карточка');
		$mform->setType('document_name', PARAM_NOTAGS);

        $mform -> addElement('hidden', 'comment','Учебная карточка');
		$mform->setType('comment', PARAM_NOTAGS);
		$mform->addElement('filemanager', 'attachments', get_string('confirmation', 'block_application_request'), null,
                    array('subdirs' => 0, 'maxbytes' => $maxbytes, 'areamaxbytes' => 10485760, 'maxfiles' => 1,
                          'accepted_types' => array('document','image')));
		$mform->addRule('attachments', get_string('required'), 'required', null, 'client');		
		
		$this->add_action_buttons(true, get_string('buttoncontinued', 'block_application_request'));
    }

	function validation ($data, $files)
		{
			return array ();
			
		}
}
		
