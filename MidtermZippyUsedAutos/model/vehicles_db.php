<?php
require_once __DIR__ . '/database.php';

function get_vehicle_sort_column(string $sort): string
{
    return $sort === 'year' ? 'v.year' : 'v.price';
}

function fetch_vehicle_rows(string $whereClause, array $params, string $sort = 'price'): array
{
    global $db;

    $orderBy = get_vehicle_sort_column($sort);

    $query = "SELECT v.vehicle_id,
                     v.year,
                     v.model,
                     v.price,
                     v.make_id,
                     v.type_id,
                     v.class_id,
                     mk.make_name,
                     ty.type_name,
                     cl.class_name
              FROM vehicles v
              LEFT JOIN makes mk ON v.make_id = mk.make_id
              LEFT JOIN types ty ON v.type_id = ty.type_id
              LEFT JOIN classes cl ON v.class_id = cl.class_id
              $whereClause
              ORDER BY $orderBy DESC, v.vehicle_id DESC";

    $statement = $db->prepare($query);

    foreach ($params as $key => $value) {
        $statement->bindValue($key, $value, PDO::PARAM_INT);
    }

    $statement->execute();
    $vehicles = $statement->fetchAll();
    $statement->closeCursor();

    return $vehicles;
}

function get_vehicles(string $sort = 'price'): array
{
    return fetch_vehicle_rows('', [], $sort);
}

function get_vehicles_by_make(int $make_id, string $sort = 'price'): array
{
    return fetch_vehicle_rows('WHERE v.make_id = :make_id', [':make_id' => $make_id], $sort);
}

function get_vehicles_by_type(int $type_id, string $sort = 'price'): array
{
    return fetch_vehicle_rows('WHERE v.type_id = :type_id', [':type_id' => $type_id], $sort);
}

function get_vehicles_by_class(int $class_id, string $sort = 'price'): array
{
    return fetch_vehicle_rows('WHERE v.class_id = :class_id', [':class_id' => $class_id], $sort);
}

function get_vehicles_by_combined_filters(?int $make_id, ?int $type_id, ?int $class_id, string $sort = 'price'): array
{
    $filters = [];
    $params = [];

    if ($make_id) {
        $filters[] = 'v.make_id = :make_id';
        $params[':make_id'] = $make_id;
    }

    if ($type_id) {
        $filters[] = 'v.type_id = :type_id';
        $params[':type_id'] = $type_id;
    }

    if ($class_id) {
        $filters[] = 'v.class_id = :class_id';
        $params[':class_id'] = $class_id;
    }

    $whereClause = '';
    if (!empty($filters)) {
        $whereClause = 'WHERE ' . implode(' AND ', $filters);
    }

    return fetch_vehicle_rows($whereClause, $params, $sort);
}

function add_vehicle(int $year, string $model, float $price, int $make_id, int $type_id, int $class_id): void
{
    global $db;

    $query = 'INSERT INTO vehicles (year, model, price, make_id, type_id, class_id)
              VALUES (:year, :model, :price, :make_id, :type_id, :class_id)';
    $statement = $db->prepare($query);
    $statement->bindValue(':year', $year, PDO::PARAM_INT);
    $statement->bindValue(':model', $model, PDO::PARAM_STR);
    $statement->bindValue(':price', $price);
    $statement->bindValue(':make_id', $make_id, PDO::PARAM_INT);
    $statement->bindValue(':type_id', $type_id, PDO::PARAM_INT);
    $statement->bindValue(':class_id', $class_id, PDO::PARAM_INT);
    $statement->execute();
    $statement->closeCursor();
}

function delete_vehicle(int $vehicle_id): void
{
    global $db;

    $query = 'DELETE FROM vehicles WHERE vehicle_id = :vehicle_id';
    $statement = $db->prepare($query);
    $statement->bindValue(':vehicle_id', $vehicle_id, PDO::PARAM_INT);
    $statement->execute();
    $statement->closeCursor();
}
