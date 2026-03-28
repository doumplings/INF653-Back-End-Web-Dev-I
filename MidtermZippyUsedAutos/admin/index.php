<?php
require_once __DIR__ . '/controllers/vehicles.php';
require_once __DIR__ . '/controllers/makes.php';
require_once __DIR__ . '/controllers/types.php';
require_once __DIR__ . '/controllers/classes.php';

function request_admin_int(string $name): ?int
{
    $value = filter_input(INPUT_POST, $name, FILTER_VALIDATE_INT);
    if ($value === null || $value === false) {
        $value = filter_input(INPUT_GET, $name, FILTER_VALIDATE_INT);
    }

    // Some PHP setups can return null from filter_input for valid posted values.
    if ($value === null || $value === false) {
        if (isset($_POST[$name])) {
            $value = filter_var($_POST[$name], FILTER_VALIDATE_INT);
        } elseif (isset($_GET[$name])) {
            $value = filter_var($_GET[$name], FILTER_VALIDATE_INT);
        }
    }

    if ($value === null || $value === false) {
        return null;
    }

    return (int) $value;
}

function request_admin_string(string $name): string
{
    $value = filter_input(INPUT_POST, $name, FILTER_UNSAFE_RAW);
    return trim((string) $value);
}

$action = filter_input(INPUT_POST, 'action', FILTER_UNSAFE_RAW);
if ($action === null) {
    $action = filter_input(INPUT_GET, 'action', FILTER_UNSAFE_RAW);
}
if ($action === null) {
    $action = 'list_vehicles';
}

$sort_input = filter_input(INPUT_GET, 'sort', FILTER_UNSAFE_RAW);
if ($sort_input === null) {
    $sort_input = filter_input(INPUT_POST, 'sort', FILTER_UNSAFE_RAW);
}
$sort = $sort_input === 'year' ? 'year' : 'price';

$vehicle_id = request_admin_int('vehicle_id');
$make_id = request_admin_int('make_id');
$type_id = request_admin_int('type_id');
$class_id = request_admin_int('class_id');

$make_name = request_admin_string('make_name');
$type_name = request_admin_string('type_name');
$class_name = request_admin_string('class_name');
$model = request_admin_string('model');

$year = request_admin_int('year');
$price = filter_input(INPUT_POST, 'price', FILTER_VALIDATE_FLOAT);

try {
    switch ($action) {
        case 'delete_vehicle':
            admin_delete_vehicle_controller($vehicle_id, $sort);
            break;

        case 'list_makes':
            admin_list_makes_controller($action);
            break;

        case 'add_make':
            admin_add_make_controller($make_name);
            break;

        case 'delete_make':
            admin_delete_make_controller($make_id);
            break;

        case 'list_types':
            admin_list_types_controller($action);
            break;

        case 'add_type':
            admin_add_type_controller($type_name);
            break;

        case 'delete_type':
            admin_delete_type_controller($type_id);
            break;

        case 'list_classes':
            admin_list_classes_controller($action);
            break;

        case 'add_class':
            admin_add_class_controller($class_name);
            break;

        case 'delete_class':
            admin_delete_class_controller($class_id);
            break;

        case 'show_add_vehicle':
            admin_show_add_vehicle_controller($action);
            break;

        case 'add_vehicle':
            admin_add_vehicle_controller($year, $model, $price, $make_id, $type_id, $class_id);
            break;

        case 'list_vehicles':
        default:
            admin_list_vehicles_controller($action, $sort);
            break;
    }
} catch (Throwable $e) {
    $error = $e->getMessage();
    $page_title = 'Admin Error';
    include __DIR__ . '/view/error.php';
    exit();
}
