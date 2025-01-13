<?php

namespace App\Controller;

use App\Repository\GalleryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/galerie')]
class GalleryController extends AbstractController
{
    #[Route('/', name: 'app_gallery', methods: ['GET'])]
    public function index(GalleryRepository $galleries) : Response {
        return $this->render('gallery/index.html.twig', [
            'galleries' => $galleries->findBy(['active' => true])
        ]);
    }
}