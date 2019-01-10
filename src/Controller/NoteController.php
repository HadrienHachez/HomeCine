<?php

namespace App\Controller;

use App\Form\NoteType;
use App\Entity\Note;
use App\Entity\Movie;
use App\Repository\NoteRepository;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class NoteController extends AbstractController
{
    /**
     * @var NoteRepository
     */
    private $repository;


    public function __construct(NoteRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @Route("/note", name="note.index")
     */
    public function index()
    {
        $notes = $this->repository->findAll();
        return $this->render('note/index.html.twig', compact('notes'));
    }

    /**
     * @Route("/note/create", name="note.new")
     * @param Request $request
     * @param Movie movie
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function new(Request $request, Movie $movie)
    {
        $note = new Note();
        $note->setCreatedAt(new \DateTime('today'));
        $note->setMovie()
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
        return $this->render('note/edit.html.twig', [
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
