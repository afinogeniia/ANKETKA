<?php 
## На этой странице должно быть отображение всех данных заявления
# и возможность скачать печатную форму заявления
# а так же ссылка на страницу загрузки отсканированого текста заявления
#После загрузки заявления появляется кнопка отправить заявления
# это вызов следующго шага
require_once (dirname(dirname(__DIR__)).'/config.php'); 
require_once ($CFG->dirroot . '/blocks/anketka/applicantslib.php');
require_once($CFG->dirroot.'/blocks/anketka/application_form.php');

global $PAGE;
global $USER;	
	
require_login();


if (isguestuser()) {
    die();
}

$returnurl = optional_param('returnurl', '', PARAM_LOCALURL);
$applicationid = optional_param('id', 0, PARAM_INT);

if (empty($returnurl)) {
    $returnurl = new moodle_url('/blocks/anketka/add_application.php');
}



$context = context_user::instance($USER->id);
//$context = context_user::instance ($pustbudet);



$struser = get_string('user');

$PAGE->set_url('/blocks/anketka/checkandsend.php');
$PAGE->set_context($context);
//$PAGE->set_title($title);
$PAGE->set_heading(fullname($USER));
$PAGE->set_pagelayout('standard');


$PAGE->set_pagetype('my-index');

echo $OUTPUT->header();	
//echo $OUTPUT->heading('Ваше заявление', 2);
echo ('<b>Сведения о кандидате на получение повышенной государственной академической стипендии</b>');
//$data = $DB->get_record('block_anketka_applicants', array('applicantid' => $USER -> id), '*', MUST_EXIST);
$data = $DB->get_record('block_anketka_applicants', array('id' => $applicationid), '*', MUST_EXIST);
$table1 = create_table_applicant_date($applicationid);
echo html_writer::table($table1);
# TODO сделать красивое отображение данных заявления
//echo $OUTPUT->heading('Ваши достижения', 2);

$table = create_table_doclist($applicationid);	
echo html_writer::table($table);
if(empty($data->itemid)){
    # TODO довести до ума скачивание файла. Что-то не то вообще с этим механизмом. 
    # файл при открытии выдаёт какие-то ошибки
    echo html_writer::tag('a', 'скачать проект заявки для получения стипендии', array('href' => "./download_application_project.php?id={$applicationid}"));

    echo html_writer::start_tag( 'a', array( 'href' => "./upload_application.php?id={$applicationid}" ) )
        .html_writer::start_tag( 'button', array( 'type' => 'button', 'class' => 'btn btn-primary', 'style' =>'margin:3%; width:26%' ) )
        .format_string( 'Загрузить отсканированное заявление' )
        .html_writer::end_tag('button')
        .html_writer::end_tag( 'a' );
}
else{
    echo html_writer::start_tag('p')
    .'Скан заявления:'
    .display_file($data->contextid,$data->itemid)
    .html_writer::start_tag( 'a', array( 'href' => "./checkandsenddel.php?id={$applicationid}" ) )
        .html_writer::start_tag( 'button', array( 'type' => 'button', 'class' => 'btn btn-primary', 'style' =>'margin:3%; width:26%' ) )
        .format_string( 'Удалить загруженный скан' )
        .html_writer::end_tag('button')
        .html_writer::end_tag( 'a' )
    .html_writer::end_tag('p');
#TODO удаление заявления
}
echo "<br>";
# Здесь редерятся кнопки внизу страницы
# Кнопка отправки повится если будет загружено отсканированная версия заявления
render_checkandsend_page_bottom($applicationid);
echo $OUTPUT->footer();
