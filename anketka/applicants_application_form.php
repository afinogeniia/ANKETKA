<?php
if (!defined('MOODLE_INTERNAL')) {
    die('Direct access to this script is forbidden.');    //  It must be included from a Moodle page.
}

require_once($CFG->dirroot.'/lib/formslib.php');

/**
 * Class user_edit_form.
 *
 * @copyright 1999 Martin Dougiamas  http://dougiamas.com
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class anketa_soiskatelya_form extends moodleform 
{

    /**
     * Define the form.
     */
    public function definition () 
	{
        global $CFG, $COURSE, $USER, $DB;
//$DB -> set_debug (true);
        $mform = $this->_form;
        $editoroptions = null;
        $filemanageroptions = null;
        //$usernotfullysetup = user_not_fully_set_up($USER);

		$poryadkoviinomer = $USER -> id;
		$polsovatelll = $DB -> get_records_sql ('SELECT * FROM {block_anketka_applicants} WHERE (applicantid = ?)', [$poryadkoviinomer]);
		if ($polsovatelll === [])
		{
			$polsovatel = $DB -> get_records_sql ('SELECT * FROM {user} WHERE (id = ?)', [$poryadkoviinomer]);
		
			foreach ($polsovatel as $samsamich)
			{
				$imya = $samsamich -> firstname;
				$familija = $samsamich -> lastname;
				$gruppa = $samsamich -> department;
				$telefon = $samsamich -> phone1;
				$pochta = $samsamich -> email;
				$otchestwo = $samsamich -> alternatename;
			}
			$otchestwo1 = explode (" ", $otchestwo);
        
			$mform->addElement('hidden', 'id');
			$mform->setType('id', PARAM_INT);
			$mform->addElement('hidden', 'course', $COURSE->id);
			$mform->setType('course', PARAM_INT);

			// Print the required moodle fields first.
			//$mform->addElement('header', 'moodle', $strgeneral);
			$mform -> addElement('header', 'moodle', 'Информация о соискателе');
		
			$mform -> addElement('textarea', 'imya', get_string("firstname"), 'wrap="virtual" rows = "1" cols = "30"');
			$mform -> setDefault('imya', $imya);
			//$mform->setType('name', core_user::get_property_type('name'));
			$mform -> addElement('textarea', 'otchestwo', 'Отчество', 'wrap="virtual" rows = "1" cols = "30"');
			$mform -> setDefault('otchestwo', $otchestwo1);
			$mform -> addElement('textarea', 'familija', get_string("lastname"), 'wrap="virtual" rows = "1" cols = "30"');
			$mform -> setDefault('familija', $familija);
			$mform -> addElement('textarea', 'institut', 'Институт', 'wrap="virtual" rows = "1" cols = "30"');
			$mform -> addElement('textarea', 'kurs', get_string("course"), 'wrap="virtual" rows = "1" cols = "30"');
			$mform -> addElement('textarea', 'gruppa', get_string("group"), 'wrap="virtual" rows = "1" cols = "30"');
			$mform -> addElement('textarea', 'telephon', 'Телефон', 'wrap="virtual" rows = "1" cols = "30"');
			$mform -> setDefault('telephon', $telefon);
			$mform -> addElement('textarea', 'email', get_string("email"), 'wrap="virtual" rows = "1" cols = "30"');
			$mform -> setDefault('email', $pochta);
			$mform -> addElement('select', 'dejatelnist', 'Тип', array('учебная деятельность', 'научно-исследовательская деятельность', 'общественная деятельность', 'культурно-творческая деятельность', 'спортивная деятельность'));
			$mform -> addElement('selectyesno', 'poluchalli', 'Получали ли стипендию повышенную в предыдущем семестре');
			//$mform -> addElement('filemanager', 'attachments', get_string('attachment', 'moodle'), null, array('subdirs'=>0, 'maxbytes' => 100000, 'areamaxbytes' => 10485760, 'maxfiles' => 50, 'accepted_types' => array('image'), 'retyrn_types' => 'FILE_INTERNAL' | 'FILE_EXTERNAL'));
			$this->add_action_buttons(true, get_string('savechanges'));
		}
			else
			{
				foreach ($polsovatelll as $samsamichhh)
				{
					$imya = $samsamichhh -> applicantsname;
					$otchestwo = $samsamichhh -> applicantspatronymic;
					$familija = $samsamichhh -> applicantslastname;
					$institut = $samsamichhh -> applicantsinstitute;
					$kurs = $samsamichhh -> applicantscourse;
					$gruppa = $samsamichhh -> applicantsgroup;
					$telefon = $samsamichhh -> applicantsphonenumber;
					$pochta = $samsamichhh -> applicantsmailingaddress;
				}
				$mform->addElement('hidden', 'id');
				$mform->setType('id', PARAM_INT);
				$mform->addElement('hidden', 'course', $COURSE->id);
				$mform->setType('course', PARAM_INT);

				// Print the required moodle fields first.
				//$mform->addElement('header', 'moodle', $strgeneral);
				$mform -> addElement('header', 'moodle', 'Информация о соискателе');
		
				$mform -> addElement('textarea', 'imya', get_string("firstname"), 'wrap="virtual" rows = "1" cols = "30"');
				$mform -> setDefault('imya', $imya);
				//$mform->setType('name', core_user::get_property_type('name'));
				$mform -> addElement('textarea', 'otchestwo', 'Отчество', 'wrap="virtual" rows = "1" cols = "30"');
				$mform -> setDefault('otchestwo', $otchestwo);
				$mform -> addElement('textarea', 'familija', get_string("lastname"), 'wrap="virtual" rows = "1" cols = "30"');
				$mform -> setDefault('familija', $familija);
				$mform -> addElement('textarea', 'institut', 'Институт', 'wrap="virtual" rows = "1" cols = "30"');
				$mform -> setDefault('institut', $institut);
				$mform -> addElement('textarea', 'kurs', get_string("course"), 'wrap="virtual" rows = "1" cols = "30"');
				$mform -> setDefault('kurs', $kurs);
				$mform -> addElement('textarea', 'gruppa', get_string("group"), 'wrap="virtual" rows = "1" cols = "30"');
				$mform -> setDefault('gruppa', $gruppa);
				$mform -> addElement('textarea', 'telephon', 'Телефон', 'wrap="virtual" rows = "1" cols = "30"');
				$mform -> setDefault('telephon', $telefon);
				$mform -> addElement('textarea', 'email', get_string("email"), 'wrap="virtual" rows = "1" cols = "30"');
				$mform -> setDefault('email', $pochta);
				$mform -> addElement('select', 'dejatelnist', 'Тип', array('учебная деятельность', 'научно-исследовательская деятельность', 'общественная деятельность', 'культурно-творческая деятельность', 'спортивная деятельность'));
				$mform -> addElement('selectyesno', 'poluchalli', 'Получали ли стипендию повышенную в предыдущем семестре');
				$mform -> setDefault('poluchalli', 'yes');
				//$mform -> addElement('filemanager', 'attachments', get_string('attachment', 'moodle'), null, array('subdirs'=>0, 'maxbytes' => 100000, 'areamaxbytes' => 10485760, 'maxfiles' => 50, 'accepted_types' => array('image'), 'retyrn_types' => 'FILE_INTERNAL' | 'FILE_EXTERNAL'));
				$this->add_action_buttons(true, get_string('savechanges'));
			}
	}
	function validation ($data, $files)
		{
			return array ();
		}
}
//$mform -> addElement('submit', 'submitbutton', get_string('savechanges'));

