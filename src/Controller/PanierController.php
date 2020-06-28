<?php

namespace App\Controller;

use App\Entity\Panier;
use App\Entity\User;
use App\Entity\Produit;
use App\Repository\PanierRepository;
use App\Controller\ContenuPanierController;
use App\Entity\ContenuPanier;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PanierController extends AbstractController
{
    public function index(Request $request, User $user)
    {
        $em = $this->getDoctrine()->getManager();
        $panier = $em->getRepository('App:Panier')->findOneby(['user' => $user]);
        $contenuPaniers = $em->getRepository('App:ContenuPanier')->find($panier);
        return $this->render('panier/index.html.twig', [
            'paniers' => $contenuPaniers,
            'p' => $panier
        ]);
    }

    public function add(User $user, Produit $produit, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $panier = $em->getRepository('App:Panier')->findOneby(['user' => $user]);
        if ($panier != null) {
          return $this->redirectToRoute('addConternuPanier', array(
            'panier' => $panier->getId(),
            'produit' => $produit->getId()
          ));
        }

        $panier = new Panier();
        $panier->setUser($user);
        $panier->setDateAchat(new \DateTime);
        $panier->setEtat(False);

        $em->persist($panier);
        $em->flush();

        return $this->redirectToRoute('addConternuPanier', array(
          'panier' => $panier->getId(),
          'produit' => $produit->getId()
        ));
    }

    public function addPanier(Request $request): Response
    {
        $em = $this->getDoctrine()->getManager();
        $idPanier = $request->get('panier');

        $panier = $em->getRepository('App:Panier')->find($idPanier);
        $em->persist($panier);
        $em->flush();

        return $this->redirectToRoute('home');
    }

    public function deleteAll(Request $request, Panier $panier){
      $em = $this->getDoctrine()->getManager();
      $contenuPaniers = $em->getRepository('App:ContenuPanier')->find(["panier" => $panier]);

      foreach ($contenuPaniers as $cp) {
        ContenuPanierController.delete($cp);
      }

      $em->remove($panier);
      $em->flush();

      return $this->redirectToRoute('home');
    }

    public function deleteOne(Request $request, ContenuPanier $contenuPanier){
      $em = $this->getDoctrine()->getManager();
      $em->remove($contenuPanier);
      $em->flush();

    }
}
