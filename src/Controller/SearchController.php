<?php

namespace App\Controller;

use ErrorException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use AlloHelper;

class SearchController extends AbstractController
{
    /**
     * @Route("/search", name="search")
     */
    public function index()
    {
        $helper = new AlloHelper;

        $items = $helper->search('Harry Potter')->movie;
        foreach($items as $index=>$movie)
        {
            print_r($movie->getArray());
            echo "<br>";
        }

        return $this->render('search/index.html.twig', [
            'controller_name' => 'SearchController',
            'items' => $items
        ]);
    }
}
