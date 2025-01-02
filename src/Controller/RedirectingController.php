<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class RedirectingController extends AbstractController {

    #[Route('/login/redirect', name: 'app_login_redirect')]
    public function loginRedirecting(): Response {

        $this -> denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $userRoles = $this -> getUser() -> getRoles();

        if (in_array('ROLE_ADMIN', $userRoles)) {
            return $this -> redirectToRoute('app_admin', [], Response::HTTP_SEE_OTHER);
        } else {
            return $this -> redirectToRoute('app_home', [], Response::HTTP_SEE_OTHER);
        }
    }
}

?>