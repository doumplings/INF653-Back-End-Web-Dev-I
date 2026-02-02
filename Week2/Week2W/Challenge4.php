<?php

$input = 85;

echo "<pre>";
echo "Input: $input \n\n";
if ($input >= 90 && $input <= 100) {
    echo "Output: You got a A!";
} elseif ($input >= 80 && $input < 90) {
    echo "Output: You got a B!";
} elseif ($input >= 70 && $input < 80) {
    echo "Output: You got a C!";
} elseif ($input >= 60 && $input < 70) {
    echo "Output: You got a D!";
} else {
    echo "Output: You got a F!"; 
} 
?>