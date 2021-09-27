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

        $user = $this->database->fineOneBy(new User(), 'email', $email);

        if (!$user || !$user->verifyPassword($password)) {
            $this->setFlash('error', "Email ou senha inválidos.");
            return $this->getResponse()->redirect('/login');
        }

        Application::$app->session->setSession('user', $user);

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
            return $this->getResponse()->redirect('/signup');
        }

        $user = $this->database->fineOneBy(new User(), 'email', $email);

        if ($user) {
            $this->setFlash('error', "Este email está em uso");
            return $this->getResponse()->redirect('/signup');
        }

        $user = (new User())
            ->loadData($data)
            ->encodePassword($password);

        $this->database->writeModel($user);

        Application::$app->session->setSession('user', $user);

        $this->setFlash('success', "Cadastro realizado com sucesso!");
        return $this->getResponse()->redirect('/');
    }
}