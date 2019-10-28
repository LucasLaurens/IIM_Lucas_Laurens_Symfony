<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     * @return Response
     */
    public function index(ProductRepository $repo): Response
    {
        $products = $repo->findLatest();
        return $this->render('pages/home.html.twig', [
            'products' => $products
        ]);
    }
}
