<?php
/** Страница вывода данных соисктеля для члена комиссии
 * в виде таблицы.
 */
require_once ("../../config.php");
require_once ("../../lib/dataformatlib.php");
require_once($CFG->dirroot.'/blocks/grant_proposals/applicantslib.php');
			$dataformat = optional_param('dataformat', '', PARAM_ALPHA);
			$columns = array ('Учебная', 'деятельность', 'Научно-исследовтельская', 'деятельность',
						  'Общественная', 'деятельность', 'Культурно-творческая', 'деятельность',
						  'Спортивная', 'деятельность');
		$mp = table_grant_rating_download ($USER->id);
	\core\dataformat::download_data('ratingapplicants', $dataformat, $columns, $mp);
# Если возникнет ошибка с классами, - попробуйте закомментировать строку 19
# и раскомментируйте строку 25		
		//download_as_dataformat('tableapplicants', $dataformat, $columns, $sv);