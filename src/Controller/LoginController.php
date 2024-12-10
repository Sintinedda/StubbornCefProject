<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

final class LoginController extends AbstractController
{
    #[Route('/login', name: 'app_login')]
    public function login(
        #[CurrentUser] ?User $user,
        AuthenticationUtils $helper
    ): Response {
        if ($user) {
            return $this -> redirectToRoute('');
        }

        return $this->render('login.html.twig', [
            'controller_name' => 'LoginController',
            'last_username' => $helper -> getLastUsername(),
            'error' => $helper -> getLastAuthenticationError()
        ]);
    }
}
