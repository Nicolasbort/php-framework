<?php

namespace MedDocs\Controller;

use MedDocs\Controller\BaseController;
use MedDocs\Entity\Exam;
use MedDocs\Repository\ExamRepository;
use MedDocs\Repository\LaboratoryRepository;
use MedDocs\Repository\UserRepository;

class ExamController extends BaseController
{
    /**
     * @var ExamRepository
     */
    private $examRepository;

    public function __construct()
    {
        $this->examRepository = new ExamRepository();
        $this->userRepository = new UserRepository();  
        $this->laboratoryRepository = new LaboratoryRepository();  
    }

    public function list(): array
    {
        $filters = $this->getFilters($this->getRequest()->getQuery());

        return $this->examRepository->findBy($filters);
    }
    
    public function createExam()
    {
        $data = $this->getRequest()->getBody();

        $date         = $data['date'] ?? null;
        $laboratoryId = $data['laboratoryId'] ?? null;
        $userId       = $data['patientId'] ?? null;
        $type         = $data['examType'] ?? null;
        $result       = $data['result'] ?? null;

        if (!$date || !$laboratoryId || !$userId || !$type || !$result) {
            $this->setFlash('error', "Estão faltando informações para criar o exame. " . json_encode($data));
            return $this->getResponse()->redirect('/laboratory');
        }

        $user = $this->userRepository->find($userId);
        if (!isset($user)) {
            $this->setFlash('error', "Paciente com id '{$userId}' não encontrado");
            return $this->getResponse()->redirect('/doctor');
        }

        $laboratory = $this->laboratoryRepository->find($laboratoryId);
        if (!isset($laboratory)) {
            $this->setFlash('error', "Laboratório com id '{$laboratoryId}' não encontrado");
            return $this->getResponse()->redirect('/doctor');
        }

        $exam = (new Exam)
            ->setLaboratoryId($laboratoryId)
            ->setResult($result)
            ->setType($type)
            ->setUserId($userId)
            ->setDate(new \DateTime($date));

        $success = $this->examRepository->create($exam);

        $this->setFlash(
            $success ? 'success' : 'error', 
            $success 
                ? 'Cadastro realizado com sucesso!' 
                : 'Houve um erro ao cadastrar um exame. ' . $this->examRepository->getError()->getMessage()
        );
        return $this->getResponse()->redirect('/laboratory');
    }

    private function getFilters(array $query): array
    {
        $filters = [];

        if (isset($query['userId'])) {
            $filters['userId'] = $query['userId'];
        }

        return $filters;
    }
}