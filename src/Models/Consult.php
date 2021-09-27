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

    /**
     * @var string $patientId
     */
    public $patientId;

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

    public function getDoctorId(): string
    {
        return $this->doctorId;
    }

    public function setDoctorId(string $doctorId): self
    {
        $this->doctorId = $doctorId;

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

    public function getReceipt(): string
    {
        return $this->role;
    }

    public function setReceipt(string $receipt): self
    {
        $this->receipt = $receipt;

        return $this;
    }

    public function getObservation(): self
    {
        return $this->observation;
    }

    public function setObservation($observation): string
    {
        $this->observation = $observation;

        return $this;
    }
}