<?php

namespace MedDocs\Controller;

use MedDocs\Entity\Consult;
use MedDocs\Repository\ConsultRepository;
use MedDocs\Repository\DoctorRepository;
use MedDocs\Repository\UserRepository;

class ConsultController extends BaseController
{
    /**
     * @var ConsultRepository
     */
    private $consultRepository;

    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var DoctorRepository
     */
    private $doctorRepository;

    public function __construct()
    {
        $this->consultRepository = new ConsultRepository();  
        $this->userRepository = new UserRepository();  
        $this->doctorRepository = new DoctorRepository();  
    }

    public function list(): array
    {
        $filters = $this->getFilters($this->getRequest()->getQuery());

        return $this->consultRepository->findBy($filters);
    }

    public function create()
    {
        $data = $this->getRequest()->getBody();

        $date        = $data['date'] ?? null;
        $doctorId    = $data['doctorId'] ?? null;
        $userId      = $data['patientId'] ?? null;
        $receipt     = $data['receipt'] ?? null;
        $observation = $data['observation'] ?? '';

        if (!$date || !$doctorId || !$userId || !$receipt) {
            $this->setFlash('error', "Estão faltando informações para criar a consulta. " . json_encode($data));
            return $this->getResponse()->redirect('/doctor');
        }

        $user = $this->userRepository->find($userId);
        if (!isset($user)) {
            $this->setFlash('error', "Paciente com id '{$userId}' não encontrado");
            return $this->getResponse()->redirect('/doctor');
        }

        $doctor = $this->doctorRepository->find($doctorId);
        if (!isset($doctor)) {
            $this->setFlash('error', "Médico com id '{$doctorId}' não encontrado");
            return $this->getResponse()->redirect('/doctor');
        }

        $consult = (new Consult)
            ->setUserId($userId)
            ->setDoctorId($doctorId)
            ->setObservation($observation)
            ->setReceipt($receipt)
            ->setDate(new \DateTime($date));

        $success = $this->consultRepository->create($consult);

        $this->setFlash(
            $success ? 'success' : 'error', 
            $success 
                ? 'Cadastro realizado com sucesso!' 
                : 'Houve um erro ao cadastrar a consulta. ' . $this->consultRepository->getError()->getMessage()
        );
        
        return $this->getResponse()->redirect('/doctor');
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