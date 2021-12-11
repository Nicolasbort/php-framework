<?php
namespace MedDocs\Repository;

use MedDocs\Entity\Doctor;

class DoctorRepository extends AbstractRepository
{
    protected function getClassName(bool $lowercase = false, bool $onlySufix = false): string
    {
        $classPath = Doctor::class;

        if ($lowercase) {
            $classPath = strtolower(Doctor::class);
        }

        if ($onlySufix) {
            $className = explode('\\', $classPath);

            return end($className);
        }
        
        return $classPath;
    }
}