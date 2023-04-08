<?php
declare(strict_types=1);

/*
 * 420DW3_Integration_Project_Demo - IEntity.php Application.php
 * 
 * @author Marc-Eric Boury (trucquynh)
 * @since 2023-03-29
 * (c) Copyright 2023 Marc-Eric Boury 
 */

namespace Normslabs\WebApplication;

use Exception;
use Normslabs\WebApplication\System\Database\PdoConnector;
use Normslabs\WebApplication\System\IApplication;
use PDO;

/**
 * @TODO   Documentation
 *
 * @author Marc-Eric Boury
 * @since  2023-03-29
 */
class Application implements IApplication {
    
    /**
     * Globally used DateTime format
     */
    public const DATETIME_FORMAT = "Y-m-d H:i:s.u";
    private static ?PDO $applicationDbConnection = null;
    
    /**
     * @return void
     *
     * @author Marc-Eric Boury
     * @since  2023-03-29
     */
    public function start() : void {
        // TODO: Implement start() method.
    }
    
    /**
     * @param int    $exit_code
     * @param string $output
     *
     * @return void
     *
     * @author Marc-Eric Boury
     * @since  2023-03-29
     */
    public function terminate(int $exit_code = 0, string $output = "") : void {
        // TODO: Implement terminate() method.
    }
    
    /**
     * @return PDO
     * @throws Exception
     *
     * @author Marc-Eric Boury
     * @since  2023-03-29
     */
    public static function getApplicationDbConnection() : PDO {
        if (!(self::$applicationDbConnection instanceof PDO)) {
            self::$applicationDbConnection = PdoConnector::getConnection();
        }
        return self::$applicationDbConnection;
    }
}