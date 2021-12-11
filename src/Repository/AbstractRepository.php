<?php
namespace MedDocs\Repository;

use MedDocs\Entity\AbstractEntity;
use PDO;
use PDOException;

abstract class AbstractRepository
{
    /**
     * @var PDO
     */
    private $db;

    /**
     * @var PDOException
     */
    private $pdoError = null;
    
    public function __construct()
    {
        $this->db = new PDO("sqlite:resources/database.sql", null, null, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);
    }

    public function create(AbstractEntity $entity): bool
    {
        $properties = array_keys($entity->getProperties());
        $propertiesCount = count($properties);

        $fields = '(';
        $values = '(';
        foreach ($properties as $key => $property) {
            $snakeCase = $this->toSnakeCase($property);

            if ($key+1 === $propertiesCount) {
                $fields .= $snakeCase;
                $values .= "?";

                break;
            }

            $fields .= "{$snakeCase}, ";
            $values .= "?, ";
        }
        $fields .= ')';
        $values .= ')';

        $sql = "INSERT INTO {$this->getClassName(true, true)} {$fields} VALUES {$values}";

        $stmt = $this->db->prepare($sql);

        foreach ($properties as $key => $property) {
            $getter = 'get' . ucfirst($property);

            $stmt->bindParam($key+1, $entity->$getter());
        }

        try {
            return $stmt->execute();
        } catch (PDOException $e) {
            $this->pdoError = $e;

            return false;
        }
    }

    public function update(AbstractEntity $entity): bool
    {
        $entityId = $entity->getId();

        if (!isset($entityId)) {
            return false;
        }

        $properties = array_keys($entity->getProperties());
        $propertiesCount = count($properties);
        $sql = "UPDATE {$this->getClassName(true, true)} SET";

        foreach ($properties as $key => $property) {
            $camelCaseProperty = $this->toCamelCase($property);
            $getter = 'get' . $camelCaseProperty;
            $value = $entity->$getter();

            $sql .= " {$property} = '{$value}'";
            if ($key+1 !== $propertiesCount) {
                $sql .= ',';
            }
        }

        $sql .= " WHERE id = {$entityId}";

        try {
            $stmt = $this->db->prepare($sql);

            return $stmt->execute();
        } catch (PDOException $e) {
            $this->pdoError = $e;

            return false;
        }
    }

    public function delete(AbstractEntity $entity): bool
    {
        $entityId = $entity->getId();

        if (!isset($entityId)) {
            return false;
        }

        $sql = "DELETE FROM {$this->getClassName()} WHERE id = :id";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $entityId);

        try {
            return $stmt->execute();
        } catch (PDOException $e) {
            $this->pdoError = $e;

            return false;
        }
    }

    public function find(string $id)
    {
        try {
            $sql = $this->createBaseSelect() . " WHERE id = {$id}";

            $statement = $this->db->prepare($sql);
            $statement->execute();

            return $statement->fetchObject($this->getClassName());
        } catch (PDOException $e) {
            $this->pdoError = $e;

            return null;
        }
    }

    public function findOneBy(array $filters)
    {
        $sql = $this->createBaseSelect();
        $sql .= " WHERE";

        foreach ($filters as $column => $value) {
            $sql .= " {$column} = '{$value}'";
        }

        try {
            $statement = $this->db->prepare($sql);
            $statement->execute();

            return $statement->fetchObject($this->getClassName());
        } catch (PDOException $e) {
            $this->pdoError = $e;

            return null;
        }
    }

    public function findBy(array $filters)
    {
        $sql = $this->createBaseSelect();
        $sql .= " WHERE";

        foreach ($filters as $column => $value) {
            $sql .= " {$column} = '{$value}'";
        }

        try {
            $statement = $this->db->prepare($sql);
            $statement->execute();

            return $statement->fetchAll(PDO::FETCH_CLASS, $this->getClassName());
        } catch (PDOException $e) {
            $this->pdoError = $e;

            return null;
        }
    }

    public function findAll(): ?array
    {
        try {
            $sql = $this->createBaseSelect();

            $statement = $this->db->prepare($sql);

            $statement->execute();

            $class = $this->getClassName(); 
            $entity = new $class();
            $entities = [];

            $rows = $statement->fetchAll(PDO::FETCH_ASSOC);
            foreach ($rows as &$row) {
                foreach ($row as $field => $value) {
                    $setter = 'set' . $this->toCamelCase($field, true);
                    $entity->$setter($value);
                }

                $entities[] = $entity;
            }

            return $entities;
        } catch (PDOException $e) {
            $this->pdoError = $e;

            return null;
        }
    }

    public function getError(): ?PDOException
    {
        return $this->pdoError;
    }

    private function createBaseSelect(string $selectFields = '*'): string
    {
        return "SELECT {$selectFields} FROM {$this->getClassName(true, true)}";
    }

    private function getClass(AbstractEntity $entity, bool $lowecase = true): string
    {
        $classPath = get_class($entity);
        $className = explode('\\', $classPath);

        if ($lowecase) {
            return strtolower($className);
        }

        return $className;
    }

    private function toCamelCase(string &$snakeCase, bool $capitalizeFirstCharacter = false): string
    {
        $camelCase = str_replace(' ', '', ucwords(str_replace('_', ' ', $snakeCase)));

        if ($capitalizeFirstCharacter === false) {
            $camelCase[0] = strtolower($camelCase[0]);
        }

        return $camelCase;
    }

    private function toSnakeCase(string &$camelCase): string
    {
        return ltrim(strtolower(preg_replace('/[A-Z]/', '_$0', $camelCase )), '_');
    }

    abstract protected function getClassName(bool $lowercase = false, bool $onlySufix = false): string;
}