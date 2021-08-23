<?php

require_once "src/Controllers/BaseController.php";

class SiteController extends BaseController
{
    public function home()
    {
        $params = [
            'name' => 'Nicolas'
        ];

        return $this->render('home', $params);
    }

    public function login()
    {
        return $this->render('login');
    }
}