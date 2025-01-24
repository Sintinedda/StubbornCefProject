<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\OrderDetails;
use App\Entity\SweatShirt;
use App\Service\CartService;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class CartController extends AbstractController
{
    private EntityManagerInterface $entityManager;
    private UrlGeneratorInterface $urlGenerator;

    public function __construct(
        EntityManagerInterface $entityManager,
        UrlGeneratorInterface $urlGenerator
    ) {
        $this->entityManager = $entityManager;
        $this->urlGenerator = $urlGenerator;
    }

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
    #[Route('/cart/dec/{id<\d+>}', name: 'app_cart_dec')]
    public function decreaseToCart(CartService $cartService, int $id): Response
    {
        $cartService->decreaseToCart($id);
        
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

    #[Route('/cart/verify', name: 'app_cart_verify')]
    public function prepareOrder(CartService $cartService): Response
    {
        $datetime = New DateTime('now');
        $reference = $datetime->format('dmY'). '-' .uniqid();
        $order = New Order();
        $order->setUser($this->getUser());
        $order->setCreatedAt($datetime);
        $order->setPaid(0);
        $order->setReference($reference);
        $this->entityManager->persist($order);

        foreach ($cartService->getTotal() as $item) {
            $orderDetails = new OrderDetails();
            $orderDetails->setOrderProduct($order);
            $orderDetails->setQuantity($item['quantity']);
            $orderDetails->setProduct($item['product']->getSweat()->getName());
            $orderDetails->setPrice($item['product']->getSweat()->getPrice());
            $orderDetails->setSize($item['product']->getSize());
            $orderDetails->setTotalRecap($item['product']->getSweat()->getPrice() * $item['quantity']);
            
            $this->entityManager->persist($orderDetails);
            $this->entityManager->flush();

            $sweat = $this->entityManager->getRepository(SweatShirt::class)->findOneBy(['name' => $item['product']->getSweat()->getName()]);
            if ($item['product']->getSize() == 'xs' && $sweat->getStockXs() < $item['quantity'] ||
                $item['product']->getSize() == 's' && $sweat->getStockS() < $item['quantity'] ||
                $item['product']->getSize() == 'm' && $sweat->getStockM() < $item['quantity'] ||
                $item['product']->getSize() == 'l' && $sweat->getStockL() < $item['quantity'] ||
                $item['product']->getSize() == 'xl' && $sweat->getStockXl() < $item['quantity']
            ) {
                $message = "Votre commande n'est pas valide";
            } else {
                $message = 0;
            }
        }

        $this->entityManager->flush();

        return $this->render('cart/verify.html.twig', [
            'recapCart' => $cartService->getTotal(),
            'order' => $order,
            'user' => $this->getUser(),
            'message' => $message
        ]);
    }

    #[Route('/cart/create-session-stripe/{reference}', name: 'app_stripe')]
    public function StripeCheckout($reference): RedirectResponse 
    {
        $order = $this->entityManager->getRepository(Order::class)->findOneBy(['reference' => $reference]);

        $productStripe = [];

        if (!$order) {
            return $this->redirectToRoute('app_cart');
        }

        foreach ($order->getOrderDetails()->getValues() as $product) {
            $productStripe[] = [
                'price_data' => [
                    'currency' => 'eur',
                    'unit_amount' => $product->getPrice() * 100,
                    'product_data' => [
                        'name' => $product->getProduct(),
                    ]
                    ],
                    'quantity' => $product->getQuantity(),
                ];
        }
        Stripe::setApiKey($_ENV['STRIPE_SECRET']);

        $checkout_session = Session::create([
            'customer_email' => $this->getUser()->getEmail(),
            'payment_method_types' => ['card'],
            'line_items' => [[  
                $productStripe
            ]],
            'mode' => 'payment',
            'success_url' => $this->urlGenerator->generate('app_stripe_success', [
                'reference' => $order->getReference()
            ], UrlGeneratorInterface::ABSOLUTE_URL),
            'cancel_url' => $this->urlGenerator->generate('app_stripe_cancel', [
                'reference' => $order->getReference()
            ], UrlGeneratorInterface::ABSOLUTE_URL),
        ]);

        $order->setStripeSessionId($checkout_session);
        $this->entityManager->flush();

        return new RedirectResponse($checkout_session->url);
    }

    #[Route('/cart/success/{reference}', name: 'app_stripe_success')]
    public function StripeSuccess(
        $reference, 
        CartService $cartService,
    ): Response {

        $order = $this->entityManager->getRepository(Order::class)->findOneBy(['reference' => $reference]);

        if (!$order || $order->getUser() !== $this->getUser()) {
            return $this->redirectToRoute('app_cart');
        }

        foreach ($cartService->getTotal() as $item) {
            $sweat = $this->entityManager->getRepository(SweatShirt::class)->findOneBy(['name' => $item['product']->getSweat()->getName()]);

            if ($item['product']->getSize() == 'xs') {
                    $stock = $sweat->getStockXs();
                    $stock = $stock - $item['quantity'];
                    $sweat->setStockXs($stock);
            }
            if ($item['product']->getSize() == 's') {
                    $stock = $sweat->getStockS();
                    $stock = $stock - $item['quantity'];
                    $sweat->setStockS($stock);
            }
            if ($item['product']->getSize() == 'm') {
                    $stock = $sweat->getStockM();
                    $stock = $stock - $item['quantity'];
                    $sweat->setStockM($stock);
            }
            if ($item['product']->getSize() == 'l') {
                    $stock = $sweat->getStockL();
                    $stock = $stock - $item['quantity'];
                    $sweat->setStockL($stock);
            }
            if ($item['product']->getSize() == 'xl') {
                    $stock = $sweat->getStockXl();
                    $stock = $stock - $item['quantity'];
                    $sweat->setStockXl($stock);
            }
            $this->entityManager->flush();
        }

        if (!$order->isPaid()) {
            $cartService->removeCartAll();
            $order->setPaid(1);

            $this->entityManager->flush();
        }

        return $this->render('cart/success.html.twig', [
            'order' => $order,
            'details' => $order->getOrderdetails()->getValues()
        ]);
    }

    #[Route('/cart/cancel/{reference}', name: 'app_stripe_cancel')]
    public function StripeCancel(): Response
    {
        return $this->render('cart/cancel.html.twig');
    }
}
