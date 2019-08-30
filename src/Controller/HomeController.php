<?php

namespace App\Controller;

use App\Entity\Movie;
use App\Repository\MovieRepository;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use AlloHelper;

class HomeController extends AbstractController
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
     * @Route("/", name="home")
     */
    public function index()
    {
        return $this->render('home/index.html.twig');
    }

    /**
     * @Route("/search", name="search")
     */
    public function search(Request $request)
    {
        $helper = new AlloHelper;
        $q = $request->query->get("q");
        $items = $helper->search($q)->movie;

        return $this->render('search/index.html.twig', [
            'controller_name' => 'SearchController',
            'items' => $items
        ]);
    }

    /**
     * @Route("/details/{id}", name="search.details")
     */
    public function details($id)
    {
        $helper = new AlloHelper;
        $movie = $helper->movie($id);

        return $this->render('search/details.html.twig',[
            'movie' => $movie
        ]);
    }

    /**
     * @Route("/details/add/{id}", name="search.add")
     */
    public function add($id)
    {
        $helper = new AlloHelper;
        $target = $helper->movie($id);
        $movie = new Movie();
        $movie->setActors($target->castingShort->actors)
            ->setDirectors($target->castingShort->directors)
            ->setCodeAllocine($target->code)
            ->setOriginalTitle($target->originalTitle)
            ->setProductionYear($target->productionYear)
            ->setTitle($target->title);
        $this->em->persist($movie);
        $this->em->flush();
        return $this->redirectToRoute('movie.index');
    }

}
