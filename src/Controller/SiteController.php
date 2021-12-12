<?php
namespace MedDocs\Controller;

use MedDocs\Repository\ConsultRepository;
use MedDocs\Repository\ExamRepository;
use MedDocs\Repository\UserRepository;
use MedDocs\helpers;


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

        $exams = $exameRepository->findBy([
            'user_id' => $user->getId(),
        ]);

        $consults = $consultRepository->findBy([
            'user_id' => $user->getId(),
        ]);
        

        $params = [
          'user' => $user,
          'exams' => $exams,
          'exams_by_month' => array_reduce($exams ?? [], 'reduceByMonth', []),
          'exams_by_year' => array_reduce($exams ?? [], 'reduceByYear', []),
          'consults' => $consults,
          'consults_by_month' => array_reduce($consults ?? [], 'reduceByMonth', []),
          'consults_by_year' => array_reduce($consults ?? [], 'reduceByYear', []),
        ];

        return $this->render('patient/index', $params);
    }
    

    public function doctor()
    {
        $session = $this->getSession();
        $userRepository = new UserRepository();
        $consultRepository = new ConsultRepository();

        $user = $_SESSION['user'];
        $patients = $userRepository->findBy([
            'role' => 'patient'
        ]);
        $consults = $consultRepository->findBy([
            'doctor_id' => $user->getId(),
        ]);
        
        $params = [
          'user' => $user,
          'consults' => $consults,
          'consults_by_month' => array_reduce($consults, 'reduceByMonth', []),
          'consults_by_year' => array_reduce($consults, 'reduceByYear', []),
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

        $patients = $userRepository->findBy([
            'role' => 'patient'
        ]);
        $exams = $examRepository->findBy([
            'laboratory_id' => $user->getId(),
        ]);

        $params = [
          'user' => $user,
          'exams' => $exams,
          'exams_by_month' => array_reduce($exams, 'reduceByMonth', []),
          'exams_by_year' => array_reduce($exams, 'reduceByYear', []),
          'patients' => $patients
        ];

        return $this->render('laboratory/index', $params);
    }
}