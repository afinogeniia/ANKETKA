<?php 
## На этой странице должно быть отображение всех данных заявления
# и возможность скачать печатную форму заявления
# а так же ссылка на страницу загрузки отсканированого текста заявления
#После загрузки заявления появляется кнопка отправить заявления
# это вызов следующго шага
require_once(dirname(dirname(__DIR__)).'/config.php'); 
require_once($CFG->dirroot . '/blocks/application_request/applicantslib.php');
require_once($CFG->dirroot.'/blocks/application_request/application_form.php');

global $PAGE;
global $USER;	
	
require_login();


if (isguestuser()) {
    die();
}

$applicationid = optional_param('id', 0, PARAM_INT);
$context = context_user::instance($USER->id);
$struser = get_string('user');
$PAGE->set_url('/blocks/application_request/checkandsend.php');
$PAGE->set_context($context);
$PAGE->set_heading(fullname($USER));
$PAGE->set_pagelayout('standard');
$PAGE->set_pagetype('my-index');
echo $OUTPUT->header();	


global $DB;

$fh = fopen('enrollment.csv', 'r');
try{
    $group = $DB->get_record('cohort', array('name' => 'scholarship_request_students'), '*', MUST_EXIST);
}catch(Exception $e){
    die();
}


$data_groups = [];
$k = 0;
while (($row = fgetcsv($fh, 0)) !== false)
{
    $data_groups[] =array('enrollmentlogin' => $row[0]);
}
$i = 0;
foreach ($data_groups as $row)
{   
    try{
        $user_obj = $DB -> get_record('user', array('username' => $row['enrollmentlogin']), '*', MUST_EXIST);
    }catch(Exception $e){
        continue;
    }
    $enrollment_cohort = new stdClass();
    $enrollment_cohort->cohortid = $group->id;
    $enrollment_cohort->userid = $user_obj->id;
    $data4 = $DB -> get_records_sql ('SELECT * FROM {cohort_members} WHERE cohortid = ? AND userid = ?', [$enrollment_cohort->cohortid, $enrollment_cohort->userid]);
//    var_dump($data4);
    if(empty($data4)){
        $DB->insert_record('cohort_members', $enrollment_cohort, $returnid = true, $bulk = false);
        $i++;
    }
                
}
echo "{$i} users added";




echo $OUTPUT->footer();
