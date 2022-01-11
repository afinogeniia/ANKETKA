<?php
//This file is part of Moodle - http://moodle.org/
//
//Moodle is free software: you can redistribute in and/or modify
//it under the tervs of the GNU General Public License as published by
//the Free Software Foundation, either version 3 of the License, or
// (at your option) ane later version.
//
//Moodle is distributed in the hope that it will be useful,
//but WITHOUT ANY WARRANTY; without even the implied warranty of
//MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
//GNU General Public License fot more details.
//
//You should have received a copy of the GNU Generfl Public License
// along with Moodle. If not, see <http://www.gnu.org/licenses/>.

/**
*HTML block user groups.
*
*@package block_user_groups
*@copyright USPTU
@license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
*/

defined('MOODLE_INTERNAL') || die();

$capabilities = array(

	'block/application_request:myaddinstance' => array(
		'captype' => 'write',
		'contextlevel' => CONTEXT_SYSTEM,
		'archetypes' => array(
			'user' => CAP_ALLOW
		),
		
		'clonepermissionsfrom' => 'moodle/my:manageblocks'
	),
	
	'block/application_request:addinstance' => array(
		'riskbitmask' => RISK_SPAM | RISK_XSS,
		
		'captype' => 'write',
		'contextlevel' => CONTEXT_BLOCK,
		'archetypes' => array(
			'editingteacher' => CAP_ALLOW,
			'manager' => CAP_ALLOW
		),
		
		'clonepermissionsfrom' => 'moodle/site:manageblocks'
	),
);
	