<?php include("header.php"); ?>
<section>
    <?php if ($results) { ?>
        <h2>City Details</h2>
        <ul>
            <?php foreach ($results as $row) { ?>
                <li><strong>ID: </strong><?php echo htmlspecialchars($row['ID']); ?></li>
                <li><strong>City: </strong><?php echo htmlspecialchars($row['Name']); ?></li>
                <li><strong>Country Code: </strong><?php echo htmlspecialchars($row['CountryCode']); ?></li>
                <li><strong>District: </strong><?php echo htmlspecialchars($row['District']); ?></li>
                <li><strong>Population: </strong><?php echo htmlspecialchars($row['Population']); ?></li>

                <h2>Update or Delete data</h2>
                <form action="update_record.php" method="post">
                    <input type="hidden" name="action" value="update">
                    <input type="hidden" name="id" value="<?php echo $row['ID']; ?>">
                    <label for="city-<?php echo $row["ID"]; ?>">City Label: </label>
                    <input type="text" id="city-<?php echo $row["ID"]; ?>" name="city"
                        value="<?php echo htmlspecialchars($row['Name']); ?>" required>
                    <label for="countryCode-<?php echo $row["ID"]; ?>">Country Code: </label>
                    <input type="text" id="countryCode-<?php echo $row["ID"]; ?>" name="countryCode"
                        value="<?php echo htmlspecialchars($row['CountryCode']); ?>" required>
                    <label for="district-<?php echo $row["ID"]; ?>">District: </label>
                    <input type="text" id="district-<?php echo $row["ID"]; ?>" name="district"
                        value="<?php echo htmlspecialchars($row['District']); ?>" required>
                    <label for="population-<?php echo $row["ID"]; ?>">Population: </label>
                    <input type="number" id="population-<?php echo $row["ID"]; ?>" name="population"
                        value="<?php echo htmlspecialchars($row['Population']); ?>" required>
                    <button type="submit">Update</button>
                </form>
                <form action="delete_record.php" method="post" class="delete">
                    <input type="hidden" name="action" value="delete">
                    <input type="hidden" name="id" value="<?php echo $row['ID']; ?>">
                    <button type="submit">Delete</button>
                </form>
            <?php } ?>
        </ul>
    </section>
<?php } else { ?>
    <p>No city found with the name "<?php echo htmlspecialchars($city); ?>".</p>
<?php } ?>
<?php include("footer.php"); ?>