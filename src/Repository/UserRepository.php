<?php
namespace MedDocs\Repository;

use MedDocs\Entity\User;

class UserRepository extends AbstractRepository
{
    protected function getClassName(bool $lowercase = false, bool $onlySufix = false): string
    {
        $classPath = User::class;

        if ($lowercase) {
            $classPath = strtolower(User::class);
        }

        if ($onlySufix) {
            $className = explode('\\', $classPath);

            return end($className);
        }
        
        return $classPath;
    }
}