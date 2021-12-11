<?php

namespace MedDocs\Entity;

use MedDocs\Entity\AbstractEntity;

class Exam extends AbstractEntity
{
    /**
     * @var string
     */
    protected $id;

    /**
     * @var \DateTime
     */
    protected $date;

    /**
     * @var string
     */
    protected $laboratoryId;

    /**
     * @var string
     */
    protected $userId;

    /**
     * @var string
     */
    protected $type;

    /**
     * @var string
     */
    protected $result;

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

    public function getLaboratoryId(): string
    {
        return $this->laboratoryId;
    }

    public function setLaboratoryId(string $laboratoryId): self
    {
        $this->laboratoryId = $laboratoryId;

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

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

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