<?php

namespace MedDocs\Controller;

use MedDocs\Entity\User;
use MedDocs\Repository\UserRepository;

class AuthController extends BaseController
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    public function __construct()
    {
        $this->userRepository = new UserRepository();
    }

    public function login()
    {
        $data = $this->getRequest()->getBody();

        $email = $data['email'] ?? null;
        $password = $data['password'] ?? null;

        if (!$email || !$password) {
            $this->setFlash('error', "Email ou senha inválidos.");
            return $this->getResponse()->redirect('/login');
        }

        $user = $this->userRepository->findOneBy(['email' => $email]);

        if (!$user || !$user->verifyPassword($password)) {
            $this->setFlash('error', "Email ou senha inválidos.");
            return $this->getResponse()->redirect('/login');
        }

        $this->setSession('user', $user);

        $this->setFlash('success', "Login realizado com sucesso!");
        return $this->getResponse()->redirect('/');
    }

    public function signup()
    {
        $data = $this->getRequest()->getBody();

        $name = $data['name'] ?? null;
        $email = $data['email'] ?? null;
        $password = $data['password'] ?? null;
        $document = $data['document'] ?? null;
        $role = $data['role'] ?? 'patient';

        if (!$name || !$email || !$password || !$document) {
            $this->setFlash('error', "Insira todos dados de cadastro.");
            return $this->getResponse()->redirect('/signup');
        }

        $user = $this->userRepository->findOneBy(['email' => $email]);

        if ($user) {
            $this->setFlash('error', 'Este email está em uso');
            return $this->getResponse()->redirect('/signup');
        }

        $user = (new User)
            ->setEmail($email)
            ->setName($name)
            ->setPassword($password)
            ->setDocument($document)
            ->setRole($role);

        $success = $this->userRepository->create($user);

        if (!$success) {
            $this->setFlash('error', $this->userRepository->getError()->getMessage());
            return $this->getResponse()->redirect('/signup');
        }

        $this->setSession('user', $user);

        $this->setFlash('success', "Cadastro realizado com sucesso!");
        return $this->getResponse()->redirect('/');
    }

    public function logoff()
    {
        $this->setSession('user', null);
        return $this->getResponse()->redirect('/');
    }
}
