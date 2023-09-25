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

class CrudController extends AbstractController
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/edit-movie/{id}', name: 'edit_movie')]
    public function editMovie(Request $request, int $id): Response
    {
        $movie = $this->entityManager->getRepository(Movie::class)->find($id);

        if (!$movie) {
            throw $this->createNotFoundException('Movie not found');
        }

        if ($request->isMethod('POST')) {

            $formData = $request->request->all();

            $movie->setTitle($formData['title']);
            $movie->setDirectorId($formData['directorId']);
            $movie->setCategoryId($formData['categoryId']);
            $movie->setBudget($formData['budget']);
            $movie->setAddedDate(new DateTime($formData['addedDate']));
            $movie->setDescript($formData['descript']);

            $this->entityManager->persist($movie);
            $this->entityManager->flush();

            return $this->redirectToRoute('adminPage');

        }

        return $this->render('admindashboard.html.twig', [
            'movie' => $movie,
        ]);
    }

    #[Route('/delete-movie/{id}', name: 'delete_movie')]
    public function deleteMovie(Request $request, int $id): Response
    {
        $movie = $this->entityManager->getRepository(Movie::class)->find($id);

        if (!$movie) {
            throw $this->createNotFoundException('Movie not found');
        }

        // Delete the movie from the database
        $this->entityManager->remove($movie);
        $this->entityManager->flush();

        return $this->redirectToRoute('adminPage');
    }

    #[Route('/movie-profile/{id}', name: 'movie_profile')]
    public function movieProfile(Request $request, int $id): Response
    {
        $userid = $request->query->get('userid');
        $movie = $this->entityManager->getRepository(Movie::class)->find($id);
        $directorId = $movie->getDirectorId();
        $categoryId = $movie->getCategoryId();
        $userdetail = $this->entityManager->getRepository(User::class)->find($userid);
        $commentdetail = $this->entityManager->getRepository(MovieRating::class)->findOneBy([
            'user_id' => $userid,
            'movie_id' => $id,
        ]);
        
        $userDash = $this->entityManager->getRepository(User::class)->findOneBy(['id' => $userid]);
        $userDashName = $userDash ? $userDash->getName() : ''; 
        $commentdetailarray = $this->entityManager->getRepository(MovieRating::class)->findAll();
        $userNames = [];
        foreach ($commentdetailarray as $comdetail) {
            $commentedUserId = $comdetail->getUserId();
            $user = $this->entityManager->getRepository(User::class)->findOneBy(['id' => $commentedUserId]);
            $userName = $user ? $user->getName() : '';
            $userNames[$comdetail->getUserId()] = $userName;
        }

        $commentdetails = $this->entityManager->getRepository(MovieRating::class)->findBy(['movie_id' => $id]);
        $director = $this->entityManager->getRepository(Director::class)->findOneBy(['director_id' => $directorId]);
        // $directorName = $director ? $director->getDirectorName() : '';
        $directorName = '';
        if ($director !== null) {
            $directorName = $director->getDirectorName();
        }
        
        $category = $this->entityManager->getRepository(Category::class)->findOneBy(['category_id' => $categoryId]);
        // $categoryName = $category ? $category->getCategoryName() : '';
        $categoryName = '';
        if ($category !== null) {
            $categoryName = $category->getCategoryName();
        }

        if (!$movie) {
            throw $this->createNotFoundException('Movie not found');
        }

        return $this->render('movie_details.html.twig', [
            'movie' => $movie,
            'userid' => $userid,
            'userdetail' => $userdetail,
            'commentdetail' => $commentdetail,
            'commentdetails' => $commentdetails,
            'directorName' => $directorName,
            'categoryName' => $categoryName,
            'userNames' => $userNames,
            'userDashName' => $userDashName,
        ]);
    }

    #[Route('/movie/{id}/submit?userid={userid}', name: 'movie_submit')]
    public function movieSubmit(Request $request, int $id, int $userid): Response
    {
        $comment = $request->request->get('comment');
        $rating = $request->request->get('interactive_rating');

        $movieRating = new MovieRating();
        $movieRating->setComment($comment);
        $movieRating->setRating($rating);
        $movieRating->setUserId($userid);
        $movieRating->setMovieId($id);
        $movieRating->setCommentDate(new DateTime());

        $this->entityManager->persist($movieRating);
        $this->entityManager->flush();

        return $this->redirectToRoute('movie_profile', ['id' => $id, 'userid'=>$userid]);
    }

}
