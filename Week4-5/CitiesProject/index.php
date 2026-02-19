<?php
require_once("model/city_db.php");

//GET Id
$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

//POST Data 
$newCity = filter_input(INPUT_POST, 'newCity', FILTER_UNSAFE_RAW);
$countryCode = filter_input(INPUT_POST, 'countryCode', FILTER_UNSAFE_RAW);
$district = filter_input(INPUT_POST, 'district', FILTER_UNSAFE_RAW);
$population = filter_input(INPUT_POST, 'population', FILTER_UNSAFE_RAW);

//Get Data
$city = filter_input(INPUT_GET, 'city', FILTER_UNSAFE_RAW);
$action = filter_input(INPUT_GET, 'action', FILTER_UNSAFE_RAW)
    ?? filter_input(INPUT_POST, 'action', FILTER_UNSAFE_RAW)
    ?? "create_read_form";

switch ($action) {
    case "select":
        if ($city) {
            $results = select_city_by_name($city);
            include("view/update_delete_form.php");
        } else {
            $error_message = "Invalid city data. Check all the fields.";
            include("view/error.php");
        }
        break;
    case "insert":
        if ($newCity && $countryCode && $district && $population) {
            $count = insert_city($newCity, $countryCode, $district, $population);
            if ($count) {
                $success_message = "City inserted successfully. <br>";
                header("Location: .?action=select&city=" . urlencode($newCity) . "&created=$count");
                exit();
            } else {
                echo "Insert failed.";
            }
        } else {
            $error_message = "Invalid city data. Check all the fields.";
            include("view/error.php");
        }
        break;
    case "update":
        if ($id && $newCity && $countryCode && $district && $population) {
            $count = update_city($id, $newCity, $countryCode, $district, $population);
            if ($count) {
                $success_message = "City updated successfully. <br>";
                header("Location: .?action=select&city=" . urlencode($newCity) . "&updated=$count");
                exit();
            } else {
                echo "Update failed.";
            }
        } else {
            $error_message = "Invalid city data. Check all the fields.";
            include("view/error.php");
        }
        break;
    case "delete":
        if ($id) {
            $count = delete_city($id);
            if ($count) {
                $success_message = "City deleted successfully. <br>";
                header("Location: .?action=create_read_form&deleted=$count");
                exit();
            } else {
                echo "Delete failed.";
            }
        } else {
            $error_message = "Invalid city data. Check all the fields.";
            include("view/error.php");
        }
        break;
    default:
        include("view/create_read_form.php");
}




?>