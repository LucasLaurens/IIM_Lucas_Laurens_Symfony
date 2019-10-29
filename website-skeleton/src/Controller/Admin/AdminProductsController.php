<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use App\Form\ProductType;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\ProductRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class AdminProductsController extends AbstractController
{
    private $repo;
    private $em;

    public function __construct(ProductRepository $repo, ObjectManager $em)
    {
        $this->repo = $repo;
        $this->em = $em;
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
     * @Route("/admin/products/new", name="admin.products.new")
     * @param Product $product
     * @param Request $request
     * @return RedirectResponse
     */
    public function new(Request $request): Response
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($product);
            $this->em->flush();
            return $this->redirectToRoute('admin.products.index');
        }

        return $this->render('admin/products/new.html.twig', [
            'product' => $product,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/products/{id}", name="admin.products.edit", methods="GET|POST")
     * @param Product $product
     * @param Request $request
     * @return RedirectResponse
     */
    public function edit(Product $product, Request $request): Response
    {
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->flush();
            return $this->redirectToRoute('admin.products.index');
        }

        return $this->render('admin/products/edit.html.twig', [
            'product' => $product,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/products/{id}", name="admin.products.delete", methods="DELETE")
     * @param Product $product
     * @param Request $req
     * @return RedirectResponse
     */
    public function delete(Product $product, Request $req)
    {
        if ($this->isCsrfTokenValid('delete' . $product->getId(), $req->get('_token'))) {
            $this->em->remove($product);
            $this->em->flush();
        }
        return $this->redirectToRoute('admin.products.index');
    }
}
