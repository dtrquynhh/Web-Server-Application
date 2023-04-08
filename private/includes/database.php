<?php
declare(strict_types=1);

/*
 * 420DW3_Integration_Project_Demo - IEntity.php database.php
 * 
 * @author Marc-Eric Boury (trucquynh)
 * @since 2023-03-31
 * (c) Copyright 2023 Marc-Eric Boury 
 */

require_once __DIR__.DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."defines.php";

use Normslabs\WebApplication\System\Exceptions\DatabaseConnectionException;
use Normslabs\WebApplication\System\Validation\ValidationException;

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);


/**
 * @throws DatabaseConnectionException
 */
function db_get_connection() : mysqli {
    static $mysqli = null;
    if (is_null($mysqli)) {
        $mysqli = new mysqli("localhost", "root", "", "420dw3_project", 3306);
        $mysqli->options(MYSQLI_OPT_CONNECT_TIMEOUT, 10);
        if ($mysqli->errno) {
            throw new DatabaseConnectionException($mysqli->error, $mysqli->errno);
        }
    }
    return $mysqli;
}

/**
 * @param string $string
 * @param bool   $throwExceptions
 *
 * @return bool
 *
 * @author Marc-Eric Boury
 * @since  2023-03-31
 */
function db_validate_string(string $string, bool $throwExceptions = false) : bool {
    $return_val = true;
    $matches = [];
    
    if (empty($string)) {
        $return_val = false;
        if ($throwExceptions) {
            throw new ValidationException("String cannot be empty.");
        }
    } elseif (preg_match("/.*([?;`\"'()])+.*/mi", $string, $matches)) {
        $return_val = false;
        if ($throwExceptions) {
            throw new ValidationException("Invalid character found in string: [".$matches[1]."].");
        }
    }
    return $return_val;
}

/**
 * @param int|string $id_value
 * @param bool       $throwExceptions
 * @param int        $idAutoIncrementSeed
 *
 * @return bool
 *
 * @author Marc-Eric Boury
 * @since  2023-03-31
 */
function db_validate_int_id(int|string $id_value, bool $throwExceptions = false, int $idAutoIncrementSeed = 1) : bool {
    if (is_string($id_value)) {
        if (empty($id_value)) {
            if ($throwExceptions) {
                throw new ValidationException("Id value is an empty string.");
            }
            return false;
        } elseif (!is_numeric($id_value)) {
            if ($throwExceptions) {
                throw new ValidationException("Id value is a non-numeric string.");
            }
            return false;
        }
        $id_value = (int) $id_value;
    }
    if ($id_value < $idAutoIncrementSeed) {
        if ($throwExceptions) {
            throw new ValidationException("Id value is inferior to the auto-increment seed ($id_value < $idAutoIncrementSeed).");
        }
        return false;
    }
    return true;
}