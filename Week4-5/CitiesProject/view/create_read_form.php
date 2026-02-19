<?php include("header.php"); ?>
<section>
    <h2>Select Data / Read Data</h2>
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="GET">
        <input type="hidden" name="action" value="select">
        <label for="city">City: </label>
        <input type="text" name="city" id="city" required>
        <button type="submit">Submit</button>
    </form>
</section>
<section>
    <h2>Insert Data / Create Data</h2>
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST">
        <input type="hidden" name="action" value="insert">
        <label for="newCity">City: </label>
        <input type="text" name="newCity" id="newCity" required>
        <label for="countryCode">Country Code: </label>
        <input type="text" name="countryCode" id="countryCode" required>
        <label for="district">District: </label>
        <input type="text" name="district" id="district" required>
        <label for="population">Population: </label>
        <input type="number" name="population" id="population" required>
        <button type="submit">Submit</button>
    </form>
</section>
<?php include("footer.php"); ?>