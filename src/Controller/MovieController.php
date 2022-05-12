<?php

namespace App\Controller;

use App\Entity\Movie;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MovieController extends AbstractController
{
    /**
     * @Route("/movie", name="app_movie")
     */
    public function index(ManagerRegistry $registry): Response
    {

        $movies = $registry->getRepository(Movie::class)->findAll();


        return $this->render('movie/index.html.twig', [
            'movies' => $movies
        ]);
    }
    
}
