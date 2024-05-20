<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Form\ProduitFormType;
use App\Repository\ProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class ProduitController extends AbstractController
{
    #[Route('/produit', name: 'listProduit')]

    public function listProduit(EntityManagerInterface $entityManager): Response
    {
        $repo = $entityManager->getRepository(Produit::class);
        $lesProduits = $repo->findAll();

        return $this->render('produit/index.html.twig', ['lesProduits' => $lesProduits]);
    }

    #[Route('/admin/produit/ajouter', name: 'app_produit_ajouter')]
    public function ajouter(Request $request, EntityManagerInterface $entityManager): Response
    {
        if (!$this->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException('Access denied. You need to have the ADMIN role.');
        }
        $produit = new Produit();
        $form = $this->createForm(ProduitFormType::class, $produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($produit);
            $entityManager->flush();
            $this->addFlash('success', 'Product added successfully');
            return $this->redirectToRoute('app_produit');
        }

        return $this->render('admin/produit/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/voir/{id}', name: 'app_produit_show')]
    public function voir(Produit $produit): Response
    {

        if (!$produit) {
            throw $this->createNotFoundException('Aucun produit trouvé pour l\'ID ' . $produit->getId());
        }

        return $this->render('produit/show.html.twig', [
            'produit' => $produit,
        ]);
    }
    
    #[Route('/admin/produit/edit/{id}', name: 'app_produit_edit')]
    public function edit(Request $request, Produit $produit, EntityManagerInterface $entityManager): Response
    {
        
        $form = $this->createForm(ProduitFormType::class, $produit);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            $this->addFlash('success', 'Procut edited successfully');
            return $this->redirectToRoute('listProduit');
        }   
    
        return $this->render('admin/produit/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    // #[Route('/{id}', name: 'app_produit_delete')]
    //     public function delete(Request $request,ProduitRepository $produitRepository, EntityManagerInterface $entityManager, $id): Response
    //     {
    //         $produit = $produitRepository->find($id);

    //         // if (!$produit) {
    //         //     throw $this->createNotFoundException('No Prouct found for id '.$id);
    //         // }
    //         $entityManager->remove($produit);
    //         $entityManager->flush();
    //         // $this->addFlash('success', 'Produit a été supprimer avec succès.');
    
    //         return $this->redirectToRoute('listProduit');
    //     }
    }
