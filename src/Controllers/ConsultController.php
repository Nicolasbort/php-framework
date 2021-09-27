<?php

require_once "src/Controllers/BaseController.php";
require_once "src/Core/Database.php";
require_once "src/Models/Consult.php";

class ConsultController extends BaseController
{
    /**
     * @var Database $database
     */
    private $database;

    public function __construct()
    {
        $this->database = new Database();    
    }

    public function getConsultsByUserId($userId): array
    {
        $user = $this->database->findOneBy(new User(), 'id', $userId);
        $key = $user->role == 'patient' ? 'patientId' : 'doctorId';
        $exams = $this->database->findBy(new Consult(), $key, $userId);
        return $exams ? $exams : [];
    }

    public function createConsult()
    {
        $data = $this->getRequest()->getBody();

        $date         = $data['date'] ?? null;
        $doctorId     = $data['doctorId'] ?? null;
        $patientId    = $data['patientId'] ?? null;
        $receipt      = $data['receipt'] ?? null;
        $observation  = $data['observation'] ?? null;
        if (!$date || !$doctorId || !$patientId || !$receipt) {
            $this->setFlash('error', "Estão faltando informações para criar o exame.".json_encode($data));
            return $this->getResponse()->redirect('/doctor');
        }

        if(!$observation){
          $data['observation'] = '';
        }

        $user = $this->database->findOneBy(new User(), 'id', $patientId);
        if (!$user) {
            $this->setFlash('error', "Paciente com id ".$patientId." não encontrado");
            return $this->getResponse()->redirect('/doctor');
        }

        $data['patientName'] = $user->getName();
        $data['patientDocument'] = $user->getDocument();

        $doctor = $this->database->findOneBy(new User(), 'id', $doctorId);
        if (!$doctor) {
            $this->setFlash('error', "Médico com id ".$doctorId." não encontrado");
            return $this->getResponse()->redirect('/doctor');
        }

        $data['doctorName']     = $doctor->getName();
        $data['doctorDocument'] = $doctor->getDocument();

        $consult = (new Consult())
            ->loadData($data);

        $this->database->writeModel($consult);

        $this->setFlash('success', "Cadastro realizado com sucesso!");
        return $this->getResponse()->redirect('/doctor');
    }
}