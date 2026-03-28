<?php
require_once __DIR__ . '/../../model/vehicles_db.php';
require_once __DIR__ . '/../../model/makes_db.php';
require_once __DIR__ . '/../../model/types_db.php';
require_once __DIR__ . '/../../model/classes_db.php';

function admin_list_vehicles_controller(string $action, string $sort): void
{
    $page_title = 'Admin | Vehicle Inventory';
    $vehicles = get_vehicles($sort);
    include __DIR__ . '/../view/vehicle_admin_list.php';
}

function admin_delete_vehicle_controller(?int $vehicle_id, string $sort): void
{
    if (!$vehicle_id) {
        throw new InvalidArgumentException('Missing vehicle ID.');
    }

    delete_vehicle($vehicle_id);
    header('Location: .?action=list_vehicles&sort=' . urlencode($sort));
    exit();
}

function admin_show_add_vehicle_controller(string $action): void
{
    $page_title = 'Admin | Add Vehicle';
    $makes = get_makes();
    $types = get_types();
    $classes = get_classes();
    include __DIR__ . '/../view/add_vehicle.php';
}

function admin_add_vehicle_controller(?int $year, string $model, $price, ?int $make_id, ?int $type_id, ?int $class_id): void
{
    if (!$year || $year < 1900 || $year > 2100) {
        throw new InvalidArgumentException('Year must be a valid 4-digit number.');
    }

    if ($model === '') {
        throw new InvalidArgumentException('Model cannot be empty.');
    }

    if ($price === false || $price <= 0) {
        throw new InvalidArgumentException('Price must be greater than 0.');
    }

    if (!$make_id || !$type_id || !$class_id) {
        throw new InvalidArgumentException('Make, Type, and Class are required.');
    }

    add_vehicle($year, $model, (float) $price, $make_id, $type_id, $class_id);
    header('Location: .?action=list_vehicles');
    exit();
}
