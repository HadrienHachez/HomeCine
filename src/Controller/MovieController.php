<?php

namespace App\Controller;

use App\Form\MovieType;
use App\Entity\Movie;
use App\Repository\MovieRepository;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class MovieController extends AbstractController
{
    /**
     * @var MovieRepository
     */
    private $repository;
    /**
     * @var ObjectManager
     */
    private $em;


    public function __construct(MovieRepository $repository, ObjectManager $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }

    /**
     * @Route("/movie", name="movie.index")
     */
    public function index()
    {
        $movies = $this->repository->findAll();
        return $this->render('movie/index.html.twig', compact('movies'));
    }

    /**
     * @Route("/movie/create", name="movie.new")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function new(Request $request)
    {
        $movie = new Movie();
        $form = $this->createForm(MovieType::class, $movie);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $this->em->persist($movie);
            $this->em->flush();
            return $this->redirectToRoute('movie.index');
        }
        return $this->render('movie/new.html.twig', [
            'movie' => $movie,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/movie/edit/{id}", name="movie.edit")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function edit(Movie $movie, Request $request)
    {
        $form = $this->createForm(MovieType::class, $movie);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $this->em->flush();
            return $this->redirectToRoute('movie.index');
        }
        return $this->render('movie/edit.html.twig', [
            'movie' => $movie,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/movie/show/{id}", name="movie.show")
     * @param Movie $movie
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function show(Movie $movie)
    {
        return $this->render('movie/show.html.twig',[
            'movie' => $movie,
            'current_menu' => 'movie'
        ]);
    }

    /**
     * @Route("/movie/delete/{id}", name="movie.delete")
     * @param Movie $movie
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function delete(Movie $movie)
    {
        $this->em->remove($movie);
        $this->em->flush();
        return $this->redirectToRoute('movie.index');
    }
}
