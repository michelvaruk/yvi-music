<?php

namespace App\Controller;

use App\Entity\Project;
use App\Repository\ProjectRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/projet')]
class ProjectController extends AbstractController
{
    #[Route('/{id}-{slug}', name:'app_project_show', methods: ['GET'])]
    public function show(Project $project, string $slug): Response {
        if ($project->getSlug() != $slug || !$project->isActive()) {
            throw $this->createNotFoundException('La page que vous cherchez n\'a pas été trouvée, peut-être n\'existe-t-elle plus.');
        }
        // dd($project);
        return $this->render('project/show.html.twig', [
            'project' => $project
        ]);
    }
}