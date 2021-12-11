<?php
namespace MedDocs\Repository;

use MedDocs\Entity\Exam;

class ExamRepository extends AbstractRepository
{
    protected function getClassName(bool $lowercase = false, bool $onlySufix = false): string
    {
        $classPath = Exam::class;

        if ($lowercase) {
            $classPath = strtolower(Exam::class);
        }

        if ($onlySufix) {
            $className = explode('\\', $classPath);

            return end($className);
        }
        
        return $classPath;
    }
}