<?php
include __DIR__ . '/header.php';

if (!function_exists('h')) {
    function h($value): string
    {
        return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
    }
}
?>

<section class="panel intro-panel">
    <div>
        <h2>Find Your Next Vehicle</h2>
        <p>Current View: <strong><?= h($filter_label) ?></strong></p>
    </div>
    <div class="sort-actions">
        <a class="btn <?= $sort === 'price' ? 'btn-active' : '' ?>" href=".?action=list_vehicles&amp;sort=price">Sort by
            Price</a>
        <a class="btn <?= $sort === 'year' ? 'btn-active' : '' ?>" href=".?action=list_vehicles&amp;sort=year">Sort by
            Year</a>
    </div>
</section>

<section class="filters-grid">
    <article class="panel">
        <h3>Filter by Make</h3>
        <form method="get" action=".">
            <input type="hidden" name="action" value="filter_make">
            <input type="hidden" name="sort" value="<?= h($sort) ?>">
            <label for="make_id">Make</label>
            <select id="make_id" name="make_id" required>
                <option value="">Select make</option>
                <?php foreach ($makes as $make): ?>
                    <option value="<?= (int) $make['make_id'] ?>" <?= $make_id === (int) $make['make_id'] ? 'selected' : '' ?>>
                        <?= h($make['make_name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <button type="submit">Apply</button>
        </form>
    </article>

    <article class="panel">
        <h3>Filter by Type</h3>
        <form method="get" action=".">
            <input type="hidden" name="action" value="filter_type">
            <input type="hidden" name="sort" value="<?= h($sort) ?>">
            <label for="type_id">Type</label>
            <select id="type_id" name="type_id" required>
                <option value="">Select type</option>
                <?php foreach ($types as $type): ?>
                    <option value="<?= (int) $type['type_id'] ?>" <?= $type_id === (int) $type['type_id'] ? 'selected' : '' ?>>
                        <?= h($type['type_name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <button type="submit">Apply</button>
        </form>
    </article>

    <article class="panel">
        <h3>Filter by Class</h3>
        <form method="get" action=".">
            <input type="hidden" name="action" value="filter_class">
            <input type="hidden" name="sort" value="<?= h($sort) ?>">
            <label for="class_id">Class</label>
            <select id="class_id" name="class_id" required>
                <option value="">Select class</option>
                <?php foreach ($classes as $class): ?>
                    <option value="<?= (int) $class['class_id'] ?>" <?= $class_id === (int) $class['class_id'] ? 'selected' : '' ?>>
                        <?= h($class['class_name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <button type="submit">Apply</button>
        </form>
    </article>
</section>

<section class="panel">
    <h3>Combined Filter</h3>
    <form class="combined-form" method="get" action=".">
        <input type="hidden" name="action" value="filter_combined">
        <input type="hidden" name="sort" value="<?= h($sort) ?>">

        <div>
            <label for="combined_make_id">Make</label>
            <select id="combined_make_id" name="make_id">
                <option value="">Any Make</option>
                <?php foreach ($makes as $make): ?>
                    <option value="<?= (int) $make['make_id'] ?>" <?= $make_id === (int) $make['make_id'] ? 'selected' : '' ?>>
                        <?= h($make['make_name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div>
            <label for="combined_type_id">Type</label>
            <select id="combined_type_id" name="type_id">
                <option value="">Any Type</option>
                <?php foreach ($types as $type): ?>
                    <option value="<?= (int) $type['type_id'] ?>" <?= $type_id === (int) $type['type_id'] ? 'selected' : '' ?>>
                        <?= h($type['type_name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div>
            <label for="combined_class_id">Class</label>
            <select id="combined_class_id" name="class_id">
                <option value="">Any Class</option>
                <?php foreach ($classes as $class): ?>
                    <option value="<?= (int) $class['class_id'] ?>" <?= $class_id === (int) $class['class_id'] ? 'selected' : '' ?>>
                        <?= h($class['class_name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="combined-actions">
            <button type="submit">Apply Combined Filter</button>
            <a class="btn" href=".?action=list_vehicles&amp;sort=<?= h($sort) ?>">Reset</a>
        </div>
    </form>
</section>

<section class="vehicle-grid">
    <?php if (!empty($vehicles)): ?>
        <?php foreach ($vehicles as $vehicle): ?>
            <article class="vehicle-card">
                <p class="vehicle-year"><?= h($vehicle['year']) ?></p>
                <h4><?= h($vehicle['model']) ?></h4>
                <p class="vehicle-meta">
                    <?= h($vehicle['make_name'] ?? 'Unknown Make') ?>
                    | <?= h($vehicle['type_name'] ?? 'Unknown Type') ?>
                    | <?= h($vehicle['class_name'] ?? 'Unknown Class') ?>
                </p>
                <p class="vehicle-price">$<?= number_format((float) $vehicle['price'], 2) ?></p>
            </article>
        <?php endforeach; ?>
    <?php else: ?>
        <article class="panel">
            <p>No vehicles match the selected criteria.</p>
        </article>
    <?php endif; ?>
</section>

<?php include __DIR__ . '/footer.php'; ?>