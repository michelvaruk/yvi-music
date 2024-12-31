<?php

namespace App\Controller;

use App\Entity\Project;
use App\Repository\CalendarRepository;
use App\Repository\ProjectRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/projet')]
class ProjectController extends AbstractController
{
    #[Route('/', name: 'app_project_index', methods: ['GET'])]
    public function index(ProjectRepository $projects): Response {
        return $this->render('project/index.html.twig', [
            'projects' => $projects->findBy(['active' => 1])
        ]);
    }

    #[Route('/{id}-{slug}', name:'app_project_show', methods: ['GET'])]
    public function show(Project $project, string $slug, CalendarRepository $calendar): Response {
        if ($project->getSlug() != $slug || !$project->isActive()) {
            throw $this->createNotFoundException('La page que vous cherchez n\'a pas été trouvée, peut-être n\'existe-t-elle plus.');
        }
        // dd($project);
        return $this->render('project/show.html.twig', [
            'project' => $project,
            'calendars' => $calendar->findFutureByProject($project->getId())
        ]);
    }
}