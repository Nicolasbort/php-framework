<?php

require_once "src/Controllers/BaseController.php";
require_once "src/Core/Database.php";
require_once "src/Models/User.php";

class AuthController extends BaseController
{
    /**
     * @var Database $database
     */
    private $database;

    public function __construct()
    {
        $this->database = new Database();    
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

        $user = $this->database->findBy(new User(), 'email', $email);

        if (!$user || !$user->verifyPassword($password)) {
            $this->setFlash('error', "Email ou senha inválidos.");
            return $this->getResponse()->redirect('/login');
        }

        $_SESSION[$user->getId()] = $user;

        $this->setFlash('success', "Login realizado com sucesso!");
        return $this->getResponse()->redirect('/');
    }

    public function signup()
    {
        $data = $this->getRequest()->getBody();

        $email = $data['email'] ?? null;
        $password = $data['password'] ?? null;

        if (!$email || !$password) {
            $this->setFlash('error', "Email ou senha inválidos.");
            $this->getResponse()->redirect('/users/login');
        }

        $user = $this->database->findBy(new User(), 'email', $email);

        if ($user) {
            $this->setFlash('error', "Este email está em uso");
            $this->getResponse()->redirect('/users/login');
        }

        $user = (new User())
            ->loadData($data)
            ->encodePassword($password);

        $this->database->writeModel($user);

        $_SESSION[$user->getId()] = $user;

        return "Cadastro realizado com sucesso";
    }
}