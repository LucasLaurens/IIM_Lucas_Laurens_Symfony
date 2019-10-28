<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProductsController extends AbstractController
{

    /**
     * @Route("/biens", name="products.index")
     * @return Response
     */
    public function index(): Response
    {
        return $this->render('products/index.html.twig', [
            'current_menu' => 'products'
        ]);
    }
}
