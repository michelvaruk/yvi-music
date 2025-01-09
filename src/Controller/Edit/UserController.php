<?php

namespace App\Controller\Edit;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\ResetPasswordRequestRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Uid\Uuid;

#[IsGranted('ROLE_ADMIN', message: 'Cette section est réservée aux administrateurs.')]
#[Route('/edition/utilisateurs')]
class UserController extends AbstractController
{
    public function __construct(
        private UserRepository $userRepository,
    ){}

    #[Route('/', name: 'app_edit_user_index', methods: ['GET'])]
    public function index(UserRepository $user): Response
    {
        return $this->render('admin/user/index.html.twig', [
            'users' => $user->findAll()
        ]);
    }

    
    #[Route('/creer', name: 'app_edit_user_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $em, UserPasswordHasherInterface $hasher, MailerInterface $mailerInterface): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $clearPassword = Uuid::v7();
            $user
                ->setPassword($hasher->hashPassword($user,$clearPassword))
                ->setRoles(['ROLE_ADMIN'])
            ;

            $em->persist($user);
            $em->flush();


            $email = (new TemplatedEmail())
                ->from(new Address($this->getParameter('app.mail_sender'), '"Yvi-Music"'))
                ->to($user->getEmail())
                ->subject('Création de votre compte Yvi-Music')

                // path of the Twig template to render
                ->htmlTemplate('emails/new_user.html.twig')

                ->text('Votre compte Yvi-Music vient d\'être créé. Merci de bien vouloir vous connecter à l\'adresse ' . $this->getParameter('app.site_base_url') . $this->generateUrl('app_forgot_password_request') . '.')

                ->context([
                    'user' => $user,
                ])
            ;

            try {
                $mailerInterface->send($email);
                $this->addFlash('success', 'L\'utilisateur ' . $user->getEmail() . ' a bien été enregistré. Un email lui a été transmis afin de créer son mot de passe.');
            } catch (TransportExceptionInterface $e) {
                $this->addFlash('alert', 'L\'email n\' a pas pu être envoyé pour la raison suivante : ' . $e);
            }

            return $this->redirectToRoute('app_edit_user_index', [], Response::HTTP_SEE_OTHER);
        }
        return $this->render('admin/user/new.html.twig', [
            'user' => $user,
            'form' => $form
        ]);
    }

    #[Route('/{id}', name:'app_edit_user_delete', methods: ['POST'])]
    public function delete(Request $request, User $user, EntityManagerInterface $entityManager,  ResetPasswordRequestRepository $resetPasswordRequestRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->getPayload()->get('_token'))) {
            if(!$this->isLastAdmin($user->getRoles())) {
                // Supprimer les instances de Reset Password de l'utilisateur !!!
                $resetPasswordUsers = $resetPasswordRequestRepository->findBy(['user' => $user->getId()]);
                if (count($resetPasswordUsers) > 0) {
                    foreach($resetPasswordUsers as $resetPasswordUser) {
                        $entityManager->remove($resetPasswordUser);
                        $entityManager->flush();
                    }
                }
                $entityManager->remove($user);
                $entityManager->flush();
                
                $this->addFlash('success', 'L\'utilisateur ' . ucwords($user->getEmail()) . ' a été supprimé avec succès.');
                return $this->redirectToRoute('app_edit_user_index', [], Response::HTTP_SEE_OTHER);
            }
            $this->addFlash('alert', 'L\'utilisateur ' . ucwords($user->getEmail()) . ' n\'a pas pu être supprimé. Assurez-vous qu\'il ne s\'agisse pas du dernier administarteur.');

        }

        return $this->redirectToRoute('app_edit_user_index', [], Response::HTTP_SEE_OTHER);
    }

    private function isLastAdmin(array $roles) : bool
    {

        if(in_array('ROLE_ADMIN', $roles)) {
            if(count($this->userRepository->findByRole('ROLE_ADMIN')) == 1) {
                return true;
            }
        }
        return false;
    }
}