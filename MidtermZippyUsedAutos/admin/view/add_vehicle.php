<?php include __DIR__ . '/header.php'; ?>

<section class="panel">
    <h2>Add New Vehicle</h2>
    <form class="vehicle-form" method="post" action=".">
        <input type="hidden" name="action" value="add_vehicle">

        <div>
            <label for="year">Year</label>
            <input id="year" type="number" name="year" min="1900" max="2100" required>
        </div>

        <div>
            <label for="model">Model</label>
            <input id="model" type="text" name="model" maxlength="100" required>
        </div>

        <div>
            <label for="price">Price</label>
            <input id="price" type="number" name="price" step="0.01" min="0.01" required>
        </div>

        <div>
            <label for="make_id">Make</label>
            <select id="make_id" name="make_id" required>
                <option value="">Select make</option>
                <?php foreach ($makes as $make): ?>
                    <option value="<?= (int) $make['make_id'] ?>"><?= h($make['make_name']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div>
            <label for="type_id">Type</label>
            <select id="type_id" name="type_id" required>
                <option value="">Select type</option>
                <?php foreach ($types as $type): ?>
                    <option value="<?= (int) $type['type_id'] ?>"><?= h($type['type_name']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div>
            <label for="class_id">Class</label>
            <select id="class_id" name="class_id" required>
                <option value="">Select class</option>
                <?php foreach ($classes as $class): ?>
                    <option value="<?= (int) $class['class_id'] ?>"><?= h($class['class_name']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <button type="submit">Save Vehicle</button>
    </form>
</section>

<?php include __DIR__ . '/footer.php'; ?>