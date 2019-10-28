<?php

namespace App\Controller;

// use App\Entity\Product;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProductsController extends AbstractController
{
    private $repo;

    public function __constuct(ProductRepository $repo)
    {
        $this->repo = $repo;
    }

    /**
     * @Route("/biens", name="products.index")
     * @return Response
     */
    public function index(): Response
    {
        // $products = new Product();
        // $products->setTitle('Iphone 11')
        //     ->setDescription('64G')
        //     ->setPrice(2000);

        // $em = $this->getDoctrine()->getManager();
        // $em->persist($products);
        // $em->flush();
        $products = $this->repo->findAll();
        dump($products);
        return $this->render('products/index.html.twig', [
            'current_menu' => 'products'
        ]);
    }
}
