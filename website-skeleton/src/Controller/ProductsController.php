<?php

namespace App\Controller;

// use App\Entity\Product;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProductsController extends AbstractController
{
    private $repo;

    public function __construct(ProductRepository $repo)
    {
        $this->repo = $repo;
    }

    /**
     * @Route("/products", name="products.index")
     * @param Product $product
     * @return Response
     */
    public function index(): Response
    {
        $products = $this->repo->findAll();
        return $this->render('products/index.html.twig', [
            'current_menu' => ' products',
            'products' => $products
        ]);
    }

    /**
     * @Route("/orderProducts", name="products.orderIndex")
     * @param Product $product
     * @return Response
     */
    public function orderIndex(): Response
    {
        $products =  $this->repo->findByPrice();
        return $this->render('products/index.html.twig', [
            'current_menu' => ' productsindex',
            'products' => $products,
        ]);
    }

    /**
     * @Route("/products/{slug}-{id}", name="products.show", requirements={"slug": "[a-z0-9\-]*"})
     * @return Response
     */
    public function show(Product $product, string $slug): Response
    {
        if ($product->getSlug() !== $slug) {
            return $this->redirectToRoute('products.show', [
                'id' => $product->getId(),
                'slug' => $product->getSlug(),
            ], 301);
        }
        return $this->render('products/show.html.twig', [
            'current_menu' => 'products',
            'product' => $product
        ]);
    }
}
