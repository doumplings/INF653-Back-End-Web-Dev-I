<?php
require_once __DIR__ . '/database.php';

function get_classes(): array
{
    global $db;

    $query = 'SELECT cl.class_id,
                     cl.class_name,
                     COUNT(v.vehicle_id) AS vehicle_count
              FROM classes cl
              LEFT JOIN vehicles v ON v.class_id = cl.class_id
              GROUP BY cl.class_id, cl.class_name
              ORDER BY cl.class_name';
    $statement = $db->prepare($query);
    $statement->execute();
    $classes = $statement->fetchAll();
    $statement->closeCursor();

    return $classes;
}

function add_class(string $class_name): void
{
    global $db;

    $next_id_query = 'SELECT COALESCE(MAX(class_id), 0) + 1 AS next_id FROM classes';
    $next_id_statement = $db->prepare($next_id_query);
    $next_id_statement->execute();
    $next_id = (int) $next_id_statement->fetchColumn();
    $next_id_statement->closeCursor();

    $query = 'INSERT INTO classes (class_id, class_name) VALUES (:class_id, :class_name)';
    $statement = $db->prepare($query);
    $statement->bindValue(':class_id', $next_id, PDO::PARAM_INT);
    $statement->bindValue(':class_name', $class_name, PDO::PARAM_STR);
    $statement->execute();
    $statement->closeCursor();
}

function delete_class(int $class_id): void
{
    global $db;

    $query = 'DELETE FROM classes WHERE class_id = :class_id';
    $statement = $db->prepare($query);
    $statement->bindValue(':class_id', $class_id, PDO::PARAM_INT);
    $statement->execute();
    $statement->closeCursor();
}
