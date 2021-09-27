<?php

require_once "src/Controllers/BaseController.php";
require_once "src/Controllers/ExamController.php";
require_once "src/Controllers/AuthController.php";


class SiteController extends BaseController
{
    public function home()
    {
        $session = $this->getSession();

        $user = $session->getSession('user');
        $params = [
          'user' => $user
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

		public function patient()
		{
        $session = $this->getSession();

        $user = $session->getSession('user');
        $params = [
          'user' => $user
        ];
			 return $this->render('patient/index', $params);
		}

		public function doctor()
		{
        $session = $this->getSession();

        $user = $session->getSession('user');
        $params = [
          'user' => $user
        ];
			 return $this->render('doctor/index', $params);
		}

		public function laboratory()
		{
        $session = $this->getSession();
        $examController = new ExamController();
        $authController = new AuthController();

        $user = $session->getSession('user');
        $patients = $authController->getAllByRole('patient');
        $exams = $examController->getExamsByUserId($user->getId());
        $params = [
          'user' => $user,
          'exams' => $exams,
          'patients' => $patients
        ];
			 return $this->render('laboratory/index', $params);
		}
}