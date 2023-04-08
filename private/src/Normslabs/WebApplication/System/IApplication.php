<?php
declare(strict_types=1);

/*
 * 420DW3_Integration_Project_Demo - IEntity.php IApplication.php
 * 
 * @author Marc-Eric Boury (trucquynh)
 * @since 2023-03-29
 * (c) Copyright 2023 Marc-Eric Boury 
 */

namespace Normslabs\WebApplication\System;

/**
 * @TODO   Documentation
 *
 * @author Marc-Eric Boury
 * @since  2023-03-29
 */
interface IApplication {
    
    /**
     * @return void
     *
     * @author Marc-Eric Boury
     * @since  2023-03-29
     */
    public function start() : void;
    
    /**
     * @param int    $exit_code
     * @param string $output
     *
     * @return void
     *
     * @author Marc-Eric Boury
     * @since  2023-03-29
     */
    public function terminate(int $exit_code = 0, string $output = "") : void;
}