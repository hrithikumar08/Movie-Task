<?php

namespace App\Controller;

use App\Form\RegisterForm;
use App\Form\MovieForm;
use App\Form\UserAdminLogin;
use App\Entity\User;
use App\Entity\Movie;
use App\Entity\MovieRating;
use App\Entity\MovieMedia;
use App\Entity\Director;
use App\Entity\Category;
use App\Repository\UserRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class RegistrationController extends AbstractController
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/register', name: 'registration_start')]
    public function register(Request $request): Response
    {

        $user = new User();
        $form = $this->createForm(RegisterForm::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $role = $form->get('role')->getData();
            $user->setRole($role);

            $this->entityManager->persist($user);
            $this->entityManager->flush();

            return $this->redirectToRoute('loginPage');
        }

        return $this->render('registration.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/login', name: 'loginPage')]
    public function login(Request $request, UserRepository $userRepository): Response
    {

        $form = $this->createForm(UserAdminLogin::class); 
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $userRepository->findOneByEmail($form->get('email')->getData());

            if (!$user) {
                return $this->redirectToRoute('registration_start');
            }

            if ($form->get('password')->getData() != $user->getPassword()) {
                return $this->redirectToRoute('loginPage');
            }
            setcookie('role', $user->getRole(), 0, '/');
            if ($user->getRole() == 1) {
                return $this->redirectToRoute('adminPage', ['id' => $user->getId(),'role' => $user->getRole()]);
            } else {
                return $this->redirectToRoute('userdashboard', ['id' => $user->getId(),'role' => $user->getRole()]);
            }

        }

        return $this->render('login.html.twig', [
            'loginForm' => $form->createView(),
        ]);
    }

    #[Route('/userdash', name: 'userdashboard')]
    public function userdash(Request $request): Response
    {
        $userid = $request->get('id');
        $movie = new Movie();
        $movies = $this->entityManager->getRepository(Movie::class)->findAll();
        $user = $this->entityManager->getRepository(User::class)->findOneBy(['id' => $userid]);
        $userName = $user ? $user->getName() : '';  

        return $this->render('userdashboard.html.twig', [
            'movies' => $movies,
            'userid' => $userid,
            'userName' => $userName,
        ]);
    }


}
