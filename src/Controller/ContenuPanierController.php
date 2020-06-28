<?php

namespace App\Controller;

use App\Entity\ContenuPanier;
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

    public function add(Request $request, ContenuPanier $cp, Produit $produit, Panier $panier): Response
    {
        $cp->setProduit($produit);
        $cp->setPanier($panier);
        $cp->setQuantite(1);
        $cp->setDate(new \DateTime);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($cp);
        $entityManager->flush();

        return true;
    }
}
