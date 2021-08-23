<?php

require_once "src/Controllers/BaseController.php";

class SiteController extends BaseController
{
    public function home()
    {
        $session = $this->getSession();

        $params = [
            'user' => $session->getSession('user')
        ];

        return $this->render('home', $params);
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