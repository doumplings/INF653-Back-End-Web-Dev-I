<?php include("database.php");

function select_city_by_name($city)
{
    global $db;

    try {
        $query = 'SELECT * FROM city WHERE Name = :city ORDER BY Population DESC';
        $statement = $db->prepare($query);
        $statement->bindValue(':city', $city);
        $statement->execute();
        $results = $statement->fetchAll();
        $statement->closeCursor();
        return $results;
    } catch (PDOException $e) {
        error_log("Select Error: " . $e->getMessage());
        return [];
    }
}

function insert_city($city, $countryCode, $district, $population)
{
    global $db;

    try {
        $query = 'INSERT INTO city 
        (Name, CountryCode, District, Population) 
        VALUES (:newCity, :countryCode, :district, :population)';
        $statement = $db->prepare($query);
        $statement->bindValue(':newCity', $city);
        $statement->bindValue(':countryCode', $countryCode);
        $statement->bindValue(':district', $district);
        $statement->bindValue(':population', $population);
        $success = $statement->execute();
        $statement->closeCursor();
        if ($success) {
            echo "<p> City $city inserted successfully! </p>";
        } else {
            echo "<p> Error inserting city $city </p>";
        }
        return $success ? $statement->rowCount() : 0;
    } catch (PDOException $e) {
        error_log("Insert Error: " . $e->getMessage());
    }
}

function update_city($id, $city, $countryCode, $district, $population)
{
    global $db;
    try {
        $query = 'UPDATE city SET Name = :city, CountryCode = :countryCode, District = :district, Population = :population 
    WHERE ID = :id';
        $statement = $db->prepare($query);
        $statement->bindValue(':city', $city);
        $statement->bindValue(':countryCode', $countryCode);
        $statement->bindValue(':district', $district);
        $statement->bindValue(':population', $population);
        $statement->bindValue(':id', $id);
        $success = $statement->execute();
        $statement->closeCursor();
        if ($success) {
            echo "<p> City $city updated successfully! </p>";
        } else {
            echo "<p> Error updating city $city </p>";
        }
        return $success ? $statement->rowCount() : 0;
    } catch (PDOException $e) {
        error_log("Update Error: " . $e->getMessage());
    }
}

function delete_city($id)
{
    global $db;
    try {
        $query = 'DELETE FROM city WHERE ID = :id';
        $statement = $db->prepare($query);
        $statement->bindValue(':id', $id);
        $success = $statement->execute();
        $statement->closeCursor();
        if ($success) {
            echo "<p> City with ID $id deleted successfully! </p>";
        } else {
            echo "<p> Error deleting city with ID $id </p>";
        }
        return $success ? $statement->rowCount() : 0;
    } catch (PDOException $e) {
        error_log("Delete Error: " . $e->getMessage());
        return [];
    }
}
?>