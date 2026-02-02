<?php

$input = 2024;

echo "<pre>";
echo "Input: $input \n\n";
if (($input % 4 == 0 && $input % 100 != 0) || ($input % 400 == 0)) {
    echo "Output: $input is a leap year.";
} else {
    echo "Output: $input is not a leap year.";
}
?>