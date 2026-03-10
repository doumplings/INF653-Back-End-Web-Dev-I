<?php include("view/header.php") ?>
<?php if (!empty($courses)): ?>
    <section id="list">
        <header>
            <h1>Course List</h1>
        </header>
        <?php foreach ($courses as $course): ?>
            <div>
                <div>
                    <p><strong><?= htmlspecialchars($course['courseName']); ?></strong>
                    </p>
                </div>
                <div>
                    <form action="." method="post">
                        <input type="hidden" name="action" value="delete_course">
                        <input type="hidden" name="course_id" value="<?= $course['courseID'] ?>">
                        <button type="submit" class="remove-button"
                            onclick="return confirm('Are you sure you want to delete this course?')">Delete</button>
                    </form>
                </div>
            </div>
        <?php endforeach; ?>
    </section>
<?php else: ?>
    <p>No courses exist yet</p>
<?php endif; ?>


<section>
    <h2>Add Course</h2>
    <form action="." method="post">
        <input type="text" name="course_name" placeholder="Course Name" maxlength="120">
        <div>
            <label for="Course Name:"></label>
            <input type="text" name="course_name" placeholder="Course Name" required>
        </div>
        <div>
            <button type="submit" name="action" value="add_course">Add</button>
        </div>
</section>
<p><a href=""></a></p>