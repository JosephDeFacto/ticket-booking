<?php

namespace App\Controller\Admin;

use App\Entity\Movie;
use App\Form\MovieType;
use App\Repository\MovieRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MovieController extends AbstractController
{
    /**
     * @Route("/", name="admin_index")
     */
    // find all movies
    public function index(MovieRepository $movieRepository): Response
    {
        $movies = $movieRepository->findAll();

        return $this->render('admin/index.html.twig', [
            'movies' => $movies,
        ]);
    }

    /**
     * @Route("new_movie", name="movie_create")
     */
    public function newMovie(Request $request, ManagerRegistry $registry)
    {
        $movie = new Movie();

        $form = $this->createForm(MovieType::class, $movie);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager = $registry->getManager();

            $entityManager->persist($movie);
            $entityManager->flush();

            return $this->redirectToRoute('admin_index');
        }

        return $this->render('admin/new.html.twig', [
            'movie' => $movie,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("edit_movie/{id}", name="movie_edit")
     */
    public function edit(Request $request, MovieRepository $movieRepository, ManagerRegistry $registry): Response
    {
        $id = $request->attributes->get('id');
        $movie = $movieRepository->find($id);
        $form = $this->createForm(MovieType::class, $movie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager = $registry->getManager();
            $entityManager->flush();

            return $this->redirectToRoute('movie_edit', ['id' => $movie->getId()]);
        }

        return $this->render('admin/edit.html.twig', [
            'movie' => $movie,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("delete_movie/{id}", name="movie_delete")
     */
    public function delete(Request $request, MovieRepository $movieRepository, ManagerRegistry $registry)
    {
        $id = $request->attributes->get('id');
        $movie = $movieRepository->find($id);

        $entityManager = $registry->getManager();
        $entityManager->remove($movie);
        $entityManager->flush();

        return $this->redirectToRoute('admin_index');
    }

    /**
     * @Route("delete_all", name="movies_delete")
     */
    public function deleteAll(Request $request, MovieRepository $movieRepository, ManagerRegistry $registry)
    {
        $movie = $movieRepository->findAll();

        $entityManager = $registry->getManager();
        $entityManager->remove((object)$movie);

        return $this->redirectToRoute('admin_index');
    }
}