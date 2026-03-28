<?php include __DIR__ . '/header.php'; ?>

<section class="panel">
    <h2>Manage Makes</h2>
    <form class="inline-form" method="post" action=".">
        <input type="hidden" name="action" value="add_make">
        <label for="make_name">Add Make</label>
        <input id="make_name" type="text" name="make_name" maxlength="50" required>
        <button type="submit">Add Make</button>
    </form>
</section>

<section class="panel">
    <h3>Current Makes</h3>
    <?php if (!empty($makes)): ?>
        <ul class="item-list">
            <?php foreach ($makes as $make): ?>
                <?php $in_use = (int) ($make['vehicle_count'] ?? 0) > 0; ?>
                <li>
                    <span class="item-main">
                        <?= h($make['make_name']) ?>
                        <span class="usage-badge"><?= (int) ($make['vehicle_count'] ?? 0) ?> in use</span>
                    </span>
                    <form method="post" action=".">
                        <input type="hidden" name="action" value="delete_make">
                        <input type="hidden" name="make_id" value="<?= (int) $make['make_id'] ?>">
                        <button class="danger" type="submit" <?= $in_use ? 'disabled' : '' ?>
                            title="<?= $in_use ? 'Cannot delete while vehicles use this make.' : 'Delete this make.' ?>"
                            onclick="<?= $in_use ? 'return false;' : 'return confirm(\'Delete this make?\');' ?>">Delete</button>
                    </form>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>No makes found.</p>
    <?php endif; ?>
</section>

<?php include __DIR__ . '/footer.php'; ?>