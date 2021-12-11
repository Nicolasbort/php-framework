<?php

namespace MedDocs\Repository;

use MedDocs\Entity\Consult;

class ConsultRepository extends AbstractRepository
{
    protected function getClassName(bool $lowercase = false, bool $onlySufix = false): string
    {
        $classPath = Consult::class;

        if ($lowercase) {
            $classPath = strtolower(Consult::class);
        }

        if ($onlySufix) {
            $className = explode('\\', $classPath);

            return end($className);
        }
        
        return $classPath;
    }
}