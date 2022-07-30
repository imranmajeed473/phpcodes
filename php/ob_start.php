<?php 
/*
There are two other functions you typically pair it with: ob_get_contents(), which basically gives you whatever has been "saved" to the buffer since it was turned on with ob_start(), and then ob_end_clean() or ob_flush(), which either stops saving things and discards whatever was saved, or stops saving and outputs it all at once, respectively.
*/
function start_remembering_everything( ) 
  { 
    $lvs_html  = "<div>01 - component header</div>" ; // <table ><tr>" ;

        ob_start();
        include( "component_contents.php" ) ;
    $lvs_html .= ob_get_clean();

    $lvs_html .= "<div>03 - component footer</div>" ; // </tr></table>" ;

    return $lvs_html ;
  } ;
?><?php 
ob_start();
echo("Hello there!"); //would normally get printed to the screen/output to browser
$output = ob_get_contents();
ob_end_clean();
 ?>