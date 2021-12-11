<?php
namespace MedDocs\Repository;

use MedDocs\Entity\Laboratory;

class LaboratoryRepository extends AbstractRepository
{
    protected function getClassName(bool $lowercase = false, bool $onlySufix = false): string
    {
        $classPath = Laboratory::class;

        if ($lowercase) {
            $classPath = strtolower(Laboratory::class);
        }

        if ($onlySufix) {
            $className = explode('\\', $classPath);

            return end($className);
        }
        
        return $classPath;
    }
}