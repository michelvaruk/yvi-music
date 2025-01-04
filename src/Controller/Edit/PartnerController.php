<?php

namespace App\Controller\Edit;

use App\Entity\Partner;
use App\Form\PartnerType;
use App\Repository\PartnerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Cache\CacheInterface;

#[Route('edition/endorsment')]
class PartnerController extends AbstractController
{
    public function __construct(
        private CacheInterface $cache
    )
    {
        
    }
    #[Route('/', name:'app_edit_partner_index', methods:['GET'])]
    public function index(PartnerRepository $partnerRepository): Response {
        return $this->render('admin/partner/index.html.twig', [
            'partners' => $partnerRepository->findAll()
        ]);
    }

    #[Route('/creer', name: 'app_edit_partner_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response {
        $partner = new Partner();
        $form = $this->createForm(PartnerType::class, $partner);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($partner);
            $entityManager->flush();

            $this->cache->delete('partners');
            $this->addFlash('success', 'Le partenaire ' . $partner->getTitle() . ' a été enregistré.');

            return $this->redirectToRoute('app_edit_partner_index', [], Response::HTTP_SEE_OTHER);
        }
        return $this->render('admin/partner/new.html.twig', [
            'form' => $form,
            'partner' => $partner,
        ]);
    }

    #[Route('/{id}/editer', name: 'app_edit_partner_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Partner $partner, EntityManagerInterface $entityManager): Response {
        $form = $this->createForm(PartnerType::class, $partner);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $this->cache->delete('partners');
            $this->addFlash('success', 'Le partneaire ' . $partner->getTitle() . ' a été modifié.');
            return $this->redirectToRoute('app_edit_partner_index', [], Response::HTTP_SEE_OTHER);
        }
        return $this->render('admin/partner/edit.html.twig', [
            'partner' => $partner,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_edit_partner_delete', methods: ['POST'])]
    public function delete(Request $request, Partner $partner, EntityManagerInterface $entityManager,): Response
    {
        if ($this->isCsrfTokenValid('delete'.$partner->getId(), $request->getPayload()->get('_token'))) {
            $entityManager->remove($partner);
            $entityManager->flush();

            $this->cache->delete('partners');
            $this->addFlash('success', 'Le partenaire ' . $partner->getTitle() . ' a été supprimé.');
        }

        return $this->redirectToRoute('app_edit_partner_index', [], Response::HTTP_SEE_OTHER);
    }
}