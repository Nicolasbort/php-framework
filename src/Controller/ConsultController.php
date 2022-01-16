<?php

namespace MedDocs\Controller;

use MedDocs\Entity\Consult;
use MedDocs\Entity\User;
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

    public function __construct()
    {
        $this->consultRepository = new ConsultRepository();  
        $this->userRepository = new UserRepository();  
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
        $patientId   = $data['patientId'] ?? null;
        $receipt     = $data['receipt'] ?? null;
        $observation = $data['observation'] ?? '';

        if (!$date || !$doctorId || !$patientId || !$receipt) {
            $this->setFlash('error', "Estão faltando informações para criar a consulta. " . json_encode($data));
            return $this->getResponse()->redirect('/doctor');
        }

        $patient = $this->userRepository->findOneBy([
            'id' => $patientId,
            'role' => User::ROLE_PATIENT
        ]);

        if (!isset($patient)) {
            $this->setFlash('error', "Paciente com id '{$patientId}' não encontrado");
            return $this->getResponse()->redirect('/doctor');
        }

        $doctor = $this->userRepository->findOneBy([
            'id' => $doctorId,
            'role' => User::ROLE_DOCTOR
        ]);

        if (!isset($doctor)) {
            $this->setFlash('error', "Médico com id '{$doctorId}' não encontrado");
            return $this->getResponse()->redirect('/doctor');
        }

        $consult = (new Consult)
            ->setUser($patient)
            ->setDoctor($doctor)
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