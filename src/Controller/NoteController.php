<?php

namespace App\Controller;

use App\Form\NoteType;
use App\Entity\Note;
use App\Entity\Movie;
use App\Repository\NoteRepository;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class NoteController extends AbstractController
{
    /**
     * @var NoteRepository
     */
    private $repository;


    public function __construct(NoteRepository $repository, ObjectManager $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }

    /**
     * @Route("/note", name="note.index")
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $notes = $this->repository->findBy(array(),array('id' =>'desc'));
        $q = $request->query->get("q");
        if ($q) {
            $notes = $this->getTags($notes, $q);
        }
        return $this->render('note/index.html.twig', compact('notes'));
    }

    /**
     * @Route("/note/new", name="note.new")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function new(Request $request)
    {
        $note = new Note();
        $note->setCreatedAt(new \DateTime('today'));
        $form = $this->createForm(NoteType::class, $note);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $this->em->persist($note);
            $this->em->flush();
            return $this->redirectToRoute('note.index');
        }
        return $this->render('note/new.html.twig', [
            'note' => $note,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/note/edit/{id}", name="note.edit")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function edit(Note $note, Request $request)
    {
        $form = $this->createForm(NoteType::class, $note);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $this->em->flush();
            return $this->redirectToRoute('note.index');
        }
        return $this->render('note/new.html.twig', [
            'note' => $note,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/note/show/{id}", name="note.show")
     * @param Note $note
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function show(Note $note)
    {
        return $this->render('note/show.html.twig',[
            'note' => $note,
            'current_menu' => 'note'
        ]);
    }

    /**
     * @Route("/note/delete/{id}", name="note.delete")
     * @param Note $note
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function delete(Note $note)
    {
        $this->em->remove($note);
        $this->em->flush();
        return $this->redirectToRoute('note.index');
    }
}
