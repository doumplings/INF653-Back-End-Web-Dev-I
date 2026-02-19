<?php
require('database.php');

$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
$city = filter_input(INPUT_POST, 'city', FILTER_UNSAFE_RAW);
$countryCode = filter_input(INPUT_POST, 'countryCode', FILTER_UNSAFE_RAW);
$district = filter_input(INPUT_POST, 'district', FILTER_UNSAFE_RAW);
$population = filter_input(INPUT_POST, 'population', FILTER_UNSAFE_RAW);

if ($id) {
    $query = 'UPDATE city SET Name = :city, CountryCode = :countryCode, District = :district, Population = :population 
    WHERE ID = :id';
    $statement = $db->prepare($query);
    $statement->bindValue(':city', $city);
    $statement->bindValue(':countryCode', $countryCode);
    $statement->bindValue(':district', $district);
    $statement->bindValue(':population', $population);
    $statement->bindValue(':id', $id);
    $statement->execute();
    $statement->closeCursor();
}

$updated = true;
include('index.php');
?>