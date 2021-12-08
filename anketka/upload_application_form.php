<?php
if (!defined('MOODLE_INTERNAL')) {
    die('Direct access to this script is forbidden.');    //  It must be included from a Moodle page.
}

require_once($CFG->dirroot.'/lib/formslib.php');

/**
 * Class anketka_application_form.
 * Форма ввода персональных данных соискателя стипендии
 * Первый шаг заполнения анкеты
 *
 * @copyright 2021 Sergey Nidchenko  
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class anketka_upload_application_form extends moodleform 
{   
    /**
     * Конструктор класс
     * может получать идентификатор заявления
     * для предзаполнения формы для редактирования
     */
    public function __construct(int $appid){
        $this->applicationid = $appid;
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

		
# TODO: применть addRUle валидацию на стороне клиента        
        
        $mform->addElement('hidden', 'id');
        $mform->setType('id', PARAM_INT);
        $mform -> setDefault('id', $this->applicationid);
        $mform -> addElement('header', 'moodle', get_string('signedscan', 'block_anketka'));
        # вынести в настройки
        $maxbytes = 1000000;

        $mform->addElement('filemanager', 'attachments', get_string('confirmation', 'block_anketka'), null,
        array('subdirs' => 0, 'maxbytes' => $maxbytes, 'areamaxbytes' => 10485760, 'maxfiles' => 1,
              'accepted_types' => array('document')));
        $this->add_action_buttons(true, 'Сохранить');
	}
    # TODO: валидацию данных
	function validation ($data, $files)
		{
			return array ();
		}
}


