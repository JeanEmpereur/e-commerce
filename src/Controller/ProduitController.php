<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Form\ProduitType;
use App\Repository\ProduitRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class ProduitController extends AbstractController
{
    # Permet d'afficher tous les produits (page principale)
    public function index(Request $request, ProduitRepository $produitRepository)
    {
      $error = null;
      $success = null;
      $error = $request->get('error');
      $success = $request->get('success');
        return $this->render('produit/index.html.twig', [
            'produits' => $produitRepository->findAll(),
            'success' => $success,
            'error' => $error
        ]);
    }

    # Permet d'ajouter un produit (ADMIN)
    public function add(Request $request): Response
    {
        $produit = new Produit();
        $form = $this->createForm(ProduitType::class, $produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $produit = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();

            $entityManager->persist($produit);
            $entityManager->flush();

            return $this->redirectToRoute('home', array(
              'success' => "Le produit a bien été ajouté"
            ));
        }

        return $this->render('produit/new.html.twig', [
            'produit' => $produit,
            'form' => $form->createView(),
        ]);
    }

    # Permet de regarder un produit
    public function show(produit $produit, Request $request): Response
    {
        $success = null;
        $success = $request->get('success');
        return $this->render('produit/show.html.twig', [
            'produit' => $produit,
            'success' => $success
        ]);
    }

    # Permet de modifier un produit (ADMIN)
    public function edit(Request $request, produit $produit): Response
    {
        $form = $this->createForm(ProduitType::class, $produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $produit = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();

            $entityManager->flush();

            return $this->redirectToRoute('showProduit', array(
              'id' => $produit->getId(),
              'success' => "Modification effectuer"
            ));
        }

        return $this->render('produit/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    # Permet de supprimer un produit (ADMIN)
    public function delete(Request $request, produit $produit): Response
    {
        if ($this->isCsrfTokenValid('delete'.$produit->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($produit);
            $entityManager->flush();
        }

        return $this->redirectToRoute('home', array(
          'success' => "Le produit a bien été supprimé"
        ));
    }
}
