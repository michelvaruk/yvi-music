<?php

namespace App\Controller;

use App\Repository\CalendarRepository;
use App\Repository\ProjectRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MainController extends AbstractController
{
    #[Route('/', name: 'app_main', methods: ['GET'])]
    public function index(CalendarRepository $calendars, ProjectRepository $projects): Response {
        return $this->render('main/index.html.twig', [
            'calendars' => $calendars->findFuture(3),
            'projects' => $projects->findBy(['active' => true])
        ]);
    }
}