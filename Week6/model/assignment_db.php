<?php
require_once('database.php');

function get_assignments_by_course_name($course_id)
{
    global $db;
    if ($course_id) {
        $query = 'SELECT a.ID, a.description, c.courseName 
              FROM assignments a
              JOIN courses c ON a.courseID = c.courseID
              WHERE c.courseID = :course_id ORDER BY a.ID';
    } else {
        $query = "";
        'SELECT a.ID, a.description, c.courseName 
                  FROM assignments a
                  JOIN courses c ON a.courseID = c.courseID
                  ORDER BY a.ID';
    }
    $statement = $db->prepare($query);
    $statement->bindValue(':course_id', $course_id);
    $statement->execute();
    $assignments = $statement->fetchAll();
    $statement->closeCursor();
    return $assignments;
}

function add_assignment($assignment_name, $description, $course_id)
{
    global $db;
    $query = "INSERT INTO assignments (assignmentName, description, courseID) VALUES (:assignment_name, :description, :course_id)";
    $statement = $db->prepare($query);
    $statement->bindValue(':assignment_name', $assignment_name);
    $statement->bindValue(':description', $description);
    $statement->bindValue(':course_id', $course_id);
    $statement->execute();
    $statement->closeCursor();
}

function delete_assignment($assignment_id)
{
    global $db;
    try {
        $query = "DELETE FROM assignments WHERE assignmentID=:assignmentID";
        $statement = $db->prepare($query);
        $statement->bindValue(":assignmentID", $assignment_id);
        $statement->execute();
        $statement->closeCursor();
    } catch (PDOException $e) {
        throw new Exception("Cannot delete course with existing assignment");
    }
}

function update_assignment($assignment_id, $description, $course_id)
{
    global $db;
    try {
        $query = "UPDATE assignments SET description=:description, courseID=:course_id WHERE assignmentID=:assignmentID";
        $statement = $db->prepare($query);
        $statement->bindValue(":description", $description);
        $statement->bindValue(":course_id", $course_id);
        $statement->bindValue(":assignmentID", $assignment_id);
        $statement->execute();
        $statement->closeCursor();
    } catch (PDOException $e) {
        throw new Exception("Error updating assignment: " . $e->getMessage());
    }
}
?>