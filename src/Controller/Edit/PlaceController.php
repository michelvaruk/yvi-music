<?php

namespace App\Controller\Edit;

use App\Entity\Place;
use App\Form\PlaceType;
use App\Repository\PlaceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('edition/lieu')]
class PlaceController extends AbstractController
{
    #[Route('/', name: 'app_edit_place_index', methods: ['GET'])]
    public function index(PlaceRepository $places) : Response {
        return $this->render('admin/place/index.html.twig', [
            'places' => $places->findAll(),
        ]);
    }

    #[Route('/creer', name: 'app_edit_place_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager) : Response {
        $place = new Place();
        $form = $this->createForm(PlaceType::class, $place);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($place);
            $entityManager->flush();
            $this->addFlash('success', 'Le lieu ' . $place->getTitle() . ' a été ajouté.');
            return $this->redirectToRoute('app_edit_place_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/place/new.html.twig', [
            'form' => $form,
            'place' => $place,
        ]);
    }

    
    #[Route('/{id}/editer', name: 'app_edit_place_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Place $place, EntityManagerInterface $entityManager): Response {
        $form = $this->createForm(PlaceType::class, $place);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            // dd($project->getMembers());
            $entityManager->flush();
            $this->addFlash('success', 'Le lieu ' . $place->getTitle() . ' a été modifié.');
            return $this->redirectToRoute('app_edit_place_index', [], Response::HTTP_SEE_OTHER);
        }
        return $this->render('admin/place/edit.html.twig', [
            'place' => $place,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_edit_place_delete', methods: ['POST'])]
    public function delete(Request $request, Place $place, EntityManagerInterface $entityManager,): Response
    {
        if ($this->isCsrfTokenValid('delete'.$place->getId(), $request->getPayload()->get('_token'))) {
            $entityManager->remove($place);
            $entityManager->flush();

            $this->addFlash('success', 'Le lieu ' . $place->getTitle() . ' a été supprimé.');

        }

        return $this->redirectToRoute('app_edit_place_index', [], Response::HTTP_SEE_OTHER);
    }
}