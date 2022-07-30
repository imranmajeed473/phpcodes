<?php
/*https://www.php.net/manual/en/language.types.string.php*/
/* ${juice}s */
$juice = "apple";
echo "He drank some $juice juice.".PHP_EOL;
// Invalid. "s" is a valid character for a variable name, but the variable is $juice.
echo "He drank some juice made of $juices.";
// Valid. Explicitly specify the end of the variable name by enclosing it in braces:
echo "He drank some juice made of ${juice}s.";
/*
He drank some apple juice.
He drank some juice made of .
He drank some juice made of apples.
*/
?>
