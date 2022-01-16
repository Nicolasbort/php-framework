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
     * @var User
     */
    public $doctor;

    /**
     * @var User
     */
    public $user;

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

        $this->date = $date;

        return $this;
    }

    public function getDoctor(): User
    {
        return $this->doctor;
    }

    public function setDoctor(User $doctor): self
    {
        $this->doctor = $doctor;

        return $this;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

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