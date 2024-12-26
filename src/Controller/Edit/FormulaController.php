<?php

namespace App\Controller\Edit;

use App\Entity\Formula;
use App\Entity\Project;
use App\Form\FormulaType;
use App\Service\PositionService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('edition/formule')]
class FormulaController extends AbstractController
{
    public function __construct(
        private PositionService $positionService,
    )
    {
        
    }
    #[Route('/{id}/creer', name: 'app_edit_formula_new', methods: ['GET', 'POST'])]
    public function new(Project $project, Request $request, EntityManagerInterface $entityManager): Response {
        $formula = new Formula();
        $form = $this->createForm(FormulaType::class, $formula);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $formula
                ->setProject($project)
                ->setPosition($this->positionService->new($formula));
            $entityManager->persist($formula);
            $entityManager->flush();

            $this->addFlash('success', 'La formule ' . $formula->getTitle() . ' a été enregistrée.');

            return $this->redirectToRoute('app_edit_project_index', [], Response::HTTP_SEE_OTHER);
        }
        return $this->render('admin/formula/new.html.twig', [
            'form' => $form,
            'formula' => $formula,
        ]);
    }

    #[Route('/{id}/editer', name: 'app_edit_formula_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Formula $formula, EntityManagerInterface $entityManager): Response {
        $form = $this->createForm(FormulaType::class, $formula);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            $this->addFlash('success', 'La formule ' . $formula->getTitle() . ' a été modifiée.');
            return $this->redirectToRoute('app_edit_project_index', [], Response::HTTP_SEE_OTHER);
        }
        return $this->render('admin/formula/edit.html.twig', [
            'formula' => $formula,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/switch', name:'app_edit_formula_switch', methods: ['POST'])]
    public function switch(Formula $formula, EntityManagerInterface $entityManager, Request $request): Response
    {
        if ($this->isCsrfTokenValid('switch' . $formula->getId(), $request->getPayload()->get('_token'))) {
            if ($formula->isActive()) {
                $formula->setActive(false);
                $this->addFlash('success', 'La formule ' . $formula->getTitle() . ' a été désactivée.');
            } else {
                $formula->setActive(true);
                $this->addFlash('success', 'La formule ' . $formula->getTitle() . ' a été activée.');
            }
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_edit_project_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}/move/{direction}', name:'app_edit_formula_move', methods: ['POST'])]
    public function move(Formula $formula, Request $request, int $direction): Response
    {
        if ($this->isCsrfTokenValid('move' . $formula->getId(), $request->getPayload()->get('_token'))) {
            $move = $this->positionService->move($formula, $direction);
            if (!$move)
                $this->addFlash('alert', 'Le changement d\'ordre demandé n\'a pu s\'effectuer, merci de ré-essayer. En cas de nouvel échec, merci de prévenir l\'administrateur.');
        }
        return $this->redirectToRoute('app_edit_project_index', [], Response::HTTP_SEE_OTHER);
    }


    #[Route('/{id}', name: 'app_edit_formula_delete', methods: ['POST'])]
    public function delete(Request $request, Formula $formula, EntityManagerInterface $entityManager,): Response
    {
        if ($this->isCsrfTokenValid('delete'.$formula->getId(), $request->getPayload()->get('_token'))) {
            $this->positionService->remove($formula);
            $entityManager->remove($formula);
            $entityManager->flush();

            $this->addFlash('success', 'La formule ' . $formula->getTitle() . ' a été supprimée.');

        }

        return $this->redirectToRoute('app_edit_project_index', [], Response::HTTP_SEE_OTHER);
    }
}