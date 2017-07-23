<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * Author shzhrui<anhuike@gmail.com>
 * $Id: exception.php 10707 2015-06-08 14:45:20Z xiaorui $
 */

if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class _Exception extends Exception
{
    
    private $_previous = null;

    public function __construct($msg = '', $code = 0, Exception $previous = null)
    {
        if (version_compare(PHP_VERSION, '5.3.0', '<')) {
            parent::__construct($msg, (int) $code);
            $this->_previous = $previous;
        } else {
            parent::__construct($msg, (int) $code, $previous);
        }
        register_shutdown_function(array(&$this,'ping'));
    }

    public function __call($method, array $args)
    {
        if ('getprevious' == strtolower($method)) {
            return $this->_getPrevious();
        }
        return null;
    }

    public function __toString()
    {
        if (version_compare(PHP_VERSION, '5.3.0', '<')) {
            if (null !== ($e = $this->getPrevious())) {
                return $e->__toString() 
                       . "\n\nNext " 
                       . parent::__toString();
            }
        }
        return parent::__toString();
    }

    protected function _getPrevious()
    {
        return $this->_previous;
    }

    static public function ping()
    {

    }
}
//new _Exception();
/*
throw new _Exception('DB:tablename/option{select,insert,update,delete..}/message');
throw new _Exception('IO:filename/option{open,write,read,del,move,copy.,}/message');
//系统异常{}
throw new _Exception('OS:{yubel,control,model,system,os...}/option{...}/message')

*/