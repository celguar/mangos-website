<?php
/*
 *  Released under the terms of GPL Version 3.
 *
 *  File created by Peec.
 *
 *  Files hence is to create AUTOMATED defines out of the mangos update fields.
 *
 *  This file is NOT made for beeing quick as it uses explodes here and there.. This is however a good tool to extract
 *  the newest update fields into a PHP script :)
 */


$str ='';
$rows = file("scripts/UpdateFields.h");
$myFile = "UpdateFields.php";
$fh = fopen($myFile, 'w');
fwrite($fh, "<?php\n\n\n\n\n");

//fwrite($fh, "\$mangos_field = array(");
fclose($fh);
$fh = fopen($myFile, 'a');


// STEP 1 - Browsing every line

// First we need to surf to each rows. Lets filter some data and some not.
foreach($rows as $row){

    // Filter Data.

    // We do not wany any coments at all in our files.
    if (strstr($row, '/*') == TRUE){
        $exclude = 1;
    }elseif(strstr($row, '*/') == TRUE){
        $exclude = 2;
    }elseif($exclude == 2){
        $exclude = 0;
    }
    elseif($exclude == 1){

    }
    // Also exclude comments with #
    elseif(strstr($row, '#')){
    }
    // Not exclude whole lines with // but exclude after // is inizalized.
    elseif(strstr($row, '//')){
        $ar = explode('//',$row);
        if ($ar['0'] != ''){
        $str .= $ar['0'];

        }
    }elseif($row == "\n"){
    }
    // We could make use of enum define.. Well not now.
    elseif(strstr($row, 'enum')){

    }
    // If we feel that everyhting is OK, lets go ahead.
    else{
        $o = str_replace("\r","",$row);
        $str .= str_replace("\n","",$o);
    }
}


//STEP 2 - Find the fields and filter all unused and bad data away.

$array = explode('{', $str);
foreach($array as $value){

    $var = explode('};', $value);
        $z = str_replace('\n','',$var[0]);
        $z = str_replace('\r','',$z);
        $out .= str_replace(' ','',$z);
}

// Step 3 - Find the inizalizer and the value of the define. Write to file if its a clean int
$ar = explode(',', $out);

$i = 0;
foreach($ar as $row){
    $regn = explode('=', $row);
    if (is_numeric($regn[1]) == TRUE){
        $regn[0] = str_replace("\n", "", $regn[0]);
        $regn[0] = str_replace("'\r", "", $regn[0]);
        $op = "\$mangos_field['".$regn[0]."'] = ".hexdec($regn[1]).";\n";
        fwrite($fh, $op);
    }else{
        $neednew[$i][0] = str_replace("\n", "",$regn[0]);
        $neednew[$i][1] = $regn[1];
        //echo $regn[0]." = ".intval($regn[1])."<br>";
        $i++;
    }
}

// Step 4 - Write rows that is independednt of the other values above.
foreach($neednew as $row){
    if ($row[0] == '' || $row[1] == ''){}else{
    $calc = explode('+', $row[1]);
    $op = "\$mangos_field['".$row[0]."'] = \$mangos_field['".$calc[0]."']+".hexdec(trim($calc[1])).";\n";
    fwrite($fh, $op);
    }
}
//fwrite($fh, "\n\n);\n\n");
fwrite($fh, "\n\n\n\n");
$op = "\n\n\n?>";
fwrite($fh, $op);
fclose($fh);
?>


