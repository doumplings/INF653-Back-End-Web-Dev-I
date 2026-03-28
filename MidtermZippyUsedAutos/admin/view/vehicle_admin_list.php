<?php include __DIR__ . '/header.php'; ?>

<section class="panel intro-panel">
    <div>
        <h2>Vehicle Inventory</h2>
        <p>Manage existing inventory and remove records as needed.</p>
    </div>
    <div class="sort-actions">
        <a class="btn <?= $sort === 'price' ? 'btn-active' : '' ?>" href=".?action=list_vehicles&amp;sort=price">Sort by
            Price</a>
        <a class="btn <?= $sort === 'year' ? 'btn-active' : '' ?>" href=".?action=list_vehicles&amp;sort=year">Sort by
            Year</a>
    </div>
</section>

<section class="panel">
    <?php if (!empty($vehicles)): ?>
        <div class="table-wrap">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Year</th>
                        <th>Model</th>
                        <th>Make</th>
                        <th>Type</th>
                        <th>Class</th>
                        <th>Price</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($vehicles as $vehicle): ?>
                        <tr>
                            <td><?= h($vehicle['year']) ?></td>
                            <td><?= h($vehicle['model']) ?></td>
                            <td><?= h($vehicle['make_name'] ?? 'Unknown') ?></td>
                            <td><?= h($vehicle['type_name'] ?? 'Unknown') ?></td>
                            <td><?= h($vehicle['class_name'] ?? 'Unknown') ?></td>
                            <td>$<?= number_format((float) $vehicle['price'], 2) ?></td>
                            <td>
                                <form method="post" action=".">
                                    <input type="hidden" name="action" value="delete_vehicle">
                                    <input type="hidden" name="vehicle_id" value="<?= (int) $vehicle['vehicle_id'] ?>">
                                    <input type="hidden" name="sort" value="<?= h($sort) ?>">
                                    <button class="danger" type="submit"
                                        onclick="return confirm('Delete this vehicle?');">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <p>No vehicles found.</p>
    <?php endif; ?>
</section>

<?php include __DIR__ . '/footer.php'; ?>