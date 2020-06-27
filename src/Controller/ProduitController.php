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
    public function index(Request $request, ProduitRepository $produitRepository)
    {
      $success = null;
      $success = $request->get('success');
        return $this->render('produit/index.html.twig', [
            'produits' => $produitRepository->findAll(),
            'success' => $success
        ]);
    }

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

    public function show(produit $produit, Request $request): Response
    {
        return $this->render('produit/show.html.twig', [
            'produit' => $produit,
        ]);
    }

    public function edit(Request $request, produit $produit): Response
    {
        $form = $this->createForm(ProduitType::class, $produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $produit = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();

            $entityManager->flush();

            return $this->redirectToRoute('home', array(
              'success' => "Le produit a bien été modifié"
            ));
        }

        return $this->render('produit/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

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
