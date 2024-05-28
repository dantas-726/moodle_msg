<?php
// This file is part of Moodle Course Rollover Plugin
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
 * @package     local_message
 * @author      Pedro
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


use local_message\form\edit;
use local_message\manager;

require_once(__DIR__ . '/../../config.php');

global $DB;

$PAGE->set_url(new moodle_url('/local/message/edit.php'));
$PAGE->set_context(\context_system::instance());
$PAGE->set_title(get_string('Edit'));


// We want to display our form.
$mform = new edit();


// Form processing and displaying is done here.

if ($mform->is_cancelled()) {

 // Go back to the manage.php page 

   redirect($CFG->wwwroot . '/local/message/manage.php', 'Você cancelou a mensagem');
   
} else if ($fromform = $mform->get_data()) {
  // When the form is submitted, and the data is successfully validated,
  // the `get_data()` function will return the data posted in the form.

  // Insert the data into our database table

  $recordinsert = new stdClass();
  $recordinsert->messagetext = $fromform->messagetext;
  $recordinsert->messagetype = $fromform->messagetype;

  $DB->insert_record('local_message', $recordinsert);

  // Go back to manage.php 

  redirect($CFG->wwwroot. '/local/message/manage.php', 'Você criou a mensagem: '. $fromform->messagetext);

} 

echo $OUTPUT->header();

$mform->display();

echo $OUTPUT->footer();
