<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Settings for the HTML block
 *
 * @copyright 2012 Aaron Barnes
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @package   block_html
 */

defined('MOODLE_INTERNAL') || die;

	if ($ADMIN->fulltree) 
	{
		$settings->add(new admin_setting_configcheckbox('block_application_request/enrollment', 'Зачислить ли студентов в группу?', '', 0));
	}
global $DB;
// файл enrollment.csv временно определила сюда - D:\server\moodle\admin
$fh = fopen('enrollment.csv', 'r');
$pluginconfigs = get_config('block_application_request');		
$n = $pluginconfigs -> enrollment;
	if ($n === '1')
	{
		$data1 = $DB -> get_records_sql ('SELECT id FROM {cohort} where name = ?', ['scholarship_request_students']);
			fgetcsv($fh, 0);
			$data_groups = [];
			$k = 0;
			while (($row = fgetcsv($fh, 0)) !== false)
			{
				list ($enrollment_login) = $row;
				$data_groups[] =
				[
					'enrollmentlogin' => $enrollment_login
				];
			}
			foreach ($data_groups as $row)
			{
				$data3 = $DB -> get_records_sql ('SELECT id FROM {user} WHERE username = ?', [$row['enrollmentlogin']]);
				if (empty($data3));
					else 
					{
						foreach ($data1 as $dddata1)
						{
							$p = $dddata1 -> id;
						}
						foreach ($data3 as $dddata3)
						{
							$u = $dddata3 -> id;
						}
						$enrollment_cohort = new stdClass();
						$enrollment_cohort->cohortid = $p;
						$enrollment_cohort->userid = $u;
						$data4 = $DB -> get_records_sql ('SELECT * FROM {cohort_members} WHERE cohortid = ? AND userid = ?', [$p, $u]);
						if (empty($data4))
							$DB->insert_record('cohort_members', $enrollment_cohort, $returnid = true, $bulk = false);
					}
			}
	}



