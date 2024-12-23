<?php

namespace App\Controller;

use App\Entity\Calendar;
use App\Repository\CalendarRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/calendar')]
class CalendarController extends AbstractController
{
    #[Route('/', name: 'app_calendar', methods: ['GET'])]
    public function index(CalendarRepository $calendars): Response {
        return $this->render('calendar/index.html.twig', [
            'calendars' => $calendars->findFuture()
        ]);
    }

    #[Route('/{id}-{slug}', name: 'app_calendar_show', methods: ['GET'])]
    public function show(Calendar $calendar, string $slug) : Response {
        if ($calendar->getSlug() != $slug || !$calendar->isActive()) {
            throw $this->createNotFoundException('La page que vous cherchez n\'a pas été trouvée, peut-être n\'existe-t-elle plus.');
        }
        return $this->render('calendar/show.html.twig', [
            'calendar' => $calendar
        ]);
    }
}