<?php

require_once "src/Controllers/BaseController.php";
require_once "src/Controllers/ExamController.php";
require_once "src/Controllers/ConsultController.php";
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

    public function profile()
    {
        $session = $this->getSession();

        $user = $session->getSession('user');
        $params = [
          'user' => $user,
        ];
			 return $this->render('profile', $params);
    }

		public function patient()
		{
        $session = $this->getSession();
        $examController = new ExamController();
        $consultController = new consultController();

        $user = $session->getSession('user');
        $exams = $examController->getExamsByUserId($user->getId());
        $consults = $consultController->getConsultsByUserId($user->getId());
        $params = [
          'user' => $user,
          'exams' => $exams,
          'consults' => $consults,
        ];
			 return $this->render('patient/index', $params);
		}

		public function doctor()
		{
        $session = $this->getSession();
        $consultController = new consultController();
        $authController = new AuthController();

        $user = $session->getSession('user');
        $patients = $authController->getAllByRole('patient');
        $consults = $consultController->getConsultsByUserId($user->getId());
        $params = [
          'user' => $user,
          'consults' => $consults,
          'patients' => $patients
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