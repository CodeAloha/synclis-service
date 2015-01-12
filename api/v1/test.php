<?php
include('lib/tools.php');
echo gen_uuid() . "<br/>";

$res = string_to_ascii("ChrisAnonymously@gmail.com");

echo $res;

echo tobase($res);


function string_to_ascii($string)
{
    $ascii = NULL;
 
    for ($i = 0; $i < strlen($string); $i++) 
    { 
    	$ascii += ord($string[$i]); 
    }
 
    return($ascii);
}

?>