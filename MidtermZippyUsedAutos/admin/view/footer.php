</main>
<footer class="site-footer admin-footer">
    <div class="container footer-inner footer-dynamic-links">
        <p>Admin Navigation</p>
        <?php
        $current_action = $action ?? 'list_vehicles';
        $footer_links = [
            ['action' => 'list_vehicles', 'label' => 'Vehicles'],
            ['action' => 'show_add_vehicle', 'label' => 'Add Vehicle'],
            ['action' => 'list_makes', 'label' => 'Makes'],
            ['action' => 'list_types', 'label' => 'Types'],
            ['action' => 'list_classes', 'label' => 'Classes'],
        ];
        ?>
        <nav class="footer-nav">
            <?php foreach ($footer_links as $link): ?>
                <?php if ($link['action'] !== $current_action): ?>
                    <a href=".?action=<?= htmlspecialchars($link['action'], ENT_QUOTES, 'UTF-8') ?>">
                        <?= htmlspecialchars($link['label'], ENT_QUOTES, 'UTF-8') ?>
                    </a>
                <?php endif; ?>
            <?php endforeach; ?>
            <a href="../">Public Site</a>
        </nav>
    </div>
</footer>
</body>

</html>