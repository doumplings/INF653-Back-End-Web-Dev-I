<?php include __DIR__ . '/header.php'; ?>

<section class="panel">
    <h2>Manage Classes</h2>
    <form class="inline-form" method="post" action=".">
        <input type="hidden" name="action" value="add_class">
        <label for="class_name">Add Class</label>
        <input id="class_name" type="text" name="class_name" maxlength="50" required>
        <button type="submit">Add Class</button>
    </form>
</section>

<section class="panel">
    <h3>Current Classes</h3>
    <?php if (!empty($classes)): ?>
        <ul class="item-list">
            <?php foreach ($classes as $class): ?>
                <?php $in_use = (int) ($class['vehicle_count'] ?? 0) > 0; ?>
                <li>
                    <span class="item-main">
                        <?= h($class['class_name']) ?>
                        <span class="usage-badge"><?= (int) ($class['vehicle_count'] ?? 0) ?> in use</span>
                    </span>
                    <form method="post" action=".">
                        <input type="hidden" name="action" value="delete_class">
                        <input type="hidden" name="class_id" value="<?= (int) $class['class_id'] ?>">
                        <button class="danger" type="submit" <?= $in_use ? 'disabled' : '' ?>
                            title="<?= $in_use ? 'Cannot delete while vehicles use this class.' : 'Delete this class.' ?>"
                            onclick="<?= $in_use ? 'return false;' : 'return confirm(\'Delete this class?\');' ?>">Delete</button>
                    </form>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>No classes found.</p>
    <?php endif; ?>
</section>

<?php include __DIR__ . '/footer.php'; ?>