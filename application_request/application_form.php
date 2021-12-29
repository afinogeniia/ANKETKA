<?php
if (!defined('MOODLE_INTERNAL')) {
    die('Direct access to this script is forbidden.');    //  It must be included from a Moodle page.
}

require_once($CFG->dirroot.'/lib/formslib.php');

/**
 * Class application_request_application_form.
 * Форма ввода персональных данных соискателя стипендии
 * Первый шаг заполнения анкеты
 *
 * @copyright 2021 Sergey Nidchenko  
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class application_request_application_form extends moodleform 
{   
    /**
     * Констуртор класс
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

		
        # Если при инициализации объекта  указан 
        # id = 0 , считаем что создаётся новое заявление 
		if ($this->applicationid==0)
		{
            $firstname = $USER -> firstname;
            $lastname = $USER -> lastname;
            $group = $USER -> department;
			
			$array_group = explode('.', $group);

			//echo ($array_group[4]);

            $phone = $USER -> phone1;
            $email = $USER -> email;
			//$a = 'верификация';
            $middlename1 = $USER -> alternatename;
			$middlename = explode (" ", $USER -> alternatename);
# TODO: применть addRUle валидацию на стороне клиента        

			$mform -> addElement('header', 'moodle', get_string('informationapplicant', 'block_application_request'));
            $mform->addElement('hidden', 'applicantid');
            $mform->setType('applicantid', PARAM_INT);
            $mform -> setDefault('applicantid', $USER -> id);
		
			$mform -> addElement('textarea', 'firstname', get_string('firstname', 'block_application_request'), 'wrap="virtual" rows = "1" cols = "30"');
			$mform->addRule('firstname', get_string('required'), 'required', null, 'client');
			$mform -> setDefault('firstname', $firstname);
			
			$mform -> addElement('textarea', 'middlename', get_string('middlename', 'block_application_request'), 'wrap="virtual" rows = "1" cols = "30"');
			
			$mform -> addElement('textarea', 'lastname', get_string('lastname', 'block_application_request'), 'wrap="virtual" rows = "1" cols = "30"');
			$mform->addRule('lastname', get_string('required'), 'required', null, 'client');
			$mform -> setDefault('lastname', $lastname);
			
			$k = 'ИСОП';
			$opt = array(
				'ИГИМП' => 'ИГИМП',
				'ИПИП' => 'ИПИП',
				'ИП' => 'ИП',
				'ИСОП' => 'ИСОП',
				'ИЮ' => 'ИЮ');
			/*$mform -> addElement('select', 'institut', get_string('institute', 'block_application_request'), array(
			$a, 'ИГИМП', 'ИПИП', 'ИП', 'ИСОП', 'ИЮ'));*/
			$select = $mform -> addElement('select', 'institut', get_string('institute', 'block_application_request'), $opt);
			$select -> setSelected($array_group[4]);
			
			

			$mform -> addElement('select', 'kurs', get_string('course', 'block_application_request'), array('1', '2', '3', '4', '5', '6'));

			$groupname1 = group_name ($group);
			$mform -> addElement('textarea', 'group', get_string('group', 'block_application_request'), 'wrap="virtual" rows = "1" cols = "30"');
			$mform->addRule('group', get_string('required'), 'required', null, 'client');
			$mform -> setDefault('group', $groupname1);
			
			$mform -> addElement('textarea', 'phone', get_string('telephone', 'block_application_request'), 'wrap="virtual" rows = "1" cols = "30"');
			$mform->addRule('phone', get_string('required'), 'required', null, 'client');
			$mform -> setDefault('phone', $phone);
			
			$mform -> addElement('textarea', 'email', get_string('email', 'block_application_request'), 'wrap="virtual" rows = "1" cols = "30"');
			$mform->addRule('email', get_string('required'), 'required', null, 'client');
			$mform -> setDefault('email', $email);
			
			$mform -> addElement('select', 'activity', get_string('type', 'block_application_request'), array('учебная деятельность', 'научно-исследовательская деятельность', 'общественная деятельность', 'культурно-творческая деятельность', 'спортивная деятельность'));

			$mform -> addElement('selectyesno', 'received', get_string('flag', 'block_application_request'));
		
			$this->add_action_buttons(true, get_string('buttoncontinued', 'block_application_request'));
		}
		else
        {   
            # При инициализации было указано id заявления, предзаполняем форму
            # по данным из базы
            $data = $DB -> get_records_sql('SELECT * FROM {block_app_request_applicants} WHERE (id = ?)', [$this->applicationid]);
            foreach ($data as $item)
            {
                $firstname = $item -> applicantname;
                $middlename = $item -> applicantmiddlename;
                $lastname = $item -> applicantlastname;
                $institut = $item -> applicantinstitute;
                $kurs = $item -> applicantcourse;
                $group = $item -> applicantgroup;
                $phone = $item -> applicantphone;
                $email = $item -> applicantemail;
				$activity = $item -> directionofactivity;
                $scholarshipholder = $item -> scholarshipholder;
            }
            $mform->addElement('hidden', 'id');
            $mform->setType('id', PARAM_INT);
            $mform -> setDefault('id', $this->applicationid);
            $mform -> addElement('header', 'moodle', get_string('informationapplicant', 'block_application_request'));

            $mform->addElement('hidden', 'applicantid');
            $mform->setType('applicantid', PARAM_INT);
            $mform -> setDefault('applicantid', $USER -> id);

            $mform -> addElement('textarea', 'firstname', get_string('firstname', 'block_application_request'), 'wrap="virtual" rows = "1" cols = "30"');
            $mform->addRule('firstname', get_string('required'), 'required', null, 'client');
			$mform -> setDefault('firstname', $firstname);
            
			$mform -> addElement('textarea', 'middlename', get_string('middlename', 'block_application_request'), 'wrap="virtual" rows = "1" cols = "30"');
			$mform->addRule('middlename', get_string('required'), 'required', null, 'client');            
			$mform -> setDefault('middlename', $middlename);
            
			$mform -> addElement('textarea', 'lastname', get_string('lastname', 'block_application_request'), 'wrap="virtual" rows = "1" cols = "30"');
			$mform->addRule('lastname', get_string('required'), 'required', null, 'client');            
			$mform -> setDefault('lastname', $lastname);
            
			//$mform -> addElement('textarea', 'institut', 'Институт', 'wrap="virtual" rows = "1" cols = "30"');
			/*$mform -> addElement('select', 'institut', get_string('institute', 'block_application_request'), array(
			'Институт государственного и международного права', 'Институт дополнительного образования',
			'Институт права и предпринимательства', 'Институт прокуратуры', 
			'Институт специальных образовательных программ', 'Институт юстиции', 
			'Институт довузовской подготовки'));
			$mform->addRule('institut', get_string('required'), 'required', null, 'client');      
			$mform -> setDefault('institut', $institut);*/
			
			$opt = array(
				'ИГИМП' => 'ИГИМП',
				'ИПИП' => 'ИПИП',
				'ИП' => 'ИП',
				'ИСОП' => 'ИСОП',
				'ИЮ' => 'ИЮ');
			/*$mform -> addElement('select', 'institut', get_string('institute', 'block_application_request'), array(
			$a, 'ИГИМП', 'ИПИП', 'ИП', 'ИСОП', 'ИЮ'));*/
			$select = $mform -> addElement('select', 'institut', get_string('institute', 'block_application_request'), $opt);
			$select -> setSelected($institut);
            
			//$mform -> addElement('textarea', 'kurs', get_string("course"), 'wrap="virtual" rows = "1" cols = "30"');
			/*$mform -> addElement('select', 'kurs', get_string('course', 'block_application_request'), array('1', '2', '3', '4', '5', '6'));
			$mform->addRule('kurs', get_string('required'), 'required', null, 'client');            
			$mform -> setDefault('kurs', $kurs);*/
			$opt1 = array(
					'1' => '1',
					'2' => '2',
					'3' => '3',
					'4' => '4',
					'5' => '5');
			$select1 = $mform -> addElement('select', 'kurs', get_string('course', 'block_application_request'), $opt1);
			$select1 -> setSelected($kurs);
            
			$mform -> addElement('textarea', 'group', get_string('group', 'block_application_request'), 'wrap="virtual" rows = "1" cols = "30"');
			$mform->addRule('group', get_string('required'), 'required', null, 'client');            
			$mform -> setDefault('group', $group);
            
			$mform -> addElement('textarea', 'phone', get_string('telephone', 'block_application_request'), 'wrap="virtual" rows = "1" cols = "30"');
			$mform->addRule('phone', get_string('required'), 'required', null, 'client');
			$mform -> setDefault('phone', $phone);
            
			$mform -> addElement('textarea', 'email', get_string('email', 'block_application_request'), 'wrap="virtual" rows = "1" cols = "30"');
			$mform->addRule('email', get_string('required'), 'required', null, 'client');
			$mform -> setDefault('email', $email);
            
			/*switch($activity)
			{
				case "учебная деятельность": $mform -> addElement('select', 'activity', 'Тип', array('учебная деятельность', 'научно-исследовательская деятельность', 'общественная деятельность', 'культурно-творческая деятельность', 'спортивная деятельность')); break;
				case "научно-исследовательская деятельность": $mform -> addElement('select', 'activity', 'Тип', array('научно-исследовательская деятельность', 'общественная деятельность', 'культурно-творческая деятельность', 'спортивная деятельность', 'учебная деятельность')); break;
				case "общественная деятельность": $mform -> addElement('select', 'activity', 'Тип', array('общественная деятельность', 'культурно-творческая деятельность', 'спортивная деятельность','учебная деятельность', 'научно-исследовательская деятельность')); break;
				case "культурно-творческая деятельность": $mform -> addElement('select', 'activity', 'Тип', array('культурно-творческая деятельность', 'спортивная деятельность','учебная деятельность', 'научно-исследовательская деятельность', 'общественная деятельность')); break;
				case "спортивная деятельность": $mform -> addElement('select', 'activity', 'Тип', array('спортивная деятельность','учебная деятельность', 'научно-исследовательская деятельность', 'общественная деятельность', 'культурно-творческая деятельность')); break;
			}*/
			$mform -> addElement('select', 'activity', get_string('type', 'block_application_request'), array('учебная деятельность', 'научно-исследовательская деятельность', 'общественная деятельность', 'культурно-творческая деятельность', 'спортивная деятельность'));
			$mform->addRule('activity', get_string('required'), 'required', null, 'client');
			
			$mform -> addElement('selectyesno', 'received', get_string('flag', 'block_application_request'));
			$mform->addRule('received', get_string('required'), 'required', null, 'client');            
			# TODO: сделать правильный дефалт для поля received
            $mform -> setDefault('received', 'yes');
            
            $this->add_action_buttons(true, get_string('buttoncontinued', 'block_application_request'));
		}
	}
    # TODO: валидацию данных
	function validation ($data, $files)
		{
			return array ();
		}
}


