<?php
require_once __DIR__ . '/../../model/types_db.php';

function admin_list_types_controller(string $action): void
{
    $page_title = 'Admin | Manage Types';
    $types = get_types();
    include __DIR__ . '/../view/type_list.php';
}

function admin_add_type_controller(string $type_name): void
{
    if ($type_name === '') {
        throw new InvalidArgumentException('Type name cannot be empty.');
    }

    add_type($type_name);
    header('Location: .?action=list_types');
    exit();
}

function admin_delete_type_controller(?int $type_id): void
{
    if ($type_id === null) {
        throw new InvalidArgumentException('Missing type ID.');
    }

    if ($type_id < 0) {
        throw new InvalidArgumentException('Invalid type ID.');
    }

    try {
        delete_type($type_id);
    } catch (PDOException $e) {
        if (($e->errorInfo[1] ?? null) === 1451) {
            throw new RuntimeException('Cannot delete this type because one or more vehicles still use it. Remove or update those vehicles first.');
        }
        throw $e;
    }

    header('Location: .?action=list_types');
    exit();
}
