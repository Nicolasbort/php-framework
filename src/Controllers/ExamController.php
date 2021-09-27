<?php

require_once "src/Controllers/BaseController.php";
require_once "src/Core/Database.php";
require_once "src/Models/Exam.php";

class ExamController extends BaseController
{
    /**
     * @var Database $database
     */
    private $database;

    public function __construct()
    {
        $this->database = new Database();    
    }

    public function getExamsByUserId($userId): array
    {
        $key = $user['role'] == 'patient' ? 'idPatient' : 'idLaboratory';
        $exams = $this->database->findBy('exam', $key, $userId);
        return $exams ? $exams : [];
    }
    
    public function listExams()
    {
      
    }
    
    public function createExam($date, $laboratoryId, $patientId, $examType, $result)
    {
        $data = $this->getRequest()->getBody();

        $date         = $data['date'] ?? null;
        $laboratoryId = $data['laboratoryId'] ?? null;
        $patientId    = $data['patientId'] ?? null;
        $examType     = $data['examType'] ?? null;
        $result       = $data['result'] ?? null;
        if (!$date || !$laboratoryId || !$patientId || !$examType || !$result) {
            $this->setFlash('error', "Estão faltando informações para criar o exame.");
            return $this->getResponse()->redirect('/createExam');
        }

        $user = $this->database->findBy(new User(), 'id', $patientId);
        if (!$user) {
            $this->setFlash('error', "Paciente com id ".$patientId." não encontrado");
            return $this->getResponse()->redirect('/createExam');
        }

        $laboratory = $this->database->findBy(new User(), 'id', $laboratoryId);
        if (!$laboratory) {
            $this->setFlash('error', "Laboratório com id ".$laboratoryId." não encontrado");
            return $this->getResponse()->redirect('/createExam');
        }

        $exam = (new Exam())
            ->loadDate($data);

        $this->database->writeModel($exam);

        $this->setFlash('success', "Cadastro realizado com sucesso!");
        return $this->getResponse()->redirect('/createExam');
    }
}