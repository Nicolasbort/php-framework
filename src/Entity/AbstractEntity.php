<?php
namespace MedDocs\Entity;

abstract class AbstractEntity
{
    abstract public function getId(): ?string;

    abstract public function setId(?string $id): self;

    public function getProperties()
    {
        return get_object_vars($this);
    }
}