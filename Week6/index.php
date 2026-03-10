<?php

require_once("model/database.php");
require_once("model/assignment_db.php");
require_once("model/course_db.php");

$assignment_id = filter_input(INPUT_POST, "assignment_id", FILTER_VALIDATE_INT);
$description = filter_input(INPUT_POST, "description", FILTER_UNSAFE_RAW);
$course_name = filter_input(INPUT_POST, "courseName", FILTER_UNSAFE_RAW);

$course_id = filter_input(INPUT_POST, "course_id", FILTER_VALIDATE_INT) ?: filter_input(INPUT_GET, "course_id", FILTER_VALIDATE_INT);
$action = filter_input(INPUT_POST, "action", FILTER_UNSAFE_RAW) ?: filter_input(INPUT_GET, "action", FILTER_UNSAFE_RAW) ?: "list_assignments";

switch ($action) {
    case 'list_courses':
        $courses = get_courses();
        include("view/course_list.php");
        break;
    case 'add_course':
        if (!empty($course_name)) {
            add_course($course_name);
            header("Location: .?action=list_courses");
            exit();
        } else {
            $error = "Course name cannot be empty.";
            include("view/error.php");
            exit();
        }
        break;
    case 'add_assignment':
        if ($course_id && !empty($description)) {
            add_assignment($course_id, $description);
            header("Location: .?action=list_assignments&course_id=$course_id");
            exit();
        } else {
            $error = "Both course and description are required.";
            include("view/error.php");
            exit();
        }
        break;
    case 'delete_course':
        try {
            delete_course($course_id);
            header("Location: .?action=list_courses");
            exit();
        } catch (Exception $e) {
            $error = "You cannot delete a course that has existing assignments.";
            include("view/error.php");
            exit();
        }
        break;
    case 'delete_assignment':
        if ($assignment_id) {
            delete_assignment($assignment_id);
            header("Location: .?action=list_assignments&assignment_id=$assignment_id");
            exit();
        } else {
            $error = "Missing assignment ID";
            include("view/error.php");
            exit();
        }
        break;
    default:
        $courses = get_courses();
        $assignments = get_assignments_by_course_name($course_id);
}

?>