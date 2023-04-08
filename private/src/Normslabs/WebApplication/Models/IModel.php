<?php
declare(strict_types=1);

/*
 * 420DW3_Integration_Project_Demo - IEntity.php IModel.php
 * 
 * @author Marc-Eric Boury (trucquynh)
 * @since 2023-03-17
 * (c) Copyright 2023 Marc-Eric Boury 
 */

namespace Normslabs\WebApplication\Models;

/**
 * @TODO   Documentation
 *
 * @author Marc-Eric Boury
 * @since  2023-03-17
 */
interface IModel {
    
    /**
     * @return $this|?
     *
     * @author Marc-Eric Boury
     * @since  2023-03-17
     */
    public function dbFetch(bool $commitIfTransaction = false) : ?static;
    
    /**
     * @return $this
     *
     * @author Marc-Eric Boury
     * @since  2023-03-17
     */
    public function dbInsert(bool $commitIfTransaction = false) : static;
    
    /**
     * @return $this
     *
     * @author Marc-Eric Boury
     * @since  2023-03-17
     */
    public function dbUpdate(bool $commitIfTransaction = false) : static;
    
    /**
     * @return $this
     *
     * @author Marc-Eric Boury
     * @since  2023-03-17
     */
    public function dbDelete(bool $commitIfTransaction = false) : static;
    
}