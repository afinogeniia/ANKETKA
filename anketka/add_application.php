<?php 
require_once (dirname(dirname(__DIR__)).'/config.php'); 
require_once ($CFG->dirroot . '/blocks/application_request/applicantslib.php');
require_once($CFG->dirroot.'/blocks/application_request/application_form.php');
global $PAGE;	
	
require_login();


if (isguestuser()) {
    die();
}

$returnurl = optional_param('returnurl', '', PARAM_LOCALURL);
$applicationid = optional_param('id', 0, PARAM_INT);

if (empty($returnurl)) {
    $returnurl = new moodle_url('/blocks/application_request/add_application.php');
}



$context = context_user::instance($USER->id);
//$context = context_user::instance ($pustbudet);



$struser = get_string('user');

$PAGE->set_url('/blocks/application_request/add_application.php');
$PAGE->set_context($context);
$PAGE->set_heading(fullname($USER));
$PAGE->set_pagelayout('standard');


$PAGE->set_pagetype('my-index');

echo $OUTPUT->header();	

//$DB -> set_debug (true);
	
$mform = new application_request_application_form($applicationid);
if ($mform->is_cancelled()) {
    //Handle form cancel operation, if cancel button is present on form
    redirect('./view_applications_list.php');
} else if ($data = $mform->get_data()) 
{
    //In this case you process validated data. $mform->get_data() returns data posted in form
    
    $obj = new stdClass();
    if(isset($data->id)){
        $applicationid = $data->id;
    }
    $obj->applicantid = $data->applicantid;
    $obj->applicantname = protection_unauthorized ($data -> firstname);
    $obj->applicantmiddlename = protection_unauthorized ($data -> middlename);
    $obj->applicantlastname = protection_unauthorized ($data -> lastname);
	$obj->applicantinstitute = conversion_parametr_i ($data -> institut);
	$obj->applicantcourse = conversion_parametr_k ($data -> kurs);
    $obj->applicantgroup = protection_unauthorized ($data -> group);
	$obj->applicantphone = protection_unauthorized ($data -> phone);
	$obj->applicantemail = protection_unauthorized ($data -> email);
    $obj->applicationstatus = 1;
    $activity = $data -> activity;
    $activity = conversion_parametr_a ($activity);
    $obj->directionofactivity = $activity;
    $yesno = $data -> received;
    $yesno = conversion_parametr_y ($yesno);
    $obj->scholarshipholder = $yesno;
    if ($applicationid=='')
	{		
		$obj->applicationcreatedate = time();
        $applicationid = $DB->insert_record('block_app_request_applicants', $obj, $returnid = true, $bulk = false);
    }
		else
		{ 
			$obj->id = $applicationid;
			$obj->applicationmodifieddate = time();
			$DB->update_record('block_app_request_applicants', $obj);
		}
    redirect('/blocks/application_request/upload_documents.php?id='.$applicationid);

} else {
    // this branch is executed if the form is submitted but the data doesn't validate and the form should be redisplayed
    // or on the first display of the form.
    $mform->display();
}
   
echo $OUTPUT->footer();