class applicants_documents_form extends moodleform 
{

    /**
     * Define the form.
     */
    public function definition () {
        global $CFG, $COURSE, $USER, $DB;
//$DB -> set_debug (true);
        $mform = $this->_form;
		
        $editoroptions = null;
        $filemanageroptions = null;
        $usernotfullysetup = user_not_fully_set_up($USER);

		$poryadkoviinomer = $USER -> id;
        
		$mform->addElement('hidden', 'id');
        $mform->setType('id', PARAM_INT);
        $mform->addElement('hidden', 'course', $COURSE->id);
        $mform->setType('course', PARAM_INT);

        // Print the required moodle fields first.
        //$mform->addElement('header', 'moodle', $strgeneral);
		$mform -> addElement('header', 'moodle', 'Информация о достижениях соискателя');
		
		$mform -> addElement('textarea', 'dostijenie', 'Достижение', 'wrap="virtual" rows = "1" cols = "30"');
		//$mform->setType('dostijenie', core_user::get_property_type('dostijenie'));
		$mform -> setDefault ('dostijenie', '');
		$mform -> addElement('textarea', 'data', 'Дата', 'wrap="virtual" rows = "1" cols = "30"');
		$mform -> setType ('data', PARAM_CLEAN);
		$mform -> addElement('textarea', 'document', 'Документ', 'wrap="virtual" rows = "1" cols = "30"');
		$mform -> setDefault ('document', '');
		$mform -> addElement('textarea', 'primechanie', 'Примечание', 'wrap="virtual" rows = "1" cols = "30"');
		$mform -> setDefault ('primechanie', '');
		$this->add_action_buttons(true, get_string('savechanges'));
    }
	//}
	function validation ($data, $files)
		{
			return array ();
			
		}
}
		
		class applicants_test_file extends moodleform 
{

    /**
     * Define the form.
     */
    public function definition () {
        global $CFG, $COURSE, $USER, $DB;
//$DB -> set_debug (true);
        $mform = $this->_form;
		$data = $this->_customdata['data'];
        $editoroptions = null;
        $filemanageroptions = null;
        $usernotfullysetup = user_not_fully_set_up($USER);

		$poryadkoviinomer = $USER -> id;
        
		$mform->addElement('hidden', 'id');
        $mform->setType('id', PARAM_INT);
        $mform->addElement('hidden', 'course', $COURSE->id);
        $mform->setType('course', PARAM_INT);

        // Print the required moodle fields first.
        //$mform->addElement('header', 'moodle', $strgeneral);
		$mform -> addElement('header', 'moodle', 'Информация о достижениях соискателя');
		
		$mform -> addElement('file', 'attachment', 'Достижение');
		
		$this->add_action_buttons(true, get_string('savechanges'));
		$this->set_data($data);
    }
	//}
	function validation ($data, $files)
		{
			return array ();
			
		}
}