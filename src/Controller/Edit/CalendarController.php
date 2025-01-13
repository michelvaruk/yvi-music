<?php

namespace App\Controller\Edit;

use App\Entity\Calendar;
use App\Form\CalendarType;
use App\Repository\CalendarRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('edition/evenement')]
class CalendarController extends AbstractController
{
    #[Route('/', name:'app_edit_calendar_index', methods:['GET'])]
    public function index(CalendarRepository $calendarRepository): Response {
        return $this->render('admin/calendar/index.html.twig', [
            'calendars' => $calendarRepository->findBy([], ['date' => 'ASC'])
        ]);
    }

    #[Route('/creer', name: 'app_edit_calendar_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response {
        $calendar = new Calendar();
        $form = $this->createForm(CalendarType::class, $calendar);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($calendar);
            $entityManager->flush();

            $this->addFlash('success', 'L\'événement ' . $calendar->getTitle() . ' a été enregistré.');

            return $this->redirectToRoute('app_edit_calendar_index', [], Response::HTTP_SEE_OTHER);
        }
        return $this->render('admin/calendar/new.html.twig', [
            'form' => $form,
            'calendar' => $calendar,
        ]);
    }

    #[Route('/{id}/editer', name: 'app_edit_calendar_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Calendar $calendar, EntityManagerInterface $entityManager): Response {
        $form = $this->createForm(CalendarType::class, $calendar);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            $this->addFlash('success', 'L\'événement ' . $calendar->getTitle() . ' a été modifié.');
            return $this->redirectToRoute('app_edit_calendar_index', [], Response::HTTP_SEE_OTHER);
        }
        return $this->render('admin/calendar/edit.html.twig', [
            'calendar' => $calendar,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/switch', name:'app_edit_calendar_switch', methods: ['POST'])]
    public function switch(Calendar $calendar, EntityManagerInterface $entityManager, Request $request): Response
    {
        if ($this->isCsrfTokenValid('switch' . $calendar->getId(), $request->getPayload()->get('_token'))) {
            if ($calendar->isActive()) {
                $calendar->setActive(false);
                $this->addFlash('success', 'Date ' . $calendar->getTitle() . ' désactivée.');
            } else {
                $calendar->setActive(true);
                $this->addFlash('success', 'Date ' . $calendar->getTitle() . ' activée.');
            }
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_edit_calendar_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}', name: 'app_edit_calendar_delete', methods: ['POST'])]
    public function delete(Request $request, Calendar $calendar, EntityManagerInterface $entityManager,): Response
    {
        if ($this->isCsrfTokenValid('delete'.$calendar->getId(), $request->getPayload()->get('_token'))) {
            $entityManager->remove($calendar);
            $entityManager->flush();

            $this->addFlash('success', 'L\'événement ' . $calendar->getTitle() . ' a été supprimé.');

        }

        return $this->redirectToRoute('app_edit_calendar_index', [], Response::HTTP_SEE_OTHER);
    }
}