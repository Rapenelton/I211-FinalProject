<?php

/**
 * Description of autoloader
 *
 * @author ryanpene
 */

class Autoloader {

    static private $_instance = NULL;

    /*
     * constructor to set autoloader
     * To use singleton patter, the constructor is made private. The getAutoloader method must be called to get an instance of the classs.
     */

    private function __construct() {
        spl_autoload_register(array('self', 'autoload'));
    }

    //static method to ensure there is just one MovieManager instance
    public static function getAutoloader() {
        if (self::$_instance == NULL) {
            self::$_instance = new Autoloader();
        }
        return self::$_instance;
    }

    // Automatically load the file that contains class definition
    public static function autoload($class) {
        //determine the current path
        $path = getcwd();

        //get the file name
        $file = $path . DIRECTORY_SEPARATOR . self::camelCaseToUnderscore($class) . '.class.php';

        if (is_readable($file)) {
            require_once($file);
        } else {
            self::recursive_autoload($class, $path);
        }
    }

    // try to load recursively the specified file
    private static function recursive_autoload($class, $path) {
        if (FALSE !== ($handle = opendir($path))) {
            while (FAlSE !== ($dir = readdir($handle))) {
                if (strpos($dir, '.') === FALSE) {
                    $path2 = $path . '/' . $dir;
                    $filepath = $path2 . '/' . self::camelCaseToUnderscore($class) . '.class.php';
                    if (is_readable($filepath)) {
                        require_once($filepath);
                        break;
                    }
                    self::recursive_autoload($class, $path2);
                }
            } closedir($handle);
        }
    }

    // Convert a camel case string to underscores (eg: camelCase becomes camel_case)
    private static function camelCaseToUnderscore($str) {
        //store all characters in an array
        $characters = str_split($str);

        //lowercase the first character
        $characters[0] = strtolower($characters[0]);

        //exam all characters in the array
        //if a character is uppercase, replace it with a lowercase and prefix it with an underscore
        foreach ($characters as &$character) {
            if (ord($character) >= ord('A') && ord($character) <= ord('Z'))
                $character = '_' . strtolower($character);
        }

        //conver all elements in the array into a string and return the string
        return implode('', $characters);
    }

}

//Instantiate Autoloader class to register the autoload method
Autoloader::getAutoloader();