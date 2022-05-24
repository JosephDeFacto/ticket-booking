<?php

namespace App\Controller;

use App\Entity\Movie;
use App\Entity\Show;
use App\Entity\User;
use App\Repository\MovieRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class MovieController extends AbstractController
{
    /**
     * @Route("/movie", name="app_movie")
     */
    public function index(ManagerRegistry $registry): Response
    {

        $movies = $registry->getRepository(Movie::class)->findAll();

        return $this->render('movie/index.html.twig', [
            'movies' => $movies,

        ]);
    }

    /**
     * @Route("/movie/detail/{id}", name="movie_detail")
     */
    public function getMovieById($id, ManagerRegistry $registry, $message = 'Not Found'): Response
    {
        $movie = $registry->getRepository(Movie::class)->find($id);

        foreach ($movie->getShows() as $show) {
            dd($show);
        }



       /* if (!$movie) {
            throw $this->createNotFoundException(
                $message);
        }*/

        return $this->render('movie/detail.html.twig', [
            'movie' => $movie,
            //'show' => $show
        ]);
    }

}
