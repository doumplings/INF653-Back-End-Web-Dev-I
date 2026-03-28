<?php
require_once __DIR__ . '/database.php';

function get_types(): array
{
    global $db;

    $query = 'SELECT ty.type_id,
                     ty.type_name,
                     COUNT(v.vehicle_id) AS vehicle_count
              FROM types ty
              LEFT JOIN vehicles v ON v.type_id = ty.type_id
              GROUP BY ty.type_id, ty.type_name
              ORDER BY ty.type_name';
    $statement = $db->prepare($query);
    $statement->execute();
    $types = $statement->fetchAll();
    $statement->closeCursor();

    return $types;
}

function add_type(string $type_name): void
{
    global $db;

    $next_id_query = 'SELECT COALESCE(MAX(type_id), 0) + 1 AS next_id FROM types';
    $next_id_statement = $db->prepare($next_id_query);
    $next_id_statement->execute();
    $next_id = (int) $next_id_statement->fetchColumn();
    $next_id_statement->closeCursor();

    $query = 'INSERT INTO types (type_id, type_name) VALUES (:type_id, :type_name)';
    $statement = $db->prepare($query);
    $statement->bindValue(':type_id', $next_id, PDO::PARAM_INT);
    $statement->bindValue(':type_name', $type_name, PDO::PARAM_STR);
    $statement->execute();
    $statement->closeCursor();
}

function delete_type(int $type_id): void
{
    global $db;

    $query = 'DELETE FROM types WHERE type_id = :type_id';
    $statement = $db->prepare($query);
    $statement->bindValue(':type_id', $type_id, PDO::PARAM_INT);
    $statement->execute();
    $statement->closeCursor();
}
