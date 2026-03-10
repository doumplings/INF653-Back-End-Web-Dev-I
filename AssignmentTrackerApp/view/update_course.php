<?php
include('view/header.php');
?>

<section class="assignment-container">
    <h2>Update Course</h2>

    <form action="." method="post">
        <input type="hidden" name="course_id" value="<?= $course['courseID'] ?>">

        <input type="text" name="course_name" maxlength="30" value="<?= htmlspecialchars($course['courseName']) ?>"
            required autofocus>

        <button type="submit" name="action" value="update_course">Update</button>
        <a href=".?action=list_courses">Cancel</a>
    </form>
</section>

<?php
include('view/footer.php');
?>