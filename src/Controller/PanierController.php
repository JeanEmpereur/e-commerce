<?php

namespace App\Controller;

use App\Entity\Panier;
use App\Repository\PanierRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class PanierController extends AbstractController
{
    /**
     * @Route("/panier", name="panier")
     */
    public function index()
    {
        return $this->render('panier/index.html.twig', [
            'controller_name' => 'PanierController',
        ]);
    }

    public function add(Request $request, User $user): Response
    {
        $panier = new Panier();
        $panier->setUser($user);
        $panier->setDateAchat(new \DateTime);
        $panier->setEtat(False);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($panier);
        $entityManager->flush();

        return $this->redirectToRoute('home');
    }

    public function addPanier(Request $request, Panier $panier, ContenuPanier $contenuPanier): Response
    {
        $panier->setUser($user);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($panier);
        $entityManager->flush();

        return $this->redirectToRoute('home');
    }

    public function deleteAll(Request $request, Panier $panier){
      $entityManager = $this->getDoctrine()->getManager();
      $entityManager->remove($panier);
      $entityManager->flush();

      return $this->redirectToRoute('home');
    }

    public function deleteOne(Request $request, Panier $panier, ContenuPanier $contenuPanier){
      $entityManager = $this->getDoctrine()->getManager();
      $entityManager->removeContenuPanier($panier);
      $entityManager->flush();

    }
}
