<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class NavController extends AbstractController
{
    public function nav($route): Response
    { 
        return $this->render('_nav.html.twig', [
            'user' => $this->getUser(),
            'route' => $route
        ]);
    }
}