<?php
require_once __DIR__ . '/../../model/makes_db.php';

function admin_list_makes_controller(string $action): void
{
    $page_title = 'Admin | Manage Makes';
    $makes = get_makes();
    include __DIR__ . '/../view/make_list.php';
}

function admin_add_make_controller(string $make_name): void
{
    if ($make_name === '') {
        throw new InvalidArgumentException('Make name cannot be empty.');
    }

    add_make($make_name);
    header('Location: .?action=list_makes');
    exit();
}

function admin_delete_make_controller(?int $make_id): void
{
    if ($make_id === null) {
        throw new InvalidArgumentException('Missing make ID.');
    }

    if ($make_id < 0) {
        throw new InvalidArgumentException('Invalid make ID.');
    }

    try {
        delete_make($make_id);
    } catch (PDOException $e) {
        if (($e->errorInfo[1] ?? null) === 1451) {
            throw new RuntimeException('Cannot delete this make because one or more vehicles still use it. Remove or update those vehicles first.');
        }
        throw $e;
    }

    header('Location: .?action=list_makes');
    exit();
}
