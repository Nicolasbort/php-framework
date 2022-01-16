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
        $this->db = new PDO("sqlite:resources/database.sqlite", null, null, [
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

            if ($snakeCase === 'user' || $snakeCase === 'doctor' || $snakeCase === 'laboratory') {
                $snakeCase .= '_id';
            }

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

            $isEntity = false;
            if ($property === 'user' || $property === 'doctor' || $property === 'laboratory') {
                $isEntity = true;
            }

            if ($isEntity === true) {
                echo '<pre>';
                var_dump($getter, $property, $entity->$getter());
                echo '</pre>';
                $stmt->bindValue($key+1, $entity->$getter()->getId());

                continue;
            }

            $stmt->bindValue($key+1, $entity->$getter());
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

            $row = $statement->fetch(PDO::FETCH_ASSOC);

            if ($row === false) {
                return null;
            }

            $class = $this->getClassName();
            $entity = new $class();

            foreach ($row as $field => $value) {
                if ($this->isEntity($field)) {
                    $entityName = explode('_', $field)[0];
    
                    if ($entityName === 'user' || $entityName === 'laboratory' || $entityName === 'doctor') {
                        $entityToSet = $entityName;
                        $entityName = 'user';
                    }
    
                    $entityPath = "MedDocs\\Entity\\" . ucfirst($entityName);
    
                    $relationSql = $this->createBaseSelect($entityName) . " WHERE id = {$value}";
    
                    $relationStatement = $this->db->prepare($relationSql);
                    $relationStatement->execute();
    
                    $relationEntity = $relationStatement->fetchObject($entityPath);
    
                    $setter = 'set' . $this->toCamelCase($entityToSet ?? $entityName, true);
                    $entity->$setter($relationEntity);
    
                    continue;
                }

                $setter = 'set' . $this->toCamelCase($field, true);
                $entity->$setter($value);
            }

            return $entity;
        } catch (PDOException $e) {
            $this->pdoError = $e;

            return null;
        }
    }

    public function findOneBy(array $filters)
    {
        $sql = $this->createBaseSelect();
        $sql .= " WHERE";

        $andCount = count($filters) - 1;
        foreach ($filters as $column => $value) {
            $sql .= " {$column} = '{$value}'";

            if ($andCount > 0) {
                $sql .= ' AND';
                $andCount--;
            }
        }

        try {
            $statement = $this->db->prepare($sql);
            $statement->execute();

            $row = $statement->fetch(PDO::FETCH_ASSOC);

            if ($row === false) {
                return null;
            }

            $class = $this->getClassName();
            $entity = new $class();

            foreach ($row as $field => $value) {
                if ($this->isEntity($field)) {
                    $entityName = explode('_', $field)[0];
    
                    if ($entityName === 'user' || $entityName === 'laboratory' || $entityName === 'doctor') {
                        $entityToSet = $entityName;
                        $entityName = 'user';
                    }
    
                    $entityPath = "MedDocs\\Entity\\" . ucfirst($entityName);
    
                    $relationSql = $this->createBaseSelect($entityName) . " WHERE id = {$value}";
    
                    $relationStatement = $this->db->prepare($relationSql);
                    $relationStatement->execute();
    
                    $relationEntity = $relationStatement->fetchObject($entityPath);
    
                    $setter = 'set' . $this->toCamelCase($entityToSet ?? $entityName, true);
                    $entity->$setter($relationEntity);
    
                    continue;
                }

                $setter = 'set' . $this->toCamelCase($field, true);
                $entity->$setter($value);
            }

            return $entity;
        } catch (PDOException $e) {
            $this->pdoError = $e;

            return null;
        }
    }

    public function findBy(array $filters)
    {
        $sql = $this->createBaseSelect();
        $sql .= " WHERE";

        $andCount = count($filters) - 1;
        foreach ($filters as $column => $value) {
            $sql .= " {$column} = '{$value}'";

            if ($andCount > 0) {
                $sql .= ' AND';
                $andCount--;
            }
        }

        try {
            $statement = $this->db->prepare($sql);
            $statement->execute();

            $entities = [];
            
            $rows = $statement->fetchAll(PDO::FETCH_CLASS);
            foreach ($rows as &$row) {
                $class = $this->getClassName(); 
                $entity = new $class();

                foreach ($row as $field => $value) {
                    if ($this->isEntity($field)) {
                        $entityName = explode('_', $field)[0];

                        if ($entityName === 'user' || $entityName === 'laboratory' || $entityName === 'doctor') {
                            $entityToSet = $entityName;
                            $entityName = 'user';
                        }

                        $entityPath = "MedDocs\\Entity\\" . ucfirst($entityName);

                        $relationSql = $this->createBaseSelect($entityName) . " WHERE id = {$value}";

                        $relationStatement = $this->db->prepare($relationSql);
                        $relationStatement->execute();

                        $relationEntity = $relationStatement->fetchObject($entityPath);

                        $setter = 'set' . $this->toCamelCase($entityToSet ?? $entityName, true);
                        $entity->$setter($relationEntity);

                        continue;
                    }

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

    public function findAll(): ?array
    {
        try {
            $sql = $this->createBaseSelect();

            $statement = $this->db->prepare($sql);

            $statement->execute();

            $entities = [];

            $rows = $statement->fetchAll(PDO::FETCH_ASSOC);
            foreach ($rows as &$row) {
                $class = $this->getClassName(); 
                $entity = new $class();

                foreach ($row as $field => $value) {
                    if ($this->isEntity($field)) {
                        $entityName = explode('_', $field)[0];

                        if ($entityName === 'user' || $entityName === 'laboratory' || $entityName === 'doctor') {
                            $entityToSet = $entityName;
                            $entityName = 'user';
                        }

                        $entityPath = "MedDocs\\Entity\\" . ucfirst($entityName);

                        $relationSql = $this->createBaseSelect($entityName) . " WHERE id = {$value}";

                        $relationStatement = $this->db->prepare($relationSql);
                        $relationStatement->execute();

                        $relationEntity = $relationStatement->fetchObject($entityPath);

                        $setter = 'set' . $this->toCamelCase($entityToSet ?? $entityName, true);
                        $entity->$setter($relationEntity);

                        continue;
                    }

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

    private function createBaseSelect(string $customTable = null, string $selectFields = '*'): string
    {
        $table = $customTable ?? $this->getClassName(true, true);

        return "SELECT {$selectFields} FROM {$table}";
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

    private function isEntity(string $field): bool
    {
        return preg_match('/_id/', $field);
    }

    private function getEntity(string $field): AbstractEntity
    {
        $entityName = explode('_', $field)[0];

        $entityPath = "MedDocs\\Entity\\" . ucfirst($entityName);

        return new $entityPath();
    }

    private function toCamelCase(string $snakeCase, bool $capitalizeFirstCharacter = false): string
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