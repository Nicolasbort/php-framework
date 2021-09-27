<?php

require_once "src/Controllers/BaseController.php";

class SiteController extends BaseController
{
    public function home()
    {
        $session = $this->getSession();

        $user = $session->getSession('user');

        if($user) { 
          $params = [
            'user' => $user
          ];
          return $this->render('home', $params);
        } else { 
          $params = [
            'user' => $user
          ];
          $this->setFlash('error', 'Você deve se credenciar para continuar','danger');
          return $this->render('login', $params);
        }
    }

    public function login()
    {
        return $this->render('login');
    }

    public function signup()
    {
        return $this->render('signup');
    }
}