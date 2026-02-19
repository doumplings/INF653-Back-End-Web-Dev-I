<main>
    <?php 
    

function generateMathTable($number, $operation) {
    $cards="";
    for($i=1; $i<=12; $i++){
        switch ($operation) {
            case "add":
                $result = $number + $i;
                $symbol = "+";
                break;
            case "subtract":
                $result = $number - $i;
                $symbol = "-";
                break;
            case "divide":
                $result = number_format($number / $i, 2);
                $symbol = "/";
                break;
            default:
                $result = $number * $i;
                $symbol = "*";
                break;
        }
        $cards .=
        "<div class='card-inner' >
        <div class='card-front'>{$number} {$symbol} {$i}</div>
        <div class='card-back'> {$result} </div>
        </div>";
    }
    return $cards;
}
    
echo "<div class='main-results'>" . generateMathTable($number, $operation) . "</div>";
    ?>
</main>