<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use App\Form\ProductType;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminProductsController extends AbstractController
{
    private $repo;

    public function __construct(ProductRepository $repo)
    {
        $this->repo = $repo;
    }

    /**
     * @Route("/admin/products", name="admin.products.index")
     * @param Product $product
     * @return Response
     */
    public function index(): Response
    {
        $products = $this->repo->findAll();
        return $this->render('admin/products/index.html.twig', compact('products'));
    }

    /**
     * @Route("/admin/products/{id}", name="admin.products.edit")
     * @param Product $product
     * @return Response
     */
    public function edit(Product $product): Response
    {
        $form = $this->createForm(ProductType::class, $product);
        return $this->render('admin/products/edit.html.twig', [
            'product' => $product,
            'form' => $form->createView()
        ]);
    }
}
