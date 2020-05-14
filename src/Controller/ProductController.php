<?php

namespace App\Controller;

use App\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    /**
     * @Route("/products", name="getProducts")
     */
    public function getProduct(Request $request): Response
    {
        $products = $this->getDoctrine()->getRepository(Product::class)->findOneById(1);

        $result = array('success' => 1, 'product' => $products->getName());
        return $response = new Response(
            json_encode($result),
            Response::HTTP_OK,
            array('content-type' => 'json')
        );

    }
}
