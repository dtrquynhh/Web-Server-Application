<?php
declare(strict_types=1);

/*
 * 420DW3_Integration_Project_Demo - IEntity.php MysqliConnector.php
 * 
 * @author Marc-Eric Boury (trucquynh)
 * @since 2023-03-31
 * (c) Copyright 2023 Marc-Eric Boury 
 */

namespace Normslabs\WebApplication\System\Database;

use mysqli;

/**
 * @TODO   Documentation
 *
 * @author Marc-Eric Boury
 * @since  2023-03-31
 */
class MysqliConnector {
    private static string $host = "localhost";
    private static string $user = "root";
    private static string $password = "";
    private static string $dbName = "420dw3_project";
    private static int $port = 3306;
    
    /**
     * @return mysqli
     *
     * @author Marc-Eric Boury
     * @since  2023-03-31
     */
    public static function getConnection() : mysqli {
        return new mysqli(self::$host, self::$user, self::$password);
    }
    
}