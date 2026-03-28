<?php
if (!function_exists('h')) {
    function h($value): string
    {
        return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
    }
}

$current_action = $action ?? 'list_vehicles';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= h($page_title ?? 'Admin | Zippy Used Autos') ?></title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body class="admin-body">
    <header class="site-header admin-header">
        <div class="container header-inner">
            <div>
                <p class="eyebrow">Inventory Control</p>
                <h1>Zippy Used Autos Admin</h1>
            </div>
            <nav class="top-nav top-nav-admin">
                <a class="<?= $current_action === 'list_vehicles' ? 'nav-active' : '' ?>"
                    href=".?action=list_vehicles">Vehicles</a>
                <a class="<?= $current_action === 'show_add_vehicle' ? 'nav-active' : '' ?>"
                    href=".?action=show_add_vehicle">Add Vehicle</a>
                <a class="<?= $current_action === 'list_makes' ? 'nav-active' : '' ?>"
                    href=".?action=list_makes">Makes</a>
                <a class="<?= $current_action === 'list_types' ? 'nav-active' : '' ?>"
                    href=".?action=list_types">Types</a>
                <a class="<?= $current_action === 'list_classes' ? 'nav-active' : '' ?>"
                    href=".?action=list_classes">Classes</a>
                <a href="../">Public Site</a>
            </nav>
        </div>
    </header>
    <main class="container">