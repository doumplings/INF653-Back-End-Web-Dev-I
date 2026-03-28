<?php
require_once __DIR__ . '/../../model/classes_db.php';

function admin_list_classes_controller(string $action): void
{
    $page_title = 'Admin | Manage Classes';
    $classes = get_classes();
    include __DIR__ . '/../view/class_list.php';
}

function admin_add_class_controller(string $class_name): void
{
    if ($class_name === '') {
        throw new InvalidArgumentException('Class name cannot be empty.');
    }

    add_class($class_name);
    header('Location: .?action=list_classes');
    exit();
}

function admin_delete_class_controller(?int $class_id): void
{
    if ($class_id === null) {
        throw new InvalidArgumentException('Missing class ID.');
    }

    if ($class_id < 0) {
        throw new InvalidArgumentException('Invalid class ID.');
    }

    try {
        delete_class($class_id);
    } catch (PDOException $e) {
        if (($e->errorInfo[1] ?? null) === 1451) {
            throw new RuntimeException('Cannot delete this class because one or more vehicles still use it. Remove or update those vehicles first.');
        }
        throw $e;
    }

    header('Location: .?action=list_classes');
    exit();
}
