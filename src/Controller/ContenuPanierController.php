<?php

namespace App\Controller;

use App\Entity\ContenuPanier;
use App\Entity\Panier;
use App\Entity\Produit;
use App\Repository\ContenuPanierRepository;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ContenuPanierController extends AbstractController
{
    /**
     * @Route("/contenu/panier", name="contenu_panier")
     */
    public function index()
    {
        return $this->render('contenu_panier/index.html.twig', [
            'controller_name' => 'ContenuPanierController',
        ]);
    }

    public function add(Request $request): Response
    {
        $em = $this->getDoctrine()->getManager();

        $idPanier = $request->get('panier');
        $idProduit = $request->get('produit');

        $panier = $em->getRepository('App:Panier')->find($idPanier);
        $produit = $em->getRepository('App:Produit')->find($idProduit);

        $cp = new ContenuPanier();
        $cp->setProduit($produit);
        $cp->setPanier($panier);
        $cp->setQuantite(1);
        $cp->setDate(new \DateTime);

        $em->persist($cp);
        $em->flush();

        return $this->redirectToRoute('home');
    }

    public function delete(ContenuPanier $contenuPanier){
      $em = $this->getDoctrine()->getManager();
      $em->remove($contenuPanier);
      $em->flush();

    }
}
