<?php

namespace App\Controller\Edit;

use App\Form\SiteType;
use App\Repository\SiteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Cache\CacheInterface;

#[Route('edition/site')]
class SiteController extends AbstractController
{
    #[Route('/', name: 'app_edit_site_show', methods: ['GET'])]
    public function show(SiteRepository $site): Response
    {
        return $this->render('admin/site/show.html.twig', [
            'site' => $site->find(1),
        ]);
    }

    #[Route('/editer', name: 'app_edit_site_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, SiteRepository $siteRepository, EntityManagerInterface $entityManager, CacheInterface $cache): Response
    {
        $site = $siteRepository->find(1);
        $form = $this->createForm(SiteType::class, $site);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $cache->delete('siteInfo');

            $this->addFlash('success', 'Les informations du site ont bien été enregistrées.');

            return $this->redirectToRoute('app_edit_site_show', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/site/edit.html.twig', [
            'site' => $site,
            'form' => $form,
        ]);
    }
}