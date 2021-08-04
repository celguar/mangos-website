<?php
if(INCLUDED!==true)exit;

$pathway_info[] = array('title'=>$lang['site_config'],'link'=>'');

function convert($xml) {
    if ($xml instanceof SimpleXMLElement) {
        $children = $xml->children();
        $return = null;
    }

    foreach ($children as $element => $value) {
        if ($value instanceof SimpleXMLElement) {
            $values = (array)$value->children();

            if (count($values) > 0) {
                if (is_array($return[$element])) {
                    foreach ($return[$element] as $k=>$v) {
                        if (!is_int($k)) {
                            $return[$element][0][$k] = $v;
                            unset($return[$element][$k]);
                        }
                    }
                    $return[$element][] = convert($value);
                } else {
                    $return[$element] = convert($value);
                }
            } else {
                if (!isset($return[$element])) {
                    $return[$element] = (string)$value;
                } else {
                    if (!is_array($return[$element])) {
                        $return[$element] = array($return[$element], (string)$value);
                    } else {
                        $return[$element][] = (string)$value;
                    }
                }
            }
        }
    }

    if (is_array($return)) {
        return $return;
    } else {
        return false;
    }
}

function flatten($array, $path="")
{
    $result = array();
    foreach($array as $key=>$value){
        $fullkey = empty($path) ? $key : $path.".".$key;
        if (is_array($value)){
            $result = array_merge($result, flatten($value, $fullkey));
        }elseif (is_numeric($value)){
            $result[$fullkey] = (string)$value;
        }else{
            $result[$fullkey] = '"'.$value.'"';
        }
    }
    return $result;
}

$configfilepath = dirname(dirname(dirname(__FILE__))).DIRECTORY_SEPARATOR."config".DIRECTORY_SEPARATOR."config.xml";
$config = flatten(convert($MW->getConfig));

?>