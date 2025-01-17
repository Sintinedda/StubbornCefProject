<?php

namespace App\Controller;

use App\Entity\AdminUser;
use App\Entity\SweatShirt;
use App\Form\SweatType;
use App\Form\SweatBisType;
use App\Repository\SweatShirtRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class AdminController extends AbstractController
{
    #[Route('/admin', name: 'app_admin', methods: ['GET', 'POST']), IsGranted(AdminUser::ROLE_ADMIN)]
    public function index(
        #[CurrentUser] AdminUser $admin,
        SweatShirtRepository $sweats,
        Request $request,
    ): Response {

        $newSweat = new SweatShirt();
        $sweats = $sweats -> findAll();
        $addSweatForm = $this -> createForm(SweatType::class, $newSweat);
        $addSweatForm -> handleRequest($request);

        foreach ($sweats as $editSweat) {
            $editSweatForms = $this -> createForm(SweatBisType::class, $editSweat) -> createView();
            $arrayForms[] = $editSweatForms;
        }
        
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
            'admin' => $admin,
            'add_sweat_form' => $addSweatForm,
            'sweats' => $sweats,
            'array_forms' => $arrayForms
        ]);
    }
}
