<?php

// set utf8
mb_internal_encoding ("UTF-8");

// set page time out
set_time_limit (30);

// show errors
error_reporting(E_ALL);
ini_set( 'display_errors','1');


// create useful defined vars for vital directories
define('_ROOT', realpath ('../'));
define('DS',    DIRECTORY_SEPARATOR);
define('_PRIVATE',  _ROOT.DS.'private/');
define('_PUBLIC',   _ROOT.DS.'public/');
define('_LIBRARY',  _PRIVATE.'Library/');
define('_TEMPLATE',  _PUBLIC.'php/templates/');

set_include_path(implode(PATH_SEPARATOR, array(
    realpath(_LIBRARY),
    get_include_path(),
)));

require_once(_LIBRARY.'Zend/Loader.php');


// what env are we on?
defined ('_ENV') || define('_ENV', (getenv ('_ENV') ? getenv ('_ENV') : 'dev'));


// auto load classes
function __autoload ($className) {

    $className = str_replace ('_', '/', $className);

    if (file_exists (_LIBRARY.$className.'.php')) {
        require (_LIBRARY.$className.'.php');
    } else {
        throw new Exception($className.' could not be loaded', 404);
    }
}