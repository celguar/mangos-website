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
 *  safeIO is a class that offer the possibility to open for 
 *  read, append, write (truncate), and other operations on file
 *  in a secure way.
 *  This class provides a locking system based on file creation
 *  and also could use the PHP flock function.
 *
 *	IF YOU WANT TO OPEN A FILE FOR READ AND IT DOESNT EXIST THE FILE
 *	IS CREATED.
 *
 *  The creation of this class is for avoid the problem that PHP
 *  flock doesn't work on FAT32 hard disk.
 *
 *  The safeIO will choose the flock as much as he can, of course 
 *  this can be changed at run time.
 *
 *	Ex: 
 *	    $f = new safeIO;
 *      $f->open("file",READ);
 *           $content = $f->read( $f->stat['size'] );
 *      $f->close();
 *
 *		$f->open("file",WRITE);
 *			$f->write( "hola", 4);
 *		$f->close();
 *
 */

define ('UNLOCK',0);
define ('SHARED',2);
define ('EXCLUSIVE',4);

define('MAX_LOCK_TRY',5);

define('READ',2);
define('APPEND',4);
define('WRITE',5);

class safeIO {
    var $stat;
	
	/* Private vars */
	var $fbased;
	var $Lock;
	var $fp;
	var $filename;
	
	function safeIO() {
		$this->fbased = $this->isRunningOsWin();
		register_shutdown_function("safeIOCleaner");
	}
	
	function read($offset) {
		return fread($this->fp, $offset);
	}
	
	function write($str, $length) {
		return fwrite($this->fp, $str, $length);
	}
	
	function seek($offset,$where) {
		return fseek($this->fp,$offset,$where);
	}	
	
	function open($file,$method) {
        $this->filename = $file;
        
        switch ($method) {
        	case READ:
				if ( !file_exists($file) && fclose(fopen($file,"w")) && !file_exists($file)) 	
					return false;
				
				$this->fp = fopen($file,"rb");
				if (! $this->sharedLock() ) {
					$this->close();
					return false;
				}
				break;
			case APPEND:        
				$this->fp = fopen($file,"ab");
				if (! $this->exclusiveLock() ) {
					$this->close();
					return false;
				}
				break;
			case WRITE:
				$this->fp = fopen($file,"ab");
				if (! $this->exclusiveLock() ) {
					$this->close();
					return false;
				}
				$this->seek(0,SEEK_SET);
				clearstatcache(); //clean stat cache, important!
				ftruncate($this->fp,0); //truncated
				break;
		}
		$this->stat =  fstat($this->fp);
		return true;
    }
	
	function close() {
		$this->unlock();
		fclose($this->fp);
	}
	
	function exclusiveLock() {
		$i=0;
		while ( !($r=$this->_exclusiveLock()) && $i++ < MAX_LOCK_TRY)
			sleep(1);
		return $r;
	}
	
	function sharedLock() {
		$i=0;
		while ( !($r=$this->_sharedLock()) && $i++ < MAX_LOCK_TRY)
			sleep(1);
		return $r;
	}
	
	
	function isRunningOsWin() {
        return strpos(strtolower(php_uname()),"windows") !== false;
    }
	
	function unlock() {
        if ($this->fbased)
            @unlink($this->Lock);
        else
            flock($this->fp,LOCK_UN);
    }
	
	function _sharedLock() {
        global $safeIOLocks;
        if ($this->fbased) {
            if ($this->getLockStatus($path) == EXCLUSIVE) return false;
            $path = $this->GetNewLockName("read");
            $safeIOLocks[] = $path; /* saves for the end app callback function */
            $this->Lock = $path;
            $fp = fopen($path,"wb");
            $this->FileExistsOrDie($path);
            fclose($fp);
            return true;
        } else return flock($this->fp,LOCK_SH);
    }
	
	function _exclusiveLock() {
        global $safeIOLocks;
        if ($this->fbased) {
            if ($this->getLockStatus($path) != UNLOCK) return false;        
            $path = $this->GetNewLockName("write");
            $safeIOLocks[] = $path;
            $this->Lock = $path;
			$fp = fopen($path,"wb");
            $this->FileExistsOrDie($path);
            fclose($fp);
			return true;        
        } else return flock($this->fp,LOCK_EX);
    }
	
	function getLockStatus() {
        $r = UNLOCK;
		$path = $this->filename;
        clearstatcache();
        if  (is_file("${path}.*.write"))
            $r = EXCLUSIVE;
        else if  (is_file("${path}.*.read"))
            $r = SHARED;

        return $r;
    }
	
	/*
     *  Generate a new name for the lock file.
     */
    function GetNewLockName($type) {
        $rnd = str_replace(".","",(time()+microtime()));
        return $this->filename.".".$rnd.".${type}";
    }
	
    function  FileExistsOrDie($path) {
        if (!is_file($path)) 
            die("$path couldn't be created!, please see if PHP has write permissions for this file");
    }
    
}

function safeIOCleaner() {
    global $safeIOLocks;

    if (!is_array($safeIOLocks))
        return;
    foreach($safeIOLocks as $value) {
        @unlink($value);
    }
	unset($safeIOLocks);
}
