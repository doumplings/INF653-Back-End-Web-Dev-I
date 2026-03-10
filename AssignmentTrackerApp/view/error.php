<?php include('view/header.php'); ?>

<section class="assignment-container">
    <h2>Error</h2>
    <p><?= htmlspecialchars($error ?? 'An unknown error occurred.') ?></p>
    <p><a href=".">&#8592; Back to Assignments</a></p>
</section>

<?php include('view/footer.php'); ?>