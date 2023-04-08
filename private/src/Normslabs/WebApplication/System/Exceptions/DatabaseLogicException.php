<?php
declare(strict_types=1);

/*
 * 420DW3_Integration_Project_Demo - IEntity.php DatabaseLogicException.php
 * 
 * @author Marc-Eric Boury (trucquynh)
 * @since 2023-03-31
 * (c) Copyright 2023 Marc-Eric Boury 
 */

namespace Normslabs\WebApplication\System\Exceptions;

use mysql_xdevapi\Exception;
use Throwable;

/**
 * @TODO   Documentation
 *
 * @author Marc-Eric Boury
 * @since  2023-03-31
 */
class DatabaseLogicException extends Exception {
    
    /**
     * @param string         $message
     * @param int            $code
     * @param Throwable|null $prev
     */
    public function __construct(string $message = "", int $code = 0, ?Throwable $prev = null) {
        parent::__construct($message, $code, $prev);
    }
}