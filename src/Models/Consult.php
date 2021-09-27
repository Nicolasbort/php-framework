<?php

require_once "src/Core/Model.php";

class Consult extends Model
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
    public $doctorId;

    public $doctorName;

    public $doctorDocument;

    /**
     * @var string $patientId
     */
    public $patientId;

    public $patientName;

    public $patientDocument;

    /**
     * @var string $patientId
     */
    public $receipt;

    /**
     * @var string $patientId
     */
    public $observation;

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

    public function setDate(string $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getDoctorId(): string
    {
        return $this->doctorId;
    }

    public function setDoctorId(string $doctorId): self
    {
        $this->doctorId = $doctorId;

        return $this;
    }

    public function getDoctorName(): string
    {
        return $this->doctorName;
    }

    public function getDoctorDocument(): string
    {
        return $this->doctorDocument;
    }

    public function getPatientId(): string
    {
        return $this->patientId;
    }

    public function setPatientId(string $patientId): string
    {
        $this->patientId = $patientId;

        return $this;
    }

    public function getPatientName(): string
    {
        return $this->patientName;
    }

    public function getPatientDocument(): string
    {
        return $this->patientDocument;
    }

    public function getReceipt(): string
    {
        return $this->receipt;
    }

    public function setReceipt(string $receipt): string
    {
        $this->receipt = $receipt;

        return $this;
    }

    public function getObservation(): string
    {
        return $this->observation ? $this->observation : '';
    }

    public function setObservation($observation): string
    {
        $this->observation = $observation;

        return $this;
    }
}