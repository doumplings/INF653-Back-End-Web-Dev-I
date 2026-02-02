<?php
$a =5 ;
$b = "5" ;

echo "<pre>";
echo "a = 5 (int) \n";
echo "b= \"5\" (string) \n\n";

echo "a == b => ". (($a == $b)) ? "true": "false". "(loose comparison) \n";
echo "a === b => ". (($a === $b)) ? "true": "false". "(strict comparison) \n";

echo "<pre>";

?>