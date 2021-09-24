<?php
// Set error reporting to only a few things.
ini_set('error_reporting', E_ERROR ^ E_NOTICE ^ E_WARNING);
error_reporting( E_ERROR | E_PARSE | E_WARNING ) ;
ini_set('log_errors',TRUE);
ini_set('html_errors',FALSE);
ini_set( 'display_errors', '0' ) ;
// TEST
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);
require "../../configuration/settings.php";
require "../../configuration/mysql.php";
require "../../configuration/functions.php";
require_once ( '../../../core/dbsimple/Generic.php' ) ;
$script_start = microtime_float();
$realm = 0;
if(isset($_GET["dbkey"]) && isset($_GET["owned"]))
{
    $dbkey = (int) $_GET["dbkey"];
    $owned = (int) $_GET["owned"];
    foreach($realms as $key => $value)
        if($dbkey == $value[$owned])
            $realm = $key;
}
initialize_realm($realm);
require "../../configuration/".LANGUAGE."/languagearray.php";
// 2D Array Sorting - by nilesh at gmail dot com @ php.net //
function asort2d($records, $field, $reverse, $defaultSortField = 0)
{
	$uniqueSortId = 0;
	$hash = array(); $sortedRecords = array(); $tempArr = array(); $indexedArray = array(); $recordArray = array();
	foreach($records as $record)
	{
		$uniqueSortId++;
		$recordStr = implode("|", $record)."|".$uniqueSortId;
		$recordArray[] = explode("|", $recordStr);
	}
	$primarySortIndex = count($record);
	$records = $recordArray;
	foreach($records as $record)
		$hash[$record[$primarySortIndex]] = $record[$field];
	uasort($hash, "strnatcasecmp");
	if($reverse)
		$hash = array_reverse($hash, true);
	$valueCount = array_count_values($hash);
	foreach($hash as $primaryKey => $value)
		$indexedArray[] = $primaryKey;
	$i = 0;
	foreach($hash as $primaryKey => $value)
	{
		$i++;
		if($valueCount[$value] > 1)
		{
			foreach($records as $record)
			{
				if($primaryKey == $record[$primarySortIndex])
				{
					$tempArr[$record[$defaultSortField]."__".$i] = $record;
					break;
				}
			}
			$index = array_search($primaryKey, $indexedArray);
			if(($i == count($records)) || ($value != $hash[$indexedArray[$index+1]]))
			{
				uksort($tempArr, "strnatcasecmp");
				if($reverse)
					$tempArr = array_reverse($tempArr);
				foreach($tempArr as $newRecs)
					$sortedRecords [] = $newRecs;
				$tempArr = array();
			}
		}
		else
		{
			foreach($records as $record)
			{
				if($primaryKey == $record[$primarySortIndex])
				{
					$sortedRecords[] = $record;
					break;
				}
			}
		}
	}
	return $sortedRecords;
}
function ValidatePageNumber($Cur_Page, $TotalPages)
{
	if($Cur_Page > $TotalPages)
		$Cur_Page = $TotalPages;
	if($Cur_Page < 1)
		$Cur_Page = 1;
	return $Cur_Page;
}
function BuildPageButtons($Cur_Page, $TotalPages, $Main_Link, $File)
{
	$Cur_Page = ValidatePageNumber($Cur_Page, $TotalPages);
	$PageText = "";
	if($Cur_Page == 1)
		$PageText .= "<div class = \"pnav\"><ul><li><a class=\"prev-first-off\"><img src=\"images/pixel.gif\" height=\"1\" width=\"1\" /></a></li><li><a class=\"prev-off\"><img src=\"images/pixel.gif\" height=\"1\" width=\"1\" /></a></li>";
	else
	{
		$ActionRewind = $Main_Link."&page=1";
		$ActionBack =  $Main_Link."&page=".($Cur_Page - 1);
		$PageText .= "<div class = \"pnav\"><ul><li><a class=\"prev-first\" onclick=\"showResult('".$ActionRewind."', '".$File."')\"><img src=\"images/pixel.gif\" height=\"1\" width=\"1\" /></a></li><li><a class=\"prev\" onclick=\"showResult('".$ActionBack."', '".$File."')\"><img src=\"images/pixel.gif\" height=\"1\" width=\"1\" /></a></li>";
	}
	for($I = 0 ; $I < $TotalPages ; $I ++)
	{
		if(($I + 1) == ($Cur_Page))
			$PageText .= "<li><a class=\"sel\">".($I+1)."</a></li>";
		else if($I <= 8 or ($I + 1) == $TotalPages)
		{
			$ActionClick = $Main_Link."&page=".($I+1);
			$PageText .= "<li><a class=\"p\" onclick=\"showResult('".$ActionClick."', '".$File."')\">".($I+1)."</a></li>";
		}
	}
	if($Cur_Page >= $TotalPages)
		$PageText .= "<li><a class=\"next-off\"><img src=\"images/pixel.gif\" height=\"1\" width=\"1\" /></a></li><li><a class=\"next-last-off\"><img src=\"images/pixel.gif\" height=\"1\" width=\"1\" /></a></li></ul></div>";
	else
	{
		$ActionFastforward = $Main_Link."&page=".$TotalPages;
		$ActionForward =  $Main_Link."&page=".($Cur_Page+1);
		$PageText .= "<li><a class=\"next\" onclick=\"showResult('".$ActionForward."', '".$File."')\"><img src=\"images/pixel.gif\" height=\"1\" width=\"1\" /></a></li><li><a class=\"next-last\" onclick=\"showResult('".$ActionFastforward."', '".$File."')\"><img src=\"images/pixel.gif\" height=\"1\" width=\"1\" /></a></li></ul></div>";
	}
	return $PageText;
}
// for searching in db
function change_whitespace($string)
{
	return str_replace(" ", "%", $string);
}
function print_exec_time_and_memory($start_time)
{
	echo "<br /><center>Ajax generated in ",round(microtime_float() - $start_time, 4)," sec. Used amount of memory: ",memory_get_peak_usage()," Bytes</center>";
}
?>