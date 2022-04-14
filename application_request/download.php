<?php
require_once ("../../config.php");
require_once ("../../lib/dataformatlib.php");
require_once($CFG->dirroot.'/blocks/application_request/applicantslib.php');
	
	$dataformat = optional_param('dataformat', '', PARAM_ALPHA);
	$columns = array(
	get_string('fio', 'block_application_request'),
	get_string('institute', 'block_application_request'), 
	get_string('telephone', 'block_application_request'),
	get_string('email', 'block_application_request'),
	'Направление',
	get_string('date', 'block_application_request'),
	get_string('documents', 'block_application_request'),
	'Средний балл',
	"Кол. заявлений",
	'Статус');		
		$sv = require_table_download ($USER->id);
		\core\dataformat::download_data('tableapplicants', $dataformat, $columns, $sv); 
		//download_as_dataformat('myfilename', $dataformat, $columns, $rs);