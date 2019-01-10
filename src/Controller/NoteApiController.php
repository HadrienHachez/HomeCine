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
     * @Rest\Post("/api/note", name="api.note.new")
     * @param Request $request
     * @return JsonResponse
     */
    public function new(Request $request): JsonResponse
    {
        echo $request->request->get('MovieID');
        $movie = $this->repositoryM->find($request->request->get('MovieID'));
        $note = new Note();
        $note->setScore($request->request->get('score'))
            ->setCommentary($request->request->get('commentary'))
            ->setCreatedAt(new \DateTime('today'))
            ->setMovie($movie)
            ->setUser($request->request->get('user'));
        $this->em->persist($note);
        $this->em->flush();
        $data = $this->serializer->serialize($note, 'json');
        return new JsonResponse($data, 200, [], true);
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
        };
        $movie = $this->repositoryM->find($request->request->get('MovieID'));
        $note = $this->repository->find($id);
        $note->setScore($request->request->get('score'))
            ->setCommentary($request->request->get('commentary'))
            ->setCreatedAt(new \DateTime('today'))
            ->setMovie($movie)
            ->setUser($request->request->get('user'));
        $this->em->persist($note);
        $this->em->flush();
        $data = $this->serializer->serialize($note, 'json');
        return new JsonResponse($data, 200, [], true);
    }

    /**
     * @Rest\Get("/api/note/", name="api.note.show")
     * @param Request $request
     * @return JsonResponse
     */
    public function getAllNotes(Request $request): JsonResponse
    {
        $notes = $this->repository->findAll();
        $data = $this->serializer->serialize($notes, 'json');

        return new JsonResponse($data, 200, [], true);
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
        $data = $this->serializer->serialize($note, 'json');
        return new JsonResponse($data, 200, [], true);
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
