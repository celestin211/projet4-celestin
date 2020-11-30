<?php
/****************************************MODEL/AUTOLOADER.PHP****************************************/

namespace Bosongo\Blog_Forteroche\Core;


/**
 * class Autoloader
 * Generate an autoloader to call different class 
 */
class Autoloader
{
    /**
     * register
     *
     * register function call spl function which have @param __CLASS__(class Autoloader), and the function autoload
     * 
     * @return void
     */
    static function register()
    {
        spl_autoload_call(array(__CLASS__, 'autoload'));
    }
   
    /**
     * autoload
     *
     * @param  string $className Allows to call any class, so no need to require each class every time needed
     *
     * @return void
     */
    static function autoload($class_Name)
    {
        var_dump($class_Name);
        require_once( $class_Name . '.php');    
    } 
}