<?php
namespace MedDocs\Controller;

use MedDocs\Repository\ConsultRepository;
use MedDocs\Repository\ExamRepository;
use MedDocs\Repository\UserRepository;

class SiteController extends BaseController
{
    public function home()
    {
        $session = $this->getSession();

        $params = [
          'user' => $session->getSession('user') ?? null
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

        $params = [
          'user' => $session->getSession('user') ?? null,
        ];

        return $this->render('profile', $params);
    }

    public function patient()
    {
        $session = $this->getSession();
        $exameRepository = new ExamRepository();
        $consultRepository = new ConsultRepository();

        $user = $session->getSession('user');

        $exams = $exameRepository->findAll([
            'user_id' => $user->getId(),
        ]);

        $consults = $consultRepository->findBy([
            'user_id' => $user->getId(),
        ]);

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
        $userRepository = new UserRepository();
        $consultRepository = new ConsultRepository();

        $user = $session->getSession('user');
        $patients = $userRepository->findAll();
        $consults = $consultRepository->findBy([
            'user_id' => $user->getId(),
        ]);
        
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
        $userRepository = new UserRepository();
        $examRepository = new ExamRepository();

        $user = $session->getSession('user');

        $patients = $userRepository->findAll();
        $exams = $examRepository->findBy([
            'user_id' => $user->getId(),
        ]);

        $params = [
          'user' => $user,
          'exams' => $exams,
          'patients' => $patients
        ];

        return $this->render('laboratory/index', $params);
    }
}