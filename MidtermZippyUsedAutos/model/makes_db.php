<?php
require_once __DIR__ . '/database.php';

function get_makes(): array
{
    global $db;

    $query = 'SELECT mk.make_id,
                     mk.make_name,
                     COUNT(v.vehicle_id) AS vehicle_count
              FROM makes mk
              LEFT JOIN vehicles v ON v.make_id = mk.make_id
              GROUP BY mk.make_id, mk.make_name
              ORDER BY mk.make_name';
    $statement = $db->prepare($query);
    $statement->execute();
    $makes = $statement->fetchAll();
    $statement->closeCursor();

    return $makes;
}

function add_make(string $make_name): void
{
    global $db;

    $next_id_query = 'SELECT COALESCE(MAX(make_id), 0) + 1 AS next_id FROM makes';
    $next_id_statement = $db->prepare($next_id_query);
    $next_id_statement->execute();
    $next_id = (int) $next_id_statement->fetchColumn();
    $next_id_statement->closeCursor();

    $query = 'INSERT INTO makes (make_id, make_name) VALUES (:make_id, :make_name)';
    $statement = $db->prepare($query);
    $statement->bindValue(':make_id', $next_id, PDO::PARAM_INT);
    $statement->bindValue(':make_name', $make_name, PDO::PARAM_STR);
    $statement->execute();
    $statement->closeCursor();
}

function delete_make(int $make_id): void
{
    global $db;

    $query = 'DELETE FROM makes WHERE make_id = :make_id';
    $statement = $db->prepare($query);
    $statement->bindValue(':make_id', $make_id, PDO::PARAM_INT);
    $statement->execute();
    $statement->closeCursor();
}
