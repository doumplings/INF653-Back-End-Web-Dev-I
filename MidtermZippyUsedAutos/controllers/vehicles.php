<?php
require_once __DIR__ . '/../model/vehicles_db.php';
require_once __DIR__ . '/../model/makes_db.php';
require_once __DIR__ . '/../model/types_db.php';
require_once __DIR__ . '/../model/classes_db.php';

function public_request_int(string $name): ?int
{
    $value = filter_input(INPUT_POST, $name, FILTER_VALIDATE_INT);
    if ($value === null || $value === false) {
        $value = filter_input(INPUT_GET, $name, FILTER_VALIDATE_INT);
    }

    return $value && $value > 0 ? $value : null;
}

function run_public_vehicle_controller(): void
{
    $action = filter_input(INPUT_POST, 'action', FILTER_UNSAFE_RAW);
    if ($action === null) {
        $action = filter_input(INPUT_GET, 'action', FILTER_UNSAFE_RAW);
    }
    if ($action === null) {
        $action = 'list_vehicles';
    }

    $sort_input = filter_input(INPUT_GET, 'sort', FILTER_UNSAFE_RAW);
    $sort = $sort_input === 'year' ? 'year' : 'price';

    $make_id = public_request_int('make_id');
    $type_id = public_request_int('type_id');
    $class_id = public_request_int('class_id');

    $makes = get_makes();
    $types = get_types();
    $classes = get_classes();

    $page_title = 'Zippy Used Autos';
    $filter_label = 'All Vehicles';

    try {
        switch ($action) {
            case 'filter_make':
                $vehicles = $make_id ? get_vehicles_by_make($make_id, $sort) : get_vehicles($sort);
                $filter_label = $make_id ? 'Filtered by Make' : 'All Vehicles';
                break;

            case 'filter_type':
                $vehicles = $type_id ? get_vehicles_by_type($type_id, $sort) : get_vehicles($sort);
                $filter_label = $type_id ? 'Filtered by Type' : 'All Vehicles';
                break;

            case 'filter_class':
                $vehicles = $class_id ? get_vehicles_by_class($class_id, $sort) : get_vehicles($sort);
                $filter_label = $class_id ? 'Filtered by Class' : 'All Vehicles';
                break;

            case 'filter_combined':
                $vehicles = get_vehicles_by_combined_filters($make_id, $type_id, $class_id, $sort);
                $filter_label = 'Combined Filters Applied';
                break;

            case 'list_vehicles':
            default:
                $vehicles = get_vehicles($sort);
                $filter_label = 'All Vehicles';
                break;
        }

        include __DIR__ . '/../view/vehicle_list.php';
    } catch (Throwable $e) {
        $error = 'A database error occurred: ' . $e->getMessage();
        include __DIR__ . '/../view/error.php';
        exit();
    }
}
