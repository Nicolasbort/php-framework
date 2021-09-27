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

    public function getAllByRole($role)
    {
      return $this->database->findBy(new User(), 'role', $role);
    }

    public function updateProfile()
    {
        $data = $this->getRequest()->getBody();
        
        $id = $data['id'] ?? null;
        $email = $data['email'] ?? null;
        $password = $data['password'] ?? null;

        if (!$email || !$password || !$id) {
            $this->setFlash('error', "Id de usuário e/ou senha inválida");
            return $this->getResponse()->redirect('/profile');
        }

        $user = $this->database->findOneBy(new User(), 'id', $id);

        if (!$user || !$user->verifyPassword($password)) {
            $this->setFlash('error', "Senha inválida.");
            return $this->getResponse()->redirect('/profile');
        }

        $user = (new User())
            ->loadData($data)
            ->encodePassword($password);

        $this->database->writeModel($user);

        Application::$app->session->setSession('user', $user);

        $this->setFlash('success', "Alteração realizada com sucesso!");
        return $this->getResponse()->redirect('/profile');
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

        $user = $this->database->findOneBy(new User(), 'email', $email);

        if (!$user || !$user->verifyPassword($password)) {
            $this->setFlash('error', "Email ou senha inválidos.");
            return $this->getResponse()->redirect('/login');
        }

        Application::$app->session->setSession('user', $user);

        $this->setFlash('success', "Login realizado com sucesso!");
        return $this->getResponse()->redirect('/' . $user->role);
    }

    public function logoff()
    {
				Application::$app->session->setSession('user', null);
        $this->setFlash('error', "Adeus! Volte sempre!");
        var_dump('aaaaaaa');
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

        $user = $this->database->findOneBy(new User(), 'email', $email);

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
        return $this->getResponse()->redirect('/' . $user->role);
    }
}