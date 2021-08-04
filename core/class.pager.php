<?php
define("METHOD_PAGE_NUM",0);
define("METHOD_RECORD_COUNT",1);

define("DISPLAY_PAGE_NUMBERS",0);
define("DISPLAY_RECORDS_RANGE",1);

/**
 * Replace function http_build_query()
 *
 * @category    PHP
 * @package     PHP_Compat
 * @link        http://php.net/function.http-build-query
 * @author      Stephan Schmidt <schst@php.net>
 * @author      Aidan Lister <aidan@php.net>
 * @version     $Revision: 1.14 $
 * @since       PHP 5
 * @require     PHP 4.0.1 (trigger_error)
 */
if (!function_exists('http_build_query')) {
    function http_build_query($formdata, $numeric_prefix = null)
    {
        // If $formdata is an object, convert it to an array
        if (is_object($formdata)) {
            $formdata = get_object_vars($formdata);
        }

        // Check we have an array to work with
        if (!is_array($formdata)) {
            trigger_error('http_build_query() Parameter 1 expected to be Array or Object. Incorrect value given.', E_USER_WARNING);
            return false;
        }

        // If the array is empty, return null
        if (empty($formdata)) {
            return;
        }

        // Argument seperator
        $separator = ini_get('arg_separator.output');

        // Start building the query
        $tmp = array ();
        foreach ($formdata as $key => $val) {
            if (is_integer($key) && $numeric_prefix != null) {
                $key = $numeric_prefix . $key;
            }

            if (is_scalar($val)) {
                array_push($tmp, urlencode($key).'='.urlencode($val));
                continue;
            }

            // If the value is an array, recursively parse it
            if (is_array($val)) {
                array_push($tmp, __http_build_query($val, urlencode($key)));
                continue;
            }
        }

        return implode($separator, $tmp);
    }

    // Helper function
    function __http_build_query ($array, $name)
    {
        $tmp = array ();
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                array_push($tmp, __http_build_query($value, sprintf('%s[%s]', $name, $key)));
            } elseif (is_scalar($value)) {
                array_push($tmp, sprintf('%s[%s]=%s', $name, urlencode($key), urlencode($value)));
            } elseif (is_object($value)) {
                array_push($tmp, __http_build_query(get_object_vars($value), sprintf('%s[%s]', $name, $key)));
            }
        }

        // Argument seperator
        $separator = ini_get('arg_separator.output');

        return implode($separator, $tmp);
    }
}

class pagerHtmlRenderer
{
  var $pager = NULL;

  //page naming method -- page number or record range
  var $pageNamingMethod   = DISPLAY_PAGE_NUMBERS;

  function pagerHtmlRenderer($pageNamingMethod = DISPLAY_PAGE_NUMBERS)
  {
    $this->pageNamingMethod = $pageNamingMethod;
  }

  function _getPageNumberTitle($number)
  {
    switch ($this->pageNamingMethod)
    {
      case DISPLAY_PAGE_NUMBERS:
        return $number+1;
        break;
      case DISPLAY_RECORDS_RANGE:
        $end = ($number+1) * $this->pager->pageSize;
        if ($end > $this->pager->recordsCount) $end = $this->pager->recordsCount;
        return ($number * $this->pager->pageSize + 1)."-".$end;
        break;
      default:
        return $number+1;
        break;
    }
  }

  function setPager($pager)
  {
    $this->pager = $pager;
  }

  function render()
  {
    $list = $this->pager->getPagesList();
    $result = "";

    foreach ($list as $page)
    {
      if ($page["is_dots"] == true) $name = "...";
      elseif ($page["is_next"] == true) $name = "next";
      elseif ($page["is_prev"] == true) $name = "prev";
      else $name = $this->_getPageNumberTitle($page["num"]);

      if (!$page["is_cur"])
        $result .= "<a href=".$page["url"].">".$name."</a>&nbsp;";
      else
        $result .= "[".$name."]&nbsp;";
    }

    return $result;
  }
}

class Pager2
{
  var $recordsCount = NULL;
  var $pageSize     = NULL;
  var $pagesCount   = NULL;
  var $pageVarName  = "start";
  var $currentPage  = 0;

  //array with pages list
  var $pagesList    = array();

  //number of page links on one window
  var $delta        = 10;

  //page ident method - first record or page number
  var $pageIdentMethod    = METHOD_PAGE_NUM;

  var $enableCacheRemover = false;

  //show X first pages in list (always)
  var $firstPagesCnt      = 3;

  //show X last pages in list (always)
  var $lastPagesCnt       = 3;

  //show link to previous page
  var $showPrevLink = true;

  //show link to next page
  var $showNextLink = true;

  //renderer class
  var $renderer = NULL;

  function Pager2($records_count, $page_size, $renderer = NULL)
  {
    $this->recordsCount = $records_count;
    $this->pageSize     = $page_size;
    $this->renderer     = $renderer;

    $this->calculatePagesCount();
  }

  function setPageIdentMethod($method)
  {
    $this->pageIdentMethod = $method;
  }

  function setPageVarName($varName)
  {
    $this->pageVarName = $varName;
    if (isset($_REQUEST[$varName])) $this->setCurrentPage($_REQUEST[$varName]);
  }

  function setCurrentPage($page = 0)
  {
    $page = (int)$page;
    if ($this->pageIdentMethod == METHOD_RECORD_COUNT) $page = ceil($page/$this->pageSize);
    if ($page < 0) $page = 0;
    if ($page > $this->pagesCount) $page = $this->pagesCount;
    $this->currentPage = $page;
  }

  function setDelta($delta)
  {
    $this->delta = $delta;
  }

  function setFirstPagesCnt($cnt)
  {
    $this->firstPagesCnt = $cnt;
  }

  function setLastPagesCnt($cnt)
  {
    $this->lastPagesCnt = $cnt;
  }

  function calculatePagesCount()
  {
    $this->pagesCount = floor($this->recordsCount/$this->pageSize);
    if (0 == $this->recordsCount % $this->pageSize) $this->pagesCount--;
  }


  function _createPageUrl($pageNumber)
  {
    static $cc = 0;
    $cc++;

    $tmp = $_GET;
    if ($this->pageIdentMethod == METHOD_RECORD_COUNT) $pageNumber *= $this->pageSize;

    $tmp = array_merge($tmp, array($this->pageVarName => $pageNumber));
    if ($this->enableCacheRemover)
    {
      srand(time() + $cc);
      $tmp = array_merge($tmp,array("__rand" => mt_rand(0,100000)));
    }

    return basename($_SERVER["PHP_SELF"])."?".http_build_query($tmp);
  }

  function _getStartPage()
  {
    $_startPage = $this->currentPage - round($this->delta/2);
    if ($_startPage < 0) $_startPage = 0;
    return $_startPage;
  }

  function _getEndPage()
  {
    $_endPage = $this->currentPage + round($this->delta/2);
    if ($_endPage > $this->pagesCount) $_endPage = $this->pagesCount;
    return $_endPage;
  }

  function addPageToList($num,
                         $is_prev = false,
                         $is_next = false,
                         $is_dots = false)
  {
    $this->pagesList[] = array(
                        "num"       => $num,
                        "url"       => $this->_createPageUrl($num),
                        "is_prev"   => $is_prev,
                        "is_next"   => $is_next,
                        "is_dots"   => $is_dots,
                        "is_cur"    => $num == $this->currentPage,


    );
  }

  function getPagesList()
  {
    $startPage = $this->_getStartPage();
    $endPage   = $this->_getEndPage();

    //add link to previous page to list
    if ($this->currentPage != 0 && $this->showPrevLink)
    {
      $this -> addPageToList($this->currentPage-1, true);
    }

    //add links to X first pages
    for ($i = 0; $i < min($this->firstPagesCnt,$startPage) ; $i++)
    {
      $this -> addPageToList($i);
    }

    //add link to middle page between start and main links
    if ($startPage > $this->firstPagesCnt && $this->firstPagesCnt != 0)
    {
      $this -> addPageToList(floor(($this->firstPagesCnt+$startPage)/2),false,false,true);
    }

    //add main links
    for ($i = $startPage ; $i <= $endPage ; $i++)
    {
      $this -> addPageToList($i);
    }

    //add link to middle page between end and main links
    if (($this->pagesCount - $this->lastPagesCnt) > $endPage && $this->lastPagesCnt != 0)
    {
      $this -> addPageToList(floor(($endPage + ($this->pagesCount - $this->lastPagesCnt + 1))/2),false,false,true);
    }

    //add links to X last pages
    for ($i = max($endPage, ($this->pagesCount - $this->lastPagesCnt))+1; $i <= $this->pagesCount; $i++)
    {
      $this -> addPageToList($i);
    }

    //add links to last page
    if ($this->pagesCount != $this->currentPage && $this->showNextLink)
    {
      $this -> addPageToList($this->currentPage+1, false, true);
    }

    return $this->pagesList;
  }

  function getSqlLimit()
  {
    return $this->currentPage*$this->pageSize.",".$this->pageSize;
  }


  function printDebug()
  {
    echo "<pre>";
    echo "current page  : " . $this->currentPage . "\r\n";
    echo "start page    : " . $this->_getStartPage() . "\r\n";
    echo "end page      : " . $this->_getEndPage() . "\r\n";
    echo "pages count   : " . $this->pagesCount . "\r\n";
    echo "delta         : " . $this->delta . "\r\n";
    echo "firstPagesCnt : " . $this->firstPagesCnt . "\r\n";
    echo "lastPagesCnt  : " . $this->lastPagesCnt . "\r\n";
    echo "getSqlLimit   : " . $this->getSqlLimit();
    echo "</pre>";
  }

  function render()
  {
    if (is_null($this->renderer)) return NULL;
    $this->renderer->setPager($this);
    return $this->renderer->render();
  }
}

//usage example
echo "pager1:<br>";
$pager = new Pager2(2000,5, new pagerHtmlRenderer());
$pager -> setDelta(5);
$pager -> setFirstPagesCnt(3);
$pager -> setLastPagesCnt(3);
$pager -> setPageVarName("start");

$pager -> enableCacheRemover = true;
echo $pager -> render();

echo "<br><br>debug<br>";
echo $pager->printDebug();

/*
echo "pager2:<br>";
$pager2 = new Pager2(2000,5);
$pager2 -> setPageIdentMethod(METHOD_RECORD_COUNT);
$pager2 -> setPageNamingMethod(DISPLAY_RECORDS_RANGE);
$pager2 -> setPageVarName("start1");
$pager2 -> enableCacheRemover = true;

echo $pager2->getPagesList();
echo "<br><br>debug<br>";
echo $pager2->printDebug();
*/
?>