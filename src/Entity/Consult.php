<?php

namespace MedDocs\Entity;

use MedDocs\Entity\AbstractEntity;

class Consult extends AbstractEntity
{
    /**
     * @var string
     */
    public $id;

    /**
     * @var \DateTime
     */
    public $date;

    /**
     * @var string
     */
    public $doctorId;

    /**
     * @var string
     */
    public $userId;

    /**
     * @var string
     */
    public $receipt;

    /**
     * @var string
     */
    public $observation = null;

    public function getId(): ?string
    {
        return $this->id;
    }

    public function setId(?string $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getDate(bool $asDateTime = false)
    {
        if ($asDateTime) {
            return $this->date;
        }

        return $this->date->format('Y-m-d H:i:s');
    }

    public function setDate($date): self
    {
        if (is_string($date)) {
            $this->date = new \DateTime($date);

            return $this;
        }

        $this->date = date('Y-m-d H:i:s', $date->getTimestamp());

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

    public function getUserId(): string
    {
        return $this->userId;
    }

    public function setUserId(string $userId): self
    {
        $this->userId = $userId;

        return $this;
    }

    public function getReceipt(): string
    {
        return $this->receipt;
    }

    public function setReceipt(string $receipt): self
    {
        $this->receipt = $receipt;

        return $this;
    }

    public function getObservation(): ?string
    {
        return $this->observation;
    }

    public function setObservation(?string $observation): self
    {
        $this->observation = $observation;

        return $this;
    }
}