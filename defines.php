<?php
declare(strict_types=1);

/*
 * 420DW3_Integration_Project_Demo - IEntity.php defines.php
 * 
 * @author Marc-Eric Boury (trucquynh)
 * @since 2023-03-31
 * (c) Copyright 2023 Marc-Eric Boury 
 */


// ABSOLUTE (INTERNAL) PATHS

const PROJECT_ROOT = __DIR__.DIRECTORY_SEPARATOR;

const PRIVATE_DIR = PROJECT_ROOT."private".DIRECTORY_SEPARATOR;

const FRAGMENTS_DIR = PRIVATE_DIR."fragments".DIRECTORY_SEPARATOR;

const INCLUDE_DIR = PRIVATE_DIR."includes".DIRECTORY_SEPARATOR;

const SOURCES_DIR = PRIVATE_DIR."src".DIRECTORY_SEPARATOR;


// SERVER-RELATIVE (WEB) PATHS
const WEB_ROOT = "/420DW3_Integration_Project_Demo/";

const PUBLIC_DIR = WEB_ROOT."public/";

const CSS_DIR = PUBLIC_DIR."css/";

const IMAGES_DIR = PUBLIC_DIR."images/";

const JS_DIR = PUBLIC_DIR."js/";

const PAGES_DIR = PUBLIC_DIR."pages/";


$psr4_autoloader = function(string $class) : bool {
    $file = str_replace('\\', DIRECTORY_SEPARATOR, $class).'.php';
    $file_path = SOURCES_DIR.DIRECTORY_SEPARATOR.$file;
    if (file_exists($file_path)) {
        require $file_path;
        return true;
    }
    return false;
};

spl_autoload_register($psr4_autoloader);