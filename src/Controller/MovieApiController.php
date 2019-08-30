<?php

namespace App\Controller;

use App\Entity\Movie;
use App\Repository\MovieRepository;
use Doctrine\Common\Persistence\ObjectManager;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Serializer\SerializerInterface;

class MovieApiController extends AbstractController
{

    /**
     * @var MovieRepository
     */
    private $repository;
    /**
     * @var ObjectManager
     */
    private $em;
    /** @var SerializerInterface */
    private $serializer;


    public function __construct(SerializerInterface $serializer, MovieRepository $repository, ObjectManager $em)
    {
        $this->serializer = $serializer;
        $this->repository = $repository;
        $this->em = $em;
    }

    /**
     * @Rest\Post("/api/movie/", name="api.movie.new")
     * @param Request $request
     * @return JsonResponse
     */
    public function new(Request $request): JsonResponse
    {
        $content = $request->getContent();
        if (empty($content))
        {
            return new JsonResponse(
                array(
                    'status' => 'EMPTY',
                    'message' => 'The body of this request is empty.'
                )
            );
        }
        $movie = new Movie();
        $movie->setTitle($request->request->get('title'))
            ->setActors($request->request->get('actors'))
            ->setDirectors($request->request->get('directors'))
            ->setOriginalTitle($request->request->get('originalTitle'))
            ->setProductionYear($request->request->get('productionYear'));
        $this->em->persist($movie);
        $this->em->flush();
        $data = $this->serializer->serialize($movie, 'json');

        $response = new JsonResponse();
        $response->headers->set('Access-Control-Allow-Origin', '*');
        $response->setStatusCode(201);
        $response->setJson($data);
        return $response;
    }

    /**
     * @Rest\Put("/api/movie/{id}", name="api.movie.edit")
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */
    public function edit(Request $request, $id): JsonResponse
    {
        $content = $request->getContent();
        if (empty($content))
        {
            return new JsonResponse(
                array(
                    'status' => 'EMPTY',
                    'message' => 'The body of this request is empty.'
                )
            );
        }
        $movie = $this->repository->find($id);
        $movie->setTitle($request->request->get('title'))
            ->setActors($request->request->get('actors'))
            ->setDirectors($request->request->get('directors'))
            ->setOriginalTitle($request->request->get('originalTitle'))
            ->setProductionYear($request->request->get('productionYear'));
        $this->em->persist($movie);
        $this->em->flush();
        $data = $this->serializer->serialize($movie, 'json');
        $response = new JsonResponse();
        $response->headers->set('Access-Control-Allow-Origin', '*');
        $response->setStatusCode(200);
        $response->setJson($data);
        return $response;
    }

    /**
     * @Rest\Get("/api/movie/", name="api.movie.show")
     * @param Request $request
     * @return JsonResponse
     */
    public function getAllMovies(Request $request): JsonResponse
    {
        $movies = $this->repository->findAll();
        // to avoid the circular reference. When serializing, a movie has a set of note but a note has a reference to a movie too.
        // now he put the primary key of the movie and don't add the full movie object to note.
        $data = $this->serializer->serialize($movies, 'json', [
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            }
        ]);

        $response = new JsonResponse();
        $response->headers->set('Access-Control-Allow-Origin', '*');
        $response->setStatusCode(200);
        $response->setJson($data);
        return $response;
    }

    /**
     * @Rest\Get("/api/movie/{id}", name="api.movie.index")
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */
    public function getOneMovie(Request $request, $id): JsonResponse
    {
        $movie = $this->repository->find($id);
        if ($movie === NULL) {
            $response = new JsonResponse();
            $response->headers->set('Access-Control-Allow-Origin', '*');
            $response->setStatusCode(404);
            $response->setData('the movie cannot be found');
            return $response;
        }
        $data = $this->serializer->serialize($movie, 'json', [
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            }
        ]);
        $response = new JsonResponse();
        $response->headers->set('Access-Control-Allow-Origin', '*');
        $response->setStatusCode(200);
        $response->setJson($data);
        return $response;
    }

    /**
     * @Rest\Delete("/api/movie/{id}", name="api.note.delete")
     * @param $id
     * @return JsonResponse
     */
    public function delete($id): JsonResponse
    {
        $movie = $this->repository->find($id);
        if ($movie) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($movie);
            $em->flush();
            $response = new JsonResponse(
                array(
                    'status' => 'DELETED',
                    'message' => 'This movie has been deleted'
                )
            );
            $response->headers->set('Access-Control-Allow-Origin', '*');
            return $response;
        }
        else {
            return new JsonResponse(
                array(
                    'status' => 'NOT FOUND',
                    'message' => 'This note does not exist'
                )
            );
        }
    }
}
