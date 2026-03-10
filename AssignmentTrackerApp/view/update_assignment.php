<?php
include('view/header.php');
?>

<section class="assignment-container">
    <h2>Update Assignment</h2>

    <form action="." method="post">
        <input type="hidden" name="assignment_id" value="<?= $assignment['ID'] ?>">

        <select name="course_id" required>
            <option value="">Please select</option>
            <?php foreach ($courses as $course): ?>
                <option value="<?= $course['courseID'] ?>" <?= $assignment['courseID'] == $course['courseID'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($course['courseName']) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <input type="text" name="description" maxlength="120"
            value="<?= htmlspecialchars($assignment['Description']) ?>" required>

        <button type="submit" name="action" value="update_assignment">Update</button>
        <a href=".">Cancel</a>
    </form>
</section>

<?php
include('view/footer.php');
?>