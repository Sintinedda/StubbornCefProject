<?php

namespace App\Controller;

use App\Data\SearchData;
use App\Entity\OrderItem;
use App\Entity\SweatShirt;
use App\Form\SearchType;
use App\Form\SweatBisType;
use App\Form\SweatType;
use App\Repository\SweatShirtRepository;
use App\Service\FileUploader;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/product')]
final class SweatShirtController extends AbstractController
{
    #[Route('s', name: 'app_sweat_index', methods: ['GET'])]
    public function index(
        SweatShirtRepository $sweatShirtRepository,
        Request $request   
    ): Response {
        $data = new SearchData();
        $form = $this->createForm(SearchType::class, $data);
        $form->handleRequest($request);
        $sweatShirt = $sweatShirtRepository->findSearch($data);
        return $this->render('sweat_shirt/index.html.twig', [
            'sweat_shirts' => $sweatShirt,
            'form' => $form->createView()
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

    #[Route('/{id}', name: 'app_sweat_show', methods: ['GET', 'POST'])]
    public function show(
        SweatShirt $sweatShirt,
        EntityManagerInterface $entityManager,
        Request $request
    ): Response {

        if ($request->getMethod() == Request::METHOD_POST) {
            $size = trim($request->get('size'));
            $existingItem = $entityManager->getRepository(OrderItem::class)->findOneBy(['sweat' => $sweatShirt, 'size' => $size]);

            if ($existingItem) {
                $item = $existingItem;
            } else {
                $item = new OrderItem();
                $item->setSweat($sweatShirt)->setSize($size);
                $entityManager->persist($item);
                $entityManager->flush();
            }

            return $this->redirectToRoute('app_cart_add', ['id' => $item->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->render('sweat_shirt/show.html.twig', [
            'sweat_shirt' => $sweatShirt,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_sweat_edit', methods: ['POST'])]
    public function edit(
        Request $request,
        SweatShirt $sweatShirt,
        EntityManagerInterface $entityManager,
        FileUploader $fileUploader
    ): Response {

        $editForm = $this->createForm(SweatBisType::class, $sweatShirt);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $imgFile = $editForm -> get('img') -> getData();
            if ($imgFile) { 
                $imgFileName = $fileUploader -> upload($imgFile);
                $sweatShirt -> setImg($imgFileName);
            }
            $entityManager->flush();

            return $this->redirectToRoute('app_admin', [], Response::HTTP_SEE_OTHER);
        }
    }

    #[Route('/{id}/delete', name: 'app_sweat_delete', methods: ['POST'])]
    public function delete(Request $request, SweatShirt $sweatShirt, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$sweatShirt->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($sweatShirt);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_admin', [], Response::HTTP_SEE_OTHER);
    }
}
