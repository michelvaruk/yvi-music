<?php

namespace App\Controller\Edit;

use App\Entity\Project;
use App\Form\ProjectType;
use App\Repository\ProjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Cache\CacheInterface;

#[Route('edition/projet')]
class ProjectController extends AbstractController
{
    public function __construct(
        private CacheInterface $cache
    )
    {
        
    }

    #[Route('/', name: 'app_edit_project_index', methods: ['GET'])]
    public function index(ProjectRepository $project): Response {
        return $this->render('admin/project/index.html.twig', [
            'projects' => $project->findBy([], ['position' => 'ASC'])
        ]);
    }

    #[Route('/creer', name: 'app_edit_project_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response {
        $project = new Project();
        $form = $this->createForm(ProjectType::class, $project);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($project);
            $entityManager->flush();

            $this->cache->delete('projects');

            $this->addFlash('success', 'Le projet ' . $project->getTitle() . ' a été enregistré.');

            return $this->redirectToRoute('app_edit_project_index', [], Response::HTTP_SEE_OTHER);
        }
        return $this->render('admin/project/new.html.twig', [
            'form' => $form,
            'project' => $project,
        ]);
    }

    #[Route('/{id}/editer', name: 'app_edit_project_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Project $project, EntityManagerInterface $entityManager): Response {
        $form = $this->createForm(ProjectType::class, $project);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            $this->cache->delete('projects');
            $this->addFlash('success', 'Le projet ' . $project->getTitle() . ' a été modifié.');
            return $this->redirectToRoute('app_edit_project_index', [], Response::HTTP_SEE_OTHER);
        }
        return $this->render('admin/project/edit.html.twig', [
            'project' => $project,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/switch', name:'app_edit_project_switch', methods: ['POST'])]
    public function switch(Project $project, EntityManagerInterface $entityManager, Request $request): Response
    {
        if ($this->isCsrfTokenValid('switch' . $project->getId(), $request->getPayload()->get('_token'))) {
            if ($project->isActive()) {
                $project->setActive(false);
                $this->addFlash('success', 'Le projet ' . $project->getTitle() . ' a été désactivé.');
            } else {
                $project->setActive(true);
                $this->addFlash('success', 'Le projet ' . $project->getTitle() . ' a été activé.');
            }
            $entityManager->flush();
            $this->cache->delete('projects');
        }
        
        return $this->redirectToRoute('app_edit_project_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}', name: 'app_edit_project_delete', methods: ['POST'])]
    public function delete(Request $request, Project $project, EntityManagerInterface $entityManager,): Response
    {
        if ($this->isCsrfTokenValid('delete'.$project->getId(), $request->getPayload()->get('_token'))) {
            $entityManager->remove($project);
            $entityManager->flush();

            $this->cache->delete('projects');
            $this->addFlash('success', 'Le projet ' . $project->getTitle() . ' a été supprimé.');

        }

        return $this->redirectToRoute('app_edit_project_index', [], Response::HTTP_SEE_OTHER);
    }
}