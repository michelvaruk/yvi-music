<?php

namespace App\Controller;

use App\Repository\CalendarRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CalendarController extends AbstractController
{
    #[Route('/calendar', name: 'app_calendar', methods: ['GET'])]
    public function index(CalendarRepository $calendars): Response {
        return $this->render('calendar/index.html.twig', [
            'calendars' => $calendars->findFuture()
        ]);
    }
}