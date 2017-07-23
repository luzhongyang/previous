<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id: log.mdl.php 9343 2015-03-24 07:07:00Z youyi $
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Mdl_Tuisong_Group extends Mdl_Table
{
    protected $_table = 'tuisong_group';
    protected $_pk    = 'tui_id';
    protected $_cols  = 'tui_id,title,name,number,order,dateline';
}
