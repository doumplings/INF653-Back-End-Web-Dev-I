<?php include __DIR__ . '/header.php'; ?>
<section class="panel">
    <h2>Admin Error</h2>
    <p><?= h($error ?? 'An unknown admin error occurred.') ?></p>
    <p><a class="btn" href=".?action=list_vehicles">Return to Vehicle List</a></p>
</section>
<?php include __DIR__ . '/footer.php'; ?>