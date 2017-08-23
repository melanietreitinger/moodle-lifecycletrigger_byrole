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
 * Generator for the cleanupcoursestrigger_byrole testcase
 * @category   test

 * @copyright  2017 Tobias Reischmann WWU Nina Herrmann WWU
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();
/**
 * Generator class for the cleanupcoursestrigger_byrole.
 *
 * @category   test
 * @package    tool_cleanupcourses_trigger
 * @subpackage byrole
 * @copyright  2017 Tobias Reischmann WWU Nina Herrmann WWU
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class cleanupcoursestrigger_byrole_generator extends testing_data_generator {
    /**
     * Creates data to test the trigger subplugin cleanupcoursestrigger_byrole.
     */
    public function test_create_preparation () {
        global $DB;
        $generator = advanced_testcase::getDataGenerator();
        $data = array();

        // Creates different users.
        $user1 = $generator->create_user();
        $user2 = $generator->create_user();
        $user3 = $generator->create_user();

        // Creates a course with one student one teacher.
        $teachercourse = $generator->create_course(array('name' => 'teachercourse'));
        $generator->enrol_user($user1->id, $teachercourse->id, 4);
        $generator->enrol_user($user2->id, $teachercourse->id, 5);
        $data['teachercourse'] = $teachercourse;

        // Creates a course with one student one manager.
        $managercourse = $generator->create_course(array('name' => 'managercourse'));
        $manager = $generator->create_user();
        $data['manager'] = $manager;
        $generator->enrol_user($user1->id, $managercourse->id, 1);
        $generator->enrol_user($user2->id, $managercourse->id, 5);
        $data['managercourse'] = $managercourse;

        // Create a course without any role.
        $norolecourse = $generator->create_course(array('name' => 'norolecourse'));
        $data['norolecourse'] = $norolecourse;

        // Create a course already marked for deletion with one student and old.
        $norolefoundcourse = $generator->create_course(array('name' => 'norolefoundcourse'));
        $generator->enrol_user($user3->id, $norolefoundcourse->id, 5);
        $dataobject = new \stdClass();
        $dataobject->id = $norolefoundcourse->id;
        $dataobject->timestamp = time() - 31536000;
        $DB->insert_record_raw('cleanupcoursestrigger_byrole', $dataobject, true, false, true);
        $data['norolefoundcourse'] = $norolefoundcourse;

        // Create a course already marked for deletion with one student and really old.
        $norolefoundcourse2 = $generator->create_course(array('name' => 'norolefoundcourse2'));
        $generator->enrol_user($user3->id, $norolefoundcourse2->id, 5);
        $dataobject = new \stdClass();
        $dataobject->id = $norolefoundcourse2->id;
        $dataobject->timestamp = time() - 32536001;
        $DB->insert_record_raw('cleanupcoursestrigger_byrole', $dataobject, true, false, true);
        $data['norolefoundcourse2'] = $norolefoundcourse2;

        // Create a course already marked for deletion with one student and one teacher and old.
        $rolefoundagain = $generator->create_course(array('name' => 'rolefoundagain'));
        $generator->enrol_user($user3->id, $rolefoundagain->id, 4);
        $generator->enrol_user($user2->id, $rolefoundagain->id, 4);
        $dataobject = new \stdClass();
        $dataobject->id = $rolefoundagain->id;
        $dataobject->timestamp = time() - 31536000;
        $DB->insert_record_raw('cleanupcoursestrigger_byrole', $dataobject, true, false, true);
        $data['rolefoundagain'] = $rolefoundagain;
        return $data;
    }

}