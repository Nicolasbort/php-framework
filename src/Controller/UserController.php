<?php

namespace MedDocs\Controller;

use MedDocs\Repository\UserRepository;

class UserController extends BaseController
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    public function __construct()
    {
        $this->userRepository = new UserRepository();
    }

    public function list()
    {
        $data = $this->getRequest()->getQuery();

        return $this->userRepository->findBy(['role' => $data['role']]);
    }

    public function update()
    {
        $data = $this->getRequest()->getBody();
        
        $id = $data['id'] ?? null;
        $email = $data['email'] ?? null;
        $password = $data['password'] ?? null;

        if (!$email || !$password || !$id) {
            $this->setFlash('error', 'Credenciais de usuário inválidas');
            return $this->getResponse()->redirect('/profile');
        }

        $user = $this->userRepository->findOneBy(['email' => $email]);

        if (!$user || !$user->verifyPassword($password)) {
            $this->setFlash('error', 'Senha inválida');
            return $this->getResponse()->redirect('/profile');
        }

        if (isset($data['name'])) {
            $user->setName($data['name']);
        }

        if (isset($data['email'])) {
            $user->setEmail($data['email']);
        }

        if (isset($data['role'])) {
            $user->setRole($data['role']);
        }

        $this->userRepository->update($user);

        $this->setSession('user', $user);

        $this->setFlash('success', "Alteração realizada com sucesso!");
        return $this->getResponse()->redirect('/profile');
    }
}

