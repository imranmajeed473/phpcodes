<?php 
// 	single line if
// (Condition)?(true):(false);
echo ($requestVars == '') ? $redText : ''; 

/* most basic usage */
$final = ($var > 2 ? true : false); // returns true
$final = ($var > 2 ? 22 : 0);
?>
