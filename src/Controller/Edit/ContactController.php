<?php

namespace App\Controller\Edit;

use App\Entity\Contact;
use App\Repository\ContactRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('edition/messagerie')]
class ContactController extends AbstractController
{
    #[Route('/', name: 'app_edit_contact_index', methods: ['GET'])]
    public function index(ContactRepository $contacts): Response {
        return $this->render('admin/contact/index.html.twig', [
            'contacts' => $contacts->findBy([], ['createdAt' => 'DESC'])
        ]);
    }

    #[Route('/{id}', name: 'app_edit_contact_show', methods: ['GET'])]
    public function show(Contact $contact, EntityManagerInterface $em): Response
    {
        if (!$contact->isReadOk()) {
            $contact->setReadOk(1);
            $em->flush();
        }
        return $this->render('admin/contact/show.html.twig', [
            'contact' => $contact,
        ]);
    }
    #[Route('/lire/{id}', name: 'app_edit_contact_read', methods:['GET'])]
    public function read(Contact $contact, EntityManagerInterface $em): Response
    {
        if (!$contact->isReadOk()) {
            $contact->setReadOk(1);
        } else {
            $contact->setReadOk(0);
        }
        $em->flush();

        return $this->redirectToRoute('app_edit_contact_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}', name: 'app_edit_contact_delete', methods: ['POST'])]
    public function delete(Contact $contact, Request $request, EntityManagerInterface $em): Response
    {
        if ($this->isCsrfTokenValid('delete'.$contact->getId(), $request->getPayload()->get('_token'))) {
            $em->remove($contact);
            $em->flush();
        }

        return $this->redirectToRoute('app_edit_contact_index', [], Response::HTTP_SEE_OTHER);
    }
}