<main>
    <h2 id="enterNumber"> Enter a number </h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="GET" class="main-entry_form">
        <input type="text" class="input-box" id="num" name="num" maxlength="2" required>
        <select name="operation" id="operation" class="main-entry__select">
            <option value="multiply">Multiplication</option>
            <option value="add">Addition</option>
            <option value="subtract">Subtraction</option>
            <option value="division">Division</option>
        </select>
        <button class="main-entry" >Go!</button>
    </form>
</main>