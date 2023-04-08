<?php
declare(strict_types=1);

/*
 * 420DW3_Integration_Project_Demo - IEntity.php Product.php
 * 
 * @author Marc-Eric Boury (trucquynh)
 * @since 2023-03-28
 * (c) Copyright 2023 Marc-Eric Boury 
 */

namespace Normslabs\WebApplication\Models;

use DateTime;
use mysql_xdevapi\Exception;
use Normslabs\WebApplication\Application;
use Normslabs\WebApplication\System\Validation\ValidationException;
use PDO;

/**
 * @TODO   Documentation
 *
 * @author Marc-Eric Boury
 * @since  2023-03-28
 */
class Product extends AbstractModel {
    
    private const DB_TABLE_NAME = "products";
    private const DB_ID_COLUMN_NAME = "id";
    
    private int $id;
    private string $displayName;
    private string $description;
    private string $imageUrl;
    private float $unitPrice;
    private int $availableQty;
    private DateTime $dateCreated;
    
    /**
     * default constructor
     */
    public function __construct() {}
    
    public static function createFromData(string  $displayName, ?string $description = null,
                                          ?string $imageUrl = null, float $unitPrice = 0.0,
                                          int     $availableQty = 0
    ) : self {
        $new_instance = new self();
        try {
            $new_instance->setDisplayName($displayName);
            $new_instance->setDescription($description);
            $new_instance->setImageUrl($imageUrl);
            $new_instance->setUnitPrice($unitPrice);
            $new_instance->setAvailableQty($availableQty);
            
            return $new_instance;
        } catch (Exception $previous) {
            throw new Exception("Failure to create new Product object.", 0, $previous);
        }
    }
    
    
    // GETTERS AND SETTERS
    
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
        if ($id < 0) {
            throw new ValidationException("Id value cannot be negative");
        }
        $this->id = $id;
    }
    
    /**
     * @return string
     */
    public function getDisplayName() : string {
        return $this->displayName;
    }
    
    /**
     * @param string $displayName
     */
    public function setDisplayName(string $displayName) : void {
        $string_length = mb_strlen($displayName);
        if ($string_length > 64) {
            throw new ValidationException("Display name is too long: maximum 64 characters, found [$string_length].");
        }
        if (empty($displayName)) {
            throw new ValidationException("Display name cannot be empty.");
        }
        $this->displayName = $displayName;
    }
    
    /**
     * @return string|null
     */
    public function getDescription() : ?string {
        return $this->description;
    }
    
    /**
     * @param string|null $description
     */
    public function setDescription(?string $description) : void {
        $this->description = $description;
    }
    
    /**
     * @return string|null
     */
    public function getImageUrl() : ?string {
        return $this->imageUrl;
    }
    
    /**
     * @param string|null $imageUrl
     *
     * @return void
     *
     * @throws ValidationException
     * @author Marc-Eric Boury
     * @since  2023-03-29
     */
    public function setImageUrl(?string $imageUrl) : void {
        if (is_string($imageUrl)) {
            $str_length = mb_strlen($imageUrl);
            if ($str_length > 128) {
                throw new ValidationException("Image URL string is too long: maximum 128 characters, found [$str_length]."
                );
            }
        }
        $this->imageUrl = $imageUrl;
    }
    
    /**
     * @return float
     */
    public function getUnitPrice() : float {
        return $this->unitPrice;
    }
    
    /**
     * @param float $unitPrice
     *
     * @throws ValidationException
     */
    public function setUnitPrice(float $unitPrice) : void {
        if ($unitPrice < 0) {
            throw new ValidationException("Unit price cannot be negative.");
        }
        $this->unitPrice = $unitPrice;
    }
    
    /**
     * @return int
     */
    public function getAvailableQty() : int {
        return $this->availableQty;
    }
    
    /**
     * @param int $availableQty
     *
     * @throws ValidationException
     */
    public function setAvailableQty(int $availableQty) : void {
        if ($availableQty < 0) {
            throw new ValidationException("Available quantity cannot be negative.");
        }
        $this->availableQty = $availableQty;
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
    
    
    
    // METHODS
    
    /**
     * @throws \Exception
     */
    public static function dbFetchById(int $id, bool $commitIfTransaction = false) : ?static {
        // TODO: Implement dbFetchById() method.
        $product = new Product();
        $product->setId($id);
        $product->dbFetch($commitIfTransaction);
        return $product;
    }
    
    /**
     * @throws \Exception
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
            $this->setDisplayName($result["displayName"]);
            $this->setDescription($result["description"]);
            $this->setImageUrl($result["imageUrl"]);
            $this->setUnitPrice((float) $result["unitPrice"]);
            $this->setAvailableQty((int) $result["availableQty"]);
            $this->setDateCreated(DateTime::createFromFormat(Application::DATETIME_FORMAT, $result["dateCreated"]));
            return $this;
        } catch (Exception $prev) {
            if ($connection->inTransaction()) {
                $connection->rollBack();
            }
            throw new Exception("Failure to fetch product by ID.", 0, $prev);
        }
    }
    
    /**
     * @throws \Exception
     */
    public function dbInsert(bool $commitIfTransaction = false) : static {
        // TODO: Implement dbInsert() method.
        $sql = "INSERT INTO ".self::DB_TABLE_NAME.
               " (`displayName`, `description`, `imageUrl`, `unitPrice`, `availableQty`)".
               " VALUES (:dispName, :desc, :img, :unitp, :availq);";
        $connection = Application::getApplicationDbConnection();
        try {
            $statement = $connection->prepare($sql);
            $statement->bindValue(":dispName", $this->getDisplayName());
            $statement->bindValue(":desc", $this->getDescription());
            $statement->bindValue(":img", $this->getImageUrl());
            $statement->bindValue(":unitp", $this->getUnitPrice());
            $statement->bindValue(":availq", $this->getAvailableQty(), PDO::PARAM_INT);
            $statement->execute();
            $new_id = $connection->lastInsertId();
            $this->setId((int) $new_id);
            return $this->dbFetch($commitIfTransaction);
        } catch (Exception $prev) {
            if ($connection->inTransaction()) {
                $connection->rollBack();
            }
            throw new Exception("Failure to insert product into database.", 0, $prev);
        }
    }
    
    /**
     * @throws \Exception
     */
    public function dbUpdate(bool $commitIfTransaction = false) : static {
        // TODO: Implement dbUpdate() method.
        $sql = "UPDATE ".self::DB_TABLE_NAME.
               " SET `displayName` = :dispName,
               `description` = :desc,
               `imageUrl` = :img,
               `availableQty` = :availq ".
               " WHERE `".self::DB_ID_COLUMN_NAME."` = :id;";
        $connection = Application::getApplicationDbConnection();
        try {
            $statement = $connection->prepare($sql);
            $statement->bindValue(":dispName", $this->getDisplayName());
            $statement->bindValue(":desc", $this->getDescription());
            $statement->bindValue(":img", $this->getImageUrl());
            $statement->bindValue(":avail", $this->getAvailableQty(), PDO::PARAM_INT);
            $statement->bindValue(":id", $this->getId(), PDO::PARAM_INT);
            $statement->execute();
            return $this->dbFetch($commitIfTransaction);
        } catch (\Exception $prev) {
            if ($connection->inTransaction()) {
                $connection->rollBack();
            }
            throw new \Exception("Failure to update data for product id #[".$this->getId()."]", 0, $prev);
        }
    }
    
    /**
     * @throws \Exception
     */
    public function dbDelete(bool $commitIfTransaction = false) : static {
        // TODO: Implement dbDelete() method.
        $sql = "DELETE FROM ".self::DB_TABLE_NAME.
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
            throw new \Exception("Failure to delete product id #[".$this->getId()."] from database.", 0, $prev);
        }
    }
}