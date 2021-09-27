<?php

require_once "src/Core/Model.php";

class Exam extends Model
{
    /**
     * @var string $id
     */
    public $id;

    /**
     * @var string $date
     */
    public $date;

    /**
     * @var string $patientId
     */
    public $laboratoryId;

    /**
     * @var string $patientId
     */
    public $patientId;

    /**
     * @var string $patientId
     */
    public $examType;

    /**
     * @var string $patientId
     */
    public $result;

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getDate(): string
    {
      return $this->date;
    }

    public function getLaboratoryId(): string
    {
        return $this->laboratoryId;
    }

    public function setLaboratoryId(string $laboratoryId): self
    {
        $this->laboratoryId = $laboratoryId;

        return $this;
    }

    public function getPatientId(): string
    {
        return $this->patientId;
    }

    public function setPatientId(string $patientId): self
    {
        $this->patientId = $patientId;

        return $this;
    }

    public function getExamType(): string
    {
        return $this->examType;
    }

    public function setExamType(string $rexaM): self
    {
        $this->examType = $rexaM;

        return $this;
    }
    
    public function getResult(): string
    {
        return $this->result;
    }

    public function setResult(string $result): self
    {
        $this->result = $result;

        return $this;
    }
}