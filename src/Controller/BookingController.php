<?php

namespace App\Controller;

use App\Entity\Booking;
use App\Entity\Movie;
use App\Repository\BookingRepository;
use App\Repository\MovieRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BookingController extends AbstractController
{
    /**
     * @Route("/booking", name="app_booking")
     */
   /* public function index(BookingRepository $bookingRepository): Response
    {
        $bookingUser = new Booking();
        $movie = new Movie();

        return new Response(404);
    }*/

    /**
     * @Route("/booking/movie/{id}", name="booking_movie")
     */
    public function bookMovie(Request $request, ManagerRegistry $registry, MovieRepository $movieRepository): Response
    {

        $entityManager = $registry->getManager();



        $id = $request->attributes->get('id');
        $movie = $movieRepository->find($id);

        $user = $this->getUser();

        $booking = new Booking();
        $bookMovie = $booking->setMovie($movie);


        $entityManager->persist($bookMovie);
        $entityManager->flush();

       return $this->redirectToRoute('app_movie');

    }
}
