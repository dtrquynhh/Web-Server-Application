<?php
declare(strict_types=1);

/*
 * 420DW3_Integration_Project_Demo - IEntity.php DatabaseConnectionException.php
 * 
 * @author Marc-Eric Boury (trucquynh)
 * @since 2023-03-31
 * (c) Copyright 2023 Marc-Eric Boury 
 */

namespace Normslabs\WebApplication\System\Exceptions;

use Exception;
use Throwable;

/**
 * @TODO   Documentation
 *
 * @author Marc-Eric Boury
 * @since  2023-03-31
 */
class DatabaseConnectionException extends Exception {
    /**
     * Construct the exception. Note: The message is NOT binary safe.
     * @link https://php.net/manual/en/exception.construct.php
     *
     * @param string         $error
     * @param int            $errno
     * @param null|Throwable $previous [optional] The previous throwable used for the exception chaining.
     */
    public function __construct(string $error, int $errno, ?Throwable $previous = null) {
        $message = "Databse connection error: [$errno] : ".$error;
        parent::__construct($error, $errno, $previous);
    }
}