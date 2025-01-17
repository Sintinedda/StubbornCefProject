<?php

namespace App\Controller;

use App\Service\CartService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CartController extends AbstractController
{

    #[Route('/cart', name: 'app_cart')]
    public function index(CartService $cartService): Response
    {
        return $this->render('cart/index.html.twig', [
            'cart' => $cartService->getTotal()
        ]);
    }

    #[Route('/cart/add/{id<\d+>}', name: 'app_cart_add')]
    public function addToCart(CartService $cartService, int $id): Response
    {
        $cartService->addToCart($id);
        
        return $this->redirectToRoute('app_cart');
    }

    #[Route('/cart/del/{id<\d+>}', name: 'app_cart_del')]
    public function delToCart(CartService $cartService, int $id): Response
    {
        $cartService->removeToCart($id);
        
        return $this->redirectToRoute('app_cart');
    }

    #[Route('/cart/delAll', name: 'app_cart_delAll')]
    public function delAll(CartService $cartService): Response
    {
        $cartService->removeCartAll();
        
        return $this->redirectToRoute('app_home');
    }
}
