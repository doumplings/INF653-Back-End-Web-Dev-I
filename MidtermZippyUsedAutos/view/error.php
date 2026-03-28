<?php
$page_title = 'Error | Zippy Used Autos';
include __DIR__ . '/header.php';
?>
<section class="panel">
    <h2>Application Error</h2>
    <p><?= htmlspecialchars($error ?? 'An unknown error occurred.', ENT_QUOTES, 'UTF-8') ?></p>
    <p><a class="btn" href=".">Return to inventory</a></p>
</section>
<?php include __DIR__ . '/footer.php'; ?>