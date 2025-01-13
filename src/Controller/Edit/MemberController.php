<?php

namespace App\Controller\Edit;

use App\Entity\Member;
use App\Form\MemberType;
use App\Repository\MemberRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('edition/musicien')]
class MemberController extends AbstractController
{
    #[Route('/', name:'app_edit_member_index', methods:['GET'])]
    public function index(MemberRepository $memberRepository): Response {
        return $this->render('admin/member/index.html.twig', [
            'members' => $memberRepository->findBy([], ['position' => 'ASC'])
        ]);
    }

    #[Route('/creer', name: 'app_edit_member_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response {
        $member = new Member();
        $form = $this->createForm(MemberType::class, $member);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($member);
            $entityManager->flush();

            $this->addFlash('success', 'Le musicien ' . ucfirst($member->getFirstname()) . ' ' . ucfirst($member->getLastname()) . ' a été enregistré.');

            return $this->redirectToRoute('app_edit_member_index', [], Response::HTTP_SEE_OTHER);
        }
        return $this->render('admin/member/new.html.twig', [
            'form' => $form,
            'member' => $member,
        ]);
    }

    #[Route('/{id}/editer', name: 'app_edit_member_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Member $member, EntityManagerInterface $entityManager): Response {
        $form = $this->createForm(MemberType::class, $member);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            $this->addFlash('success', 'Le musicien ' . $member->getFirstname() . ' ' . $member->getLastname() . ' a été modifié.');
            return $this->redirectToRoute('app_edit_member_index', [], Response::HTTP_SEE_OTHER);
        }
        return $this->render('admin/member/edit.html.twig', [
            'member' => $member,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/switch', name:'app_edit_member_switch', methods: ['POST'])]
    public function switch(Member $member, EntityManagerInterface $entityManager, Request $request): Response
    {
        if ($this->isCsrfTokenValid('switch' . $member->getId(), $request->getPayload()->get('_token'))) {
            if ($member->isActive()) {
                $member->setActive(false);
                $this->addFlash('success', 'Le musicien ' . $member->getFirstname() . ' ' . $member->getLastname() . ' a été désactivé.');
            } else {
                $member->setActive(true);
                $this->addFlash('success', 'Le musicien ' . $member->getFirstname() . ' ' . $member->getLastname() . ' a été activé.');
            }
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_edit_member_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}', name: 'app_edit_member_delete', methods: ['POST'])]
    public function delete(Request $request, Member $member, EntityManagerInterface $entityManager,): Response
    {
        if ($this->isCsrfTokenValid('delete'.$member->getId(), $request->getPayload()->get('_token'))) {
            $entityManager->remove($member);
            $entityManager->flush();

            $this->addFlash('success', 'Le musicien ' . $member->getFirstname() . ' ' . $member->getLastname() . ' a été supprimé.');

        }

        return $this->redirectToRoute('app_edit_member_index', [], Response::HTTP_SEE_OTHER);
    }
}