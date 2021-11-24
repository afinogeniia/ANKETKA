<?php
	class block_anketka_edit_form extends block_edit_form
	{
		protected function specific_definition($mform)
		{
			$mform->addElement('header', 'config_header', get_string('blocksettings', 'block'));
			$mform->addElement('text', 'config_text', 'строка'));
			$mform->setDefault('config_text', 'значение');
			$mform->setType('config_text', PARAM_RAW);
		}
	}