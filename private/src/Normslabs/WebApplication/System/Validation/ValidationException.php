<?php
declare(strict_types=1);

/*
 * 420DW3_Integration_Project_Demo - IEntity.php ValidationException.php
 * 
 * @author Marc-Eric Boury (trucquynh)
 * @since 2023-03-29
 * (c) Copyright 2023 Marc-Eric Boury 
 */

namespace Normslabs\WebApplication\System\Validation;

use mysql_xdevapi\Exception;
use Throwable;

/**
 * @TODO   Documentation
 *
 * @author Marc-Eric Boury
 * @since  2023-03-29
 */
class ValidationException extends Exception {
    
    /**
     * Construct the exception. Note: The message is NOT binary safe.
     * @link https://php.net/manual/en/exception.construct.php
     * @param string         $message  [optional] The Exceptions message to throw.
     * @param int            $code     [optional] The Exceptions code.
     * @param null|Throwable $previous [optional] The previous throwable used for the exception chaining.
     */
    public function __construct(string $message = "", int $code = 0, ?Throwable $previous = null) {
        parent::__construct($message, $code, $previous);
    }
}