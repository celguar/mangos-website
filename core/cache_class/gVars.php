<?php
/*
*********************************************************************
**  gCache.                                                         *
**  Cesar D. Rodas <saddor@cesarodas.com>                           *
**                                                                  *
*********************************************************************
**  The author disclaims the copyright of this class. You are       *
**  legaly free to use, modify and redistribute the class.          *
**  Helps, bugs reports, and contributions could be done at         *
**  saddor@cesarodas.com. Also this email is a GTalk account, and   *
**  I can be contacted throught this way too.                       *
*********************************************************************
*/

/*
 *  gVars
 *
 *  Is a class included in the package of gCache, its main goal
 *  is to store into files information that could change. T
 *  The idea IS NOT TO REPLACE A DATABASE. The main goal is to use 
 *  database for store datas and gVars for read values.
 *
 *  Its integration with gCache made posible to build a smart cache
 *  that can change fragments of it self without rebuild the whole cache.
 *
 *  Useful for sites that digg.com that can cache the whole page and save
 *  votes into gVars and update it only when some vote.
 */
class gVars extends SafeIO {
    var $base_dir;
    var $split;
    var $var;
	
    function gVars($base_dir='./', $split=true) {
		$this->safeIO(); /* call constructor */
        $this->base_dir = $base_dir;
        $this->split = $split;
        
    }
    
    /*
     *  Open a variable. The content is keep in
     *  main memory. If the gVar-file doesnt exist
     *  is not created and return false.
     */
    function setVar($var) {
        if ( !$this->is_valid($var) )
            return false;
        $path = $this->getPath($var);
        
        $this->open($path, READ);
			$this->var = unserialize( $this->read($this->stat['size']) );
		$this->close(); //Release lock as soon as posible.

    }
    
	function save() {
		$this->open($this->filename, WRITE);
			$v = serialize($this->var);
			$this->write($v,strlen($v));	
		$this->close();
	}
    
    /*
     *  INTERNAL METHODS.
     */ 
    function is_valid($name) {
        $valid = true;
        $i=0;
        $e=strlen($name);
        
        $valid = $this->is_alpha($name[0]);
        while ($valid && $e < $i) {
            $valid = $this->is_alpha($name[$i]) || $this->is_letter($name[$i]);
            $i++;
        }
        return $valid;
    }
    
    function is_alpha($letra) {
        $letra = ord($letra);
        return ($letra >= ord('a') && $letra <= ord('z'));        
    }
    
    function is_letter($letra) {
        $letra = ord($letra);
        return ($letra >= ord('0') && $letra <= ord('9'));        
    }
    
    function getPath($name) {
        $dir = $this->base_dir;
        if ($dir[ strlen($dir)-1 ] != '/') $dir .= '/';
        if ($this->split) {
            $dir .= $name[0].'/'.$name[1].'/';
        	if (!is_dir($dir))
				@mkdir($dir,0777,true);
		}
		
        return $dir.$name;
    }
}

/*
$f = new gVars("test");
$f->setVar("variable");
print_r($f->var);
	$f->var['cesar'] = "rodas";
    $f->var['maldonado'] = "rodas";
    $f->var['david'] = "hola";
$f->save();
 */
?>