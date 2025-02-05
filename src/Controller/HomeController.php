<?php

namespace App\Controller;

use App\Entity\SweatShirt;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(EntityManagerInterface $entityManager): Response
    {   
        $repository = $entityManager->getRepository(SweatShirt::class);
        $topSweatShirts = $repository->findBy(['isTop'=> true]);
        return $this->render('home.html.twig', [
            'controller_name' => 'HomeController',
            'topSweatShirts' => $topSweatShirts,
            'user' => $this->getUser()
        ]);
    }
}
