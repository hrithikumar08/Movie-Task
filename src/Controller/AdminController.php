<?php

namespace App\Controller;

use App\Form\RegisterForm;
use App\Form\MovieForm;
use App\Form\DirectorForm;
use App\Form\CrewForm;
use App\Form\CategoryForm;
use App\Form\UserAdminLogin;
use App\Entity\User;
use App\Entity\Movie;
use App\Entity\MovieRating;
use App\Entity\MovieMedia;
use App\Entity\Director;
use App\Entity\Category;
use App\Entity\Crew;
use App\Repository\UserRepository;
use App\Repository\MovieRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
// use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class AdminController extends AbstractController
{
    private $entityManager, $movieRepository,$authorizationChecker;

    public function __construct(EntityManagerInterface $entityManager, MovieRepository $movieRepository, AuthorizationCheckerInterface $authorizationChecker)
    {
        $this->entityManager = $entityManager;
        $this->movieRepository = $movieRepository;
        $this->authorizationChecker = $authorizationChecker;
    }

    #[Route('/admin', name: 'adminPage')]
    // #[Security("is_granted('ROLE_ADMIN')")]
    // #[Security("ROLE_ADMIN")]
    public function admin(Request $request): Response
    {
        $adminid = $request->get('id');

        // Check if the user has ROLE_ADMIN
        // if (!$this->authorizationChecker->isGranted('ROLE_ADMIN')) {
        //     throw new AccessDeniedException('Access denied. You do not have the ROLE_ADMIN role.');
        // }

        $movie = new Movie();
        $category = new Category();
        $director = new Director();
        $crew = new Crew();

        $form = $this->createForm(MovieForm::class, $movie);
        $form1 = $this->createForm(CategoryForm::class, $category);
        $form2 = $this->createForm(DirectorForm::class, $director);
        $form3 = $this->createForm(CrewForm::class, $crew);

        $form->handleRequest($request);
        $form1->handleRequest($request);
        $form2->handleRequest($request);
        $form3->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $movie->setAddedDate(new DateTime());
            $this->entityManager->persist($movie);
            $this->entityManager->flush();
            
            $imageFile = $form->get('imageFile')->getData();

            if ($imageFile instanceof UploadedFile) {
                $filename = md5(uniqid()) . '.' . $imageFile->guessExtension();

                $imageFile->move(
                    $this->getParameter('images_directory'),
                    $filename
                );

                $movieMedia = new MovieMedia();
                $movieMedia->setImageName($filename);
                $movieMedia->setVideoName('NULL');
                $movieMedia->setMovieId($movie);

                $this->entityManager->persist($movieMedia);
                $this->entityManager->flush();
            }

        }

        if ($form1->isSubmitted() && $form1->isValid()) {

            // $category->setAddedDate(new DateTime());
            $this->entityManager->persist($category);
            $this->entityManager->flush();
        }

        if ($form2->isSubmitted() && $form2->isValid()) {

            // $director->setAddedDate(new DateTime());
            $this->entityManager->persist($director);
            $this->entityManager->flush();
        }

        if ($form3->isSubmitted() && $form3->isValid()) {
            // $director->setAddedDate(new DateTime());
            $this->entityManager->persist($crew);
            $this->entityManager->flush();
        }

        $user = $this->entityManager->getRepository(User::class)->findOneBy(['id' => $adminid]);
        $userName = $user ? $user->getName() : '';

        $movies = $this->entityManager->getRepository(Movie::class)->findAll();
        $directors = $this->entityManager->getRepository(Director::class)->findAll();
        $categories = $this->entityManager->getRepository(Category::class)->findAll();
        $crews = $this->entityManager->getRepository(Crew::class)->findAll();

        $directorNames = [];
        $categoryNames = [];
        $imageNames = [];

        foreach ($movies as $movie) {
            $directorId = $movie->getDirectorId();
            $director = $this->entityManager->getRepository(Director::class)->findOneBy(['director_id' => $directorId]);
            $directorName = $director ? $director->getDirectorName() : '';

            $categoryId = $movie->getCategoryId();
            $category = $this->entityManager->getRepository(Category::class)->findOneBy(['category_id' => $categoryId]);
            $categoryName = $category ? $category->getCategoryName() : '';

            $forImageId = $movie->getMovieId();
            $image = $this->entityManager->getRepository(MovieMedia::class)->findOneBy(['movie_id' => $forImageId]);
            $imageName = $image ? $image->getImageName() : '';

            $directorNames[$movie->getMovieId()] = $directorName;
            $categoryNames[$movie->getMovieId()] = $categoryName;
            $imageNames[$movie->getMovieId()] = $imageName;
        }
        return $this->render('admindashboard.html.twig', [
            'movieform' => $form->createView(),
            'directorform' => $form2->createView(),
            'categoryform' => $form1->createView(),
            'crewform' => $form3->createView(),
            'movies' => $movies,
            'directors' => $directors,
            'categories' => $categories,
            'crews' => $crews,
            'userName' => $userName,
            'directorNames' => $directorNames,
            'categoryNames' => $categoryNames,
            'imageNames' => $imageNames,
        ]);
    }

    #[Route('/adminedit/{id}', name: 'admin_edit')]
    // #[Security("is_granted('ROLE_ADMIN')")]
    public function adminEdit(Request $request, int $id): Response
    {

        $movieRatings = $this->entityManager->getRepository(MovieRating::class)->findBy(['movie_id' => $id]);
        $movies = $this->entityManager->getRepository(Movie::class)->findAll();
        $users = $this->entityManager->getRepository(User::class)->findAll();

        // $directors = $this->entityManager->getRepository(Director::class)->findAll();
        // $categories = $this->entityManager->getRepository(Category::class)->findAll();
        // $crews = $this->entityManager->getRepository(Crew::class)->findAll();

        $movieNames = [];
        $userNames = [];

        foreach ($movieRatings as $movieRating) {

            $userId = $movieRating->getUserId();
            $user = $this->entityManager->getRepository(User::class)->findOneBy(['id' => $userId]);
            $userName = $user ? $user->getName() : '';

            $movieId = $movieRating->getMovieId();
            $moviename = $this->entityManager->getRepository(Movie::class)->findOneBy(['movie_id' => $movieId]);
            $movieName = $moviename ? $moviename->getTitle() : '';

            $movieNames[$movieRating->getMovieId()] = $movieName;
            $userNames[$movieRating->getUserId()] = $userName;
        }

        return $this->render('adminedit.html.twig', [
            'movieRatings' => $movieRatings,
            'movies' => $movies,
            'users' => $users,
            // 'directors' => $directors,
            // 'categories' => $categories,
            // 'crews' => $crews,
            'movieNames' => $movieNames,
            'userNames' => $userNames,
        ]);
    }

    #[Route('/admineditsubmit/{id}', name: 'admin_edit_submit')]
    // #[Security("is_granted('ROLE_ADMIN')")]
    public function adminEditSubmit(Request $request, int $id, EntityManagerInterface $entityManager): Response
    {
        $movieRating = $this->entityManager->getRepository(MovieRating::class)->findOneBy(['rating_id' => $id]);

        if (!$movieRating) {
            throw $this->createNotFoundException('Movie rating not found.');
        }

        $movieRating->setRating($request->get('rating'));
        $movieRating->setComment($request->get('comment'));
        $movieRating->setUserId($request->get('userId'));
        $movieRating->setMovieId($request->get('movieId'));
        // $movieRating->setCommentDate($request->get('commentDate'));
        $movieRating->setCommentDate(new DateTime());

        $entityManager->flush();

        $this->addFlash('success', 'Movie rating updated successfully.');
        return $this->redirectToRoute('admin_edit', ['id' => $movieRating->getMovieId()]);
    }
}
