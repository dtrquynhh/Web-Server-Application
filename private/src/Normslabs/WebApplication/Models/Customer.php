<?php
declare(strict_types=1);

/*
 * 420DW3_Integration_Project_Demo - IEntity.php Customer.php
 * 
 * @author Marc-Eric Boury (trucquynh)
 * @since 2023-03-31
 * (c) Copyright 2023 Marc-Eric Boury 
 */

namespace Normslabs\WebApplication\Models;

use DateTime;
use Exception;
use Normslabs\WebApplication\Application;
use Normslabs\WebApplication\System\Validation\ValidationException;
use PDO;

/**
 * @TODO   Documentation
 *
 * @author Marc-Eric Boury
 * @since  2023-03-31
 */
class Customer extends AbstractModel {
    
    private const DB_TABLE_NAME = "customers";
    private const DB_ID_COLUMN_NAME = "id";
    
    private int $id;
    private string $username;
    private string $passwordHash;
    private DateTime $dateCreated;
    
    
    private function __construct() {}
    
    /**
     * @param string $username
     * @param string $passwordHash
     *
     * @return static
     *
     * @author Marc-Eric Boury
     * @since  2023-03-31
     */
    public static function createFromData(string $username, string $passwordHash) : static {
        $customer = new Customer();
        $customer->setUsername($username);
        $customer->setPasswordHash($passwordHash);
        return $customer;
    }
    
    
    // GETTERS AND SETTERS
    
    /**
     * @param int  $id
     * @param bool $commitIfTransaction
     *
     * @return static|null
     *
     * @throws Exception
     * @author Marc-Eric Boury
     * @since  2023-03-29
     */
    public static function dbFetchById(int $id, bool $commitIfTransaction = false) : ?static {
        // TODO: Implement dbFetchById() method.
        $customer = new Customer();
        $customer->setId($id);
        $customer->dbFetch($commitIfTransaction);
        return $customer;
    }
    
    /**
     * @return $this|?
     *
     * @throws Exception
     * @author Marc-Eric Boury
     * @since  2023-03-17
     */
    public function dbFetch(bool $commitIfTransaction = false) : ?static {
        // TODO: Implement dbFetch() method.
        if (empty($this->getId())) {
            throw new Exception("Cannot fetch a model with no id value set.");
        }
        $sql = "SELECT * FROM ".self::DB_TABLE_NAME." WHERE ".
               self::DB_ID_COLUMN_NAME." = :id;";
        $connection = Application::getApplicationDbConnection();
        try {
            $statement = $connection->prepare($sql);
            $statement->bindValue(":id", $this->getId(), PDO::PARAM_INT);
            $statement->execute();
            $record_array = $statement->fetchAll(PDO::FETCH_ASSOC);
            if ($connection->inTransaction() && $commitIfTransaction) {
                $connection->commit();
            }
            if (count($record_array) < 1) {
                return null;
            }
            $result = $record_array[0];
            $this->setUsername($result["username"]);
            $this->setPasswordHash($result["passwordHash"]);
            $this->setDateCreated(DateTime::createFromFormat(Application::DATETIME_FORMAT, $result["dateCreated"]));
            return $this;
        } catch (Exception $prev) {
            if ($connection->inTransaction()) {
                $connection->rollBack();
            }
            throw new Exception("Failure to fetch customer by ID.", 0, $prev);
        }
        
    }
    
    /**
     * @return $this
     *
     * @throws Exception
     * @author Marc-Eric Boury
     * @since  2023-03-17
     */
    public function dbInsert(bool $commitIfTransaction = false) : static {
        // TODO: Implement dbInsert() method.
        $sql = "INSERT INTO ".self::DB_TABLE_NAME.
               " (`username`, `passwordHash`)".
               " VALUES (:uname, :passH);";
        $connection = Application::getApplicationDbConnection();
        try {
            $statement = $connection->prepare($sql);
            $statement->bindValue(":uname", $this->getUsername());
            $statement->bindValue(":passH", $this->getPasswordHash());
            $statement->execute();
            $new_id = $connection->lastInsertId();
            $this->setId((int) $new_id);
            return $this->dbFetch($commitIfTransaction);
        } catch (Exception $prev) {
            if ($connection->inTransaction()) {
                $connection->rollBack();
            }
            throw new Exception("Failure to insert customer into database.", 0, $prev);
        }
    }
    
    /**
     * @return $this
     *
     * @throws Exception
     * @author Marc-Eric Boury
     * @since  2023-03-17
     */
    public function dbUpdate(bool $commitIfTransaction = false) : static {
        // TODO: Implement dbUpdate() method.
        $sql = "UPDATE ".self::DB_TABLE_NAME.
               "SET `username` = :uname,
               `passwordHash` = :passH".
               " WHERE `".self::DB_ID_COLUMN_NAME." = :id;";
        $connection = Application::getApplicationDbConnection();
        try {
            $statement = $connection->prepare($sql);
            $statement->bindValue(":uname", $this->getUsername());
            $statement->bindValue(":passH", $this->getPasswordHash());
            $statement->bindValue(":id", $this->getId(), PDO::PARAM_INT);
            $statement->execute();
            return $this->dbFetch($commitIfTransaction);
        } catch (Exception $prev){
            if ($connection->inTransaction()) {
                $connection->rollBack();
            }
            throw new Exception("Failure to update data for product if # [".$this->getId()."]", 0, $prev);
        }
    }
    
    /**
     * @return $this
     *
     * @throws Exception
     * @author Marc-Eric Boury
     * @since  2023-03-17
     */
    public function dbDelete(bool $commitIfTransaction = false) : static {
        // TODO: Implement dbDelete() method.
        $sql = "DELETEFROM ".self::DB_TABLE_NAME.
               " WHERE `".self::DB_ID_COLUMN_NAME."` = :id;";
        $connection = Application::getApplicationDbConnection();
        try {
            $statement = $connection->prepare($sql);
            $statement->bindValue(":id", $this->getId(), PDO::PARAM_INT);
            $statement->execute();
            if ($connection->inTransaction() && $commitIfTransaction) {
                $connection->commit();
            }
            return $this;
        } catch (Exception $prev) {
            if ($connection->inTransaction()) {
                $connection->rollBack();
            }
            throw new Exception("Failure to delete customer id # [".$this->getId()."] from database", 0, $prev);
        }
    }
    
    
    // METHODS
    /**
     * @return int
     */
    public function getId() : int {
        return $this->id;
    }
    
    /**
     * @param int $id
     */
    public function setId(int $id) : void {
        if ($id < 1) {
            throw new ValidationException("Id value should not be inferior to 1.");
        }
        $this->id = $id;
    }
    
    /**
     * @return string
     */
    public function getUsername() : string {
        return $this->username;
    }
    
    /**
     * @param string $username
     */
    public function setUsername(string $username) : void {
        $string_length = mb_strlen($username);
        if ($string_length > 32) {
            throw new ValidationException("Customer username has a max length of 32 characters, [$string_length] found."
            );
        }
        $this->username = $username;
    }
    
    /**
     * @return string
     */
    public function getPasswordHash() : string {
        return $this->passwordHash;
    }
    
    /**
     * @param string $passwordHash
     *
     * @return void
     *
     * @author Marc-Eric Boury
     * @since  2023-03-31
     */
    public function setPasswordHash(string $passwordHash) : void {
        $string_length = mb_strlen($passwordHash);
        if ($string_length > 128) {
            throw new ValidationException("Customer password has has a max length of 128 characters, [$string_length] found."
            );
        }
        $this->passwordHash = $passwordHash;
    }
    
    /**
     * @return DateTime
     */
    public function getDateCreated() : DateTime {
        return $this->dateCreated;
    }
    
    /**
     * @param DateTime $dateCreated
     */
    public function setDateCreated(DateTime $dateCreated) : void {
        $this->dateCreated = $dateCreated;
    }
}