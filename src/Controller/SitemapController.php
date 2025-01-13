<?php

namespace App\Controller;

use App\Repository\CalendarRepository;
use App\Repository\ProjectRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class SitemapController extends AbstractController
{
    #[Route('/sitemap.xml', name: 'app_sitemap', defaults: ['_format' => 'xml'])]
    public function index(CalendarRepository $calendars, ProjectRepository $projects): Response
    {
        $urls = [];
        foreach ($calendars->findFuture() as $calendar) {
            $urls[] = [
                'loc' => $this->generateUrl('app_calendar_show', ['id' => $calendar->getId(), 'slug' => $calendar->getSlug()], UrlGeneratorInterface::ABSOLUTE_URL),
                'changefreq' => 'weekly',
                'priority' => 0.8,
            ];
        }
        foreach ($projects->findBy(['active' => true]) as $p) {
            $urls[] = [
                'loc' => $this->generateUrl('app_project_show', ['id' => $p->getId(), 'slug' => $p->getSlug()], UrlGeneratorInterface::ABSOLUTE_URL),
                'changefreq' => 'monthly',
                'priority' => 0.6,
            ];
        }
        $urls[] = [
            'loc' => $this->generateUrl('app_main', [], UrlGeneratorInterface::ABSOLUTE_URL),
            'changefreq' => 'weekly',
            'priority' => 1
        ];
        // $urls[] = [
        //     'loc' => $this->generateUrl('app_legal_notice', [], UrlGeneratorInterface::ABSOLUTE_URL),
        //     'changefreq' => 'yearly',
        //     'priority' => 0.1
        // ];
        $urls[] = [
            'loc' => $this->generateUrl('app_contact', [], UrlGeneratorInterface::ABSOLUTE_URL),
            'changefreq' => 'never',
            'priority' => 0.6
        ];
        $urls[] = [
            'loc' => $this->generateUrl('app_login', [], UrlGeneratorInterface::ABSOLUTE_URL),
            'changefreq' => 'never',
            'priority' => 0
        ];
        $urls[] = [
            'loc' => $this->generateUrl('app_calendar', [], UrlGeneratorInterface::ABSOLUTE_URL),
            'changefreq' => 'daily',
            'priority' => 0.9
        ];
        $urls[] = [
            'loc' => $this->generateUrl('app_project_index', [], UrlGeneratorInterface::ABSOLUTE_URL),
            'changefreq' => 'monthly',
            'priority' => 0.6
        ];
        
        return $this->render('sitemap.xml', [
            'urls' => $urls,
        ]);
    }
}
