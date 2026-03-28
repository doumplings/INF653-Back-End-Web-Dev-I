<?php include __DIR__ . '/header.php'; ?>

<section class="panel">
    <h2>Manage Types</h2>
    <form class="inline-form" method="post" action=".">
        <input type="hidden" name="action" value="add_type">
        <label for="type_name">Add Type</label>
        <input id="type_name" type="text" name="type_name" maxlength="50" required>
        <button type="submit">Add Type</button>
    </form>
</section>

<section class="panel">
    <h3>Current Types</h3>
    <?php if (!empty($types)): ?>
        <ul class="item-list">
            <?php foreach ($types as $type): ?>
                <?php $in_use = (int) ($type['vehicle_count'] ?? 0) > 0; ?>
                <li>
                    <span class="item-main">
                        <?= h($type['type_name']) ?>
                        <span class="usage-badge"><?= (int) ($type['vehicle_count'] ?? 0) ?> in use</span>
                    </span>
                    <form method="post" action=".">
                        <input type="hidden" name="action" value="delete_type">
                        <input type="hidden" name="type_id" value="<?= (int) $type['type_id'] ?>">
                        <button class="danger" type="submit" <?= $in_use ? 'disabled' : '' ?>
                            title="<?= $in_use ? 'Cannot delete while vehicles use this type.' : 'Delete this type.' ?>"
                            onclick="<?= $in_use ? 'return false;' : 'return confirm(\'Delete this type?\');' ?>">Delete</button>
                    </form>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>No types found.</p>
    <?php endif; ?>
</section>

<?php include __DIR__ . '/footer.php'; ?>