<?php

namespace App\Controller;

use App\Entity\Movie;
use App\Entity\Note;
use App\Repository\NoteRepository;
use App\Repository\MovieRepository;
use Doctrine\Common\Persistence\ObjectManager;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Serializer\SerializerInterface;

class NoteApiController extends AbstractController
{

    /**
     * @var NoteRepository
     */
    private $repository;
    /**
     * @var MovieRepository
     */
    private $repositoryM;
    /**
     * @var ObjectManager
     */
    private $em;
    /** @var SerializerInterface */
    private $serializer;


    public function __construct(SerializerInterface $serializer, MovieRepository $repositoryM, NoteRepository $repository, ObjectManager $em)
    {
        $this->serializer = $serializer;
        $this->repository = $repository;
        $this->repositoryM = $repositoryM;
        $this->em = $em;
    }

    /**
     * @Rest\Post("/api/note/", name="api.note.new")
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
        $movie = $this->repositoryM->find($request->request->get('MovieID'));
        if ($movie === NULL)
        {
            return new JsonResponse(
                array(
                    'status' => 'Movie not found',
                    'message' => 'The movie cannot be found.'
                )
                , 404);
        };
        $note = new Note();
        $note->setScore($request->request->get('score'))
            ->setCommentary($request->request->get('commentary'))
            ->setCreatedAt(new \DateTime('today'))
            ->setMovie($movie)
            ->setUser($request->request->get('user'));
        $this->em->persist($note);
        $this->em->flush();
        $data = $this->serializer->serialize($note, 'json', [
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            }
        ]);
        $response = new JsonResponse();
        $response->headers->set('Access-Control-Allow-Origin', '*');
        $response->setStatusCode(201);
        $response->setJson($data);
        return $response;
    }

    /**
     * @Rest\Put("/api/note/{id}", name="api.note.edit")
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
        $movie = $this->repositoryM->find($request->request->get('MovieID'));
        if ($movie === NULL)
        {
            return new JsonResponse(
                array(
                    'status' => 'Movie not found',
                    'message' => 'The movie cannot be found.'
                )
                , 404);
        };
        try {
            $note = $this->repository->find($id);
            $note->setScore($request->request->get('score'))
                ->setCommentary($request->request->get('commentary'))
                ->setCreatedAt(new \DateTime('today'))
                ->setMovie($movie)
                ->setUser($request->request->get('user'));

            $this->em->flush();
            $data = $this->serializer->serialize($note, 'json', [
                'circular_reference_handler' => function ($object) {
                    return $object->getId();
                }
            ]);
            $response = new JsonResponse();
            $response->headers->set('Access-Control-Allow-Origin', '*');
            $response->setStatusCode(200);
            $response->setJson($data);
            return $response;
        }catch(\Exception $e){
            error_log($e->getMessage());
        }
    }

    /**
     * @Rest\Get("/api/note/", name="api.note.show")
     * @param Request $request
     * @return JsonResponse
     */
    public function getAllNotes(Request $request): JsonResponse
    {
        $notes = $this->repository->findAll();
        // to avoid the circular reference. When serializing, a movie has a set of note but a note has a reference to a movie too.
        // now he put the primary key of the movie and don't add the full movie object to note.
        $data = $this->serializer->serialize($notes, 'json', [
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
     * @Rest\Get("/api/note/{id}", name="api.note.index")
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */
    public function getOneNote(Request $request, $id): JsonResponse
    {
        $note = $this->repository->find($id);
        if ($note === NULL) {
            $response = new JsonResponse();
            $response->headers->set('Access-Control-Allow-Origin', '*');
            $response->setStatusCode(404);
            $response->setData('the note cannot be found');
            return $response;
        }
        $data = $this->serializer->serialize($note, 'json', [
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
     * @Rest\Delete("/api/note/{id}", name="api_note_delete")
     * @param $id
     * @return JsonResponse
     */
    public function delete($id)
    {
        $note = $this->repository->find($id);
        if ($note) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($note);
            $em->flush();
            $response = new JsonResponse(
                array(
                    'status' => 'DELETED',
                    'message' => 'This note has been deleted'
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
