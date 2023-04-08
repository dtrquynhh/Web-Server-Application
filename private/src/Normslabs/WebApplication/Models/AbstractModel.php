<?php
declare(strict_types=1);

/*
 * 420DW3_Integration_Project_Demo - IEntity.php AbstractModel.php
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
abstract class AbstractModel implements IModel {
    
    
    /**
     * @param int  $id
     * @param bool $commitIfTransaction
     *
     * @return static|null
     *
     * @author Marc-Eric Boury
     * @since  2023-03-29
     */
    abstract public static function dbFetchById(int $id, bool $commitIfTransaction = false) : ?static;
    
    /**
     * @return $this|?
     *
     * @author Marc-Eric Boury
     * @since  2023-03-17
     */
    abstract public function dbFetch(bool $commitIfTransaction = false) : ?static;
    
    /**
     * @return $this
     *
     * @author Marc-Eric Boury
     * @since  2023-03-17
     */
    abstract public function dbInsert(bool $commitIfTransaction = false) : static;
    
    /**
     * @return $this
     *
     * @author Marc-Eric Boury
     * @since  2023-03-17
     */
    abstract public function dbUpdate(bool $commitIfTransaction = false) : static;
    
    /**
     * @return $this
     *
     * @author Marc-Eric Boury
     * @since  2023-03-17
     */
    abstract public function dbDelete(bool $commitIfTransaction = false) : static;
    
}