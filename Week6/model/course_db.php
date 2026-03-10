<?php
require_once("database.php");

function get_courses()
{
    global $db;
    $query = "SELECT * FROM courses";
    $statement = $db->prepare($query);
    $statement->execute();
    $courses = $statement->fetchAll();
    $statement->closeCursor();
    return $courses;
}

function get_course_name($course_id)
{
    global $db;
    if ($course_id) {
        return "All Courses";
    }
    $query = "SELECT course_name FROM courses WHERE course_id = :course_id";
    $statement = $db->prepare($query);
    $statement->bindValue(":course_id", $course_id);
    $statement->execute();
    $course = $statement->fetch();
    $statement->closeCursor();
    return $course ? $course["courseName"] : "Unknown Course";
}

function delete_course($course_id)
{
    global $db;
    if ($course_id) {
        try {
            $query = "DELETE FROM courses WHERE courseID=:courseID";
            $statement = $db->prepare($query);
            $statement->bindValue(":courseID", $course_id);
            $statement->execute();
            $statement->closeCursor();
        } catch (PDOException $e) {
            throw new Exception("Error deleting course: " . $e->getMessage());
        }
    }
}
function add_course($course_name)
{
    global $db;
    $query = "INSERT INTO courses (courseName) VALUES (:courseName)";
    $statement = $db->prepare($query);
    $statement->bindValue(":courseName", $course_name);
    $statement->execute();
    $statement->closeCursor();
}
?>