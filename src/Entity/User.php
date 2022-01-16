<?php
namespace MedDocs\Entity;

use MedDocs\Entity\AbstractEntity;

class User extends AbstractEntity
{
    const ROLE_PATIENT = 'patient';
    const ROLE_LABORATORY = 'laboratory';
    const ROLE_DOCTOR = 'doctor';

    /**
     * @var string
     */
    protected $id;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $email;

    /**
     * @var string
     */
    protected $document;

    /**
     * @var string
     */
    protected $password;

    /**
     * @var string
     */
    protected $role = 'patient';

    public function getId(): ?string
    {
        return $this->id;
    }

    public function setId(?string $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password, bool $hashPassword = false): self
    {
        if ($hashPassword) {
            $this->password = password_hash($password, PASSWORD_BCRYPT);

            return $this;
        }

        $this->password = $password;

        return $this;
    }

    public function getRole(): string
    {
        return $this->role;
    }

    public function setRole(string $role): self
    {
        $this->role = $role;

        return $this;
    }

    public function getDocument(): string
    {
        return $this->document;
    }

    public function setDocument(string $document)
    {
        $this->document = $document;

        return $this;
    }

    public function verifyPassword($password): bool
    {
        return password_verify($password, $this->password);
    }

}