<?php

require_once ("../../config.php");
require_once ("../../lib/dataformatlib.php");

function require_table_download()
{
	global $DB;
	
	$data = $DB -> get_records_sql ('SELECT * FROM {block_app_request_applicants} where applicantid = ? order by id',[$USER->id]);
	$rs = array();
	$i=1;
	if (!empty($data))
	{
    //$download = optional_param('download', '', PARAM_ALPHA);
	//$table = new html_table();
    //$table->head = array(get_string('fio', 'block_application_request'), get_string('institute', 'block_application_request'), 
	//get_string('telephone', 'block_application_request'), get_string('email', 'block_application_request'),
	//get_string('documents', 'block_application_request'),get_string('status', 'block_application_request'),'');
		foreach ($data as $item)
		{
			$f = $item -> applicantlastname.' '.$item -> applicantname.' '.$item -> applicantmiddlename;
			$k = $item -> applicantinstitute;
			$y = $item -> applicantphone;
			$m = $item -> applicantemail;
			$docs = render_docs_list($item->id,$item->itemid,$item->contextid);
			$status = resolve_status($item->applicationstatus);
			if($item->applicationstatus<3)
			{
				$link = html_writer::tag('a', 'Edit', array('href' => '/blocks/application_request/add_application.php?id='.$item->id));
			}
				else
				{
					$link = '';
				}
			$rs[$i] = array ($f, $k, $y, $m,$docs,$status,$link);
			//$rs->data[] = array ($f, $k, $y, $m,$docs,$status,$link);	
			var_dump ($rs[$i]);
			$i++;
		}
	}
		return $rs;
}
	
	
	$dataformat = optional_parm('dataformat', '', PARAM_ALPHA);
	$columns = array(
	get_string('fio', 'block_application_request'),
	get_string('institute', 'block_application_request'), 
	get_string('telephone', 'block_application_request'),
	get_string('email', 'block_application_request'),
	get_string('documents', 'block_application_request'),
	get_string('status', 'block_application_request')
	);
		$rs = require_table_download();
		download_as_dataformat('myfilename', $dataformat, $columns, $rs);


































/*function indigoresultsdist_read_testresult($test_id,$fromthisdate,$tothisdate){

    if ( $curl = curl_init () ) //инициализация сеанса

    {
    
        curl_setopt ($curl, CURLOPT_URL, 'https://100.usla.ru/tandem/testresultpmm.php');//указываем адрес страницы
        curl_setopt ($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt ($curl, CURLOPT_POST, true);
        curl_setopt ($curl, CURLOPT_POSTFIELDS, array('test_id'=>$test_id,'from'=>$fromthisdate,'till'=>$tothisdate));
        curl_setopt ($curl, CURLOPT_HEADER, 0);
        curl_setopt ($curl, CURLOPT_USERPWD,'tfmd43s:nbjsk;[3sFG');
        $result = curl_exec ($curl);//выполнение запроса
        curl_close ($curl);//закрытие сеанса
    
      }
      #echo $result;
    $ar = json_decode($result,true);
    #var_dump($ar);
#$ar = array(1 => 'Kafedra 1',2 => 'Kafedra2');
return $ar;

}


$dataformat = optional_param('dataformat', '', PARAM_ALPHA);
$test_id = optional_param('test_id', '', PARAM_INT);
$fromthisdate = optional_param('fromthisdate', '', PARAM_TEXT);
$tothisdate = optional_param('tothisdate', '', PARAM_TEXT);
$columns = array(
    'idnumber' => 'idnumber'
);


$columns = array(
    get_string('indigoresultsdistlastname','indigoresultsdist'),
    get_string('indigoresultsdistcolname','indigoresultsdist'), 
    get_string('indigoresultsdistcolgroup','indigoresultsdist'),
    get_string('indigoresultsdistcoltestname','indigoresultsdist'),
    get_string('indigoresultsdistcolstatus','indigoresultsdist'),
    get_string('indigoresultsdistcolbegin','indigoresultsdist'),
    get_string('indigoresultsdistcolend','indigoresultsdist'),
    get_string('indigoresultsdistcolresult','indigoresultsdist')
);
$rs = indigoresultsdist_read_testresult($test_id,$fromthisdate,$tothisdate);
download_as_dataformat('Results', $dataformat, $columns, $rs);*/
?>