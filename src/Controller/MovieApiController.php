<?php

namespace App\Controller;

use App\Form\MovieType;
use App\Entity\Movie;
use App\Repository\MovieRepository;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Request;

use FOS\RestBundle\Controller\Annotations as Rest;

class MovieAPIController extends FOSRestController {

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
     * Creates an Article resource
     * @Rest\Post("/movies")
     * @param Request $request
     * @return View
     */
    public function postMovie(Request $request): View
    {
        $movie = new Movie();
        $movie->setTitle($request->get('title'));
        $this->em->persist($movie);
        $this->em->flush();
// In case our POST was a success we need to return a 201 HTTP CREATED response
        return View::create($movie, Response::HTTP_CREATED);
    }
}