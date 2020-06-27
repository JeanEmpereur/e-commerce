<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends AbstractController
{

    # Montre tous les utilisateurs créer (accessible que au ADMIN)
    public function index(UserRepository $userRepository)
    {
      return $this->render('user/index.html.twig', [
          'users' => $userRepository->findAll(),
      ]);
    }

    # Permet de faire l'inscription d'un nouveau compte
    public function signup(Request $request, UserPasswordEncoderInterface $encoder): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            dump($request);
            $user->setPassword(
                $encoder->encodePassword(
                    $user,
                    $user->getPassword())
            );
            $user->setRoles(["ROLE_USER"]);

            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('home', array(
              'success' => "Vous avez bien créer votre compte"
            ));
        }

        return $this->render('user/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    # Permet de regarder un seul compte en détails
    public function show(User $user): Response
    {
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }

    # Permet de modifier un seul compte
    public function edit(Request $request, User $user, UserPasswordEncoderInterface $encoder)
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword(
                $encoder->encodePassword(
                    $user,
                    $user->getPassword())
            );
            $user = $form->getData();
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('showUser', array(
              'success' => "Modification effectuer"
            ));
        }

        return $this->render('user/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    # Permet de modifier un seul compte (ajoute le role)
    public function editAdmin(Request $request, User $user, UserPasswordEncoderInterface $encoder)
    {
        $form = $this->createForm(AdminType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword(
                $encoder->encodePassword(
                    $user,
                    $user->getPassword())
            );
            $user = $form->getData();
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('users', array(
              'success' => "Modification du compte effectuer"
            ));
        }

        return $this->render('user/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    # Permet de supprimer un seul compte (que pour les admin)
    public function delete(Request $request, User $user): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('home', array(
          'success' => "Le compte a été supprimé"
        ));
    }

    # Permet de se connecter
    public function login (){
        return $this->render("user/login.html.twig");
    }

    # Permet de se déconnecter
    public function logout (){}
}
