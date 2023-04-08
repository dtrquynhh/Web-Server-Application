<?php
declare(strict_types=1);

/*
 * 420DW3_Integration_Project_Demo - IEntity.php PdoConnector.php
 * 
 * @author Marc-Eric Boury (trucquynh)
 * @since 2023-03-29
 * (c) Copyright 2023 Marc-Eric Boury 
 */

namespace Normslabs\WebApplication\System\Database;

use Exception;
use PDO;

/**
 * @TODO   Documentation
 *
 * @author Marc-Eric Boury
 * @since  2023-03-29
 */
class PdoConnector {
    
    private static ?PDO $connection = null;
    private static string $dsn = "mysql:host=127.0.0.1;dbname=420dw3_project;port=3306";
    private static string $username = "root";
    private static string $password = "";
    
    /**
     * @return PDO
     * @throws Exception
     *
     * @author Marc-Eric Boury
     * @since  2023-03-29
     */
    public static function getConnection() : PDO {
        if (!(self::$connection instanceof PDO)) {
            try {
                self::$connection = new PDO(self::$dsn, self::$username, self::$password);
                self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (Exception) {
                throw new Exception("Failure to create connection to the database, check your connection parameters.");
            }
        }
        return self::$connection;
    }
    
    
}