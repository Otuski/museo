<?php
/**
 * Simple autoloader
 *
 * @param $class_name - String name for the class that is trying to be loaded.
 */
function my_custom_autoloader( $class_name ){


    $file = str_Replace("\\","/",$class_name).".php";

    if ( file_exists($file) ) {
        require_once $file;
    }
}

// add a new autoloader by passing a callable into spl_autoload_register()
spl_autoload_register( 'my_custom_autoloader' );
