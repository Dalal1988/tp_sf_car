<?php

namespace App\Controller\Admin;

use App\Entity\User;
use Symfony\Component\Mime\Email;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminUserController extends AbstractController
{

    /**
     * @Route("admin/users", name="user_list")
     */
    public function userList(UserRepository $userRepository)
    {
        $users = $userRepository->findAll();

        return $this->render("admin/users.html.twig", ['users' => $users]);
    }

    public function adminUserCreate(
        Request $request,
        EntityManagerInterface $entityManagerInterface,
        MailerInterface $mailerInterface
    ) {
        $user = new User();

        $userForm = $this->createForm(UserType::class, $user);

        $userForm->handleRequest($request);

        if ($userForm->isSubmitted() && $userForm->isValid()) {


            $entityManagerInterface->persist($user);
            $entityManagerInterface->flush();

            $email = (new Email())
                ->from('test@test.com')
                ->to('test@test.fr')
                ->subject('Création d\'un auteur')
                ->html('<p>Vous êtes un nouvel auteur su le projet</p>');

            $mailerInterface->send($email);

            return $this->redirectToRoute("admin_car_list");
        }


        return $this->render("admin/userform.html.twig", ['userForm' => $userForm->createView()]);
    }

    
}