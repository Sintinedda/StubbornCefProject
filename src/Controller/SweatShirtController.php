<?php

namespace App\Controller;

use App\Entity\SweatShirt;
use App\Form\SweatType;
use App\Repository\SweatShirtRepository;
use App\Service\FileUploader;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/sweat/shirt')]
final class SweatShirtController extends AbstractController
{
    #[Route(name: 'app_sweat_shirt_index', methods: ['GET'])]
    public function index(SweatShirtRepository $sweatShirtRepository): Response
    {
        return $this->render('sweat_shirt/index.html.twig', [
            'sweat_shirts' => $sweatShirtRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_sweat_new', methods: ['POST'])]
    public function new(
        Request $request, 
        EntityManagerInterface $entityManager,
        FileUploader $fileUploader
        ): Response {
        $newSweat = new SweatShirt();
        $addSweatForm = $this->createForm(SweatType::class, $newSweat);
        $addSweatForm->handleRequest($request);

        if ($addSweatForm->isSubmitted() && $addSweatForm->isValid()) {
            $newSweat = $addSweatForm -> getData();
            $imgFile = $addSweatForm -> get('img') -> getData();
            $imgFileName = $fileUploader -> upload($imgFile);
            $newSweat -> setImg($imgFileName);
            $entityManager->persist($newSweat);
            $entityManager->flush();
            $this -> addFlash('success', 'sweat.created_successfully');

            return $this->redirectToRoute('app_admin', [], Response::HTTP_SEE_OTHER);
        }
    }

    #[Route('/{id}', name: 'app_sweat_shirt_show', methods: ['GET'])]
    public function show(SweatShirt $sweatShirt): Response
    {
        return $this->render('sweat_shirt/show.html.twig', [
            'sweat_shirt' => $sweatShirt,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_sweat_edit', methods: ['POST'])]
    public function edit(
        Request $request,
        SweatShirt $sweatShirt,
        EntityManagerInterface $entityManager
    ): Response {

        $editForm = $this->createForm(SweatType::class, $sweatShirt);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_admin', [], Response::HTTP_SEE_OTHER);
        }
    }

    #[Route('/{id}', name: 'app_sweat_delete', methods: ['POST'])]
    public function delete(Request $request, SweatShirt $sweatShirt, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$sweatShirt->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($sweatShirt);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_sweat_shirt_index', [], Response::HTTP_SEE_OTHER);
    }
}
