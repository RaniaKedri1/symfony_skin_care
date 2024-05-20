<?php

namespace App\Controller;

use App\Entity\Categorie;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use App\Form\CategorieFormType;
use App\Repository\CategorieRepository;

#[Route('/categorie', name: 'categorie_')]
class CategorieController extends AbstractController
{
    // #[Route('/', name: 'index')]
    // public function index(EntityManagerInterface $entityManager): Response
    // {
    //     $categories = $entityManager->getRepository(Categorie::class)->findAll();

    //     return $this->render('categorie/index.html.twig', [
    //         'categories' => $categories,
    //     ]);
    // }


    #[Route('/categorie/{id}', name: 'show')]
    public function show(Categorie $categorie): Response
    {
        return $this->render('admin/categorie/show.html.twig', [
            'categorie' => $categorie,
        ]);
    }

    #[Route('/ajouterCategorie', name: 'ajouter')]
    public function ajouterCategorie(Request $request, EntityManagerInterface $entityManager): Response
    {
        $categorie = new Categorie();
        $form = $this->createForm(CategorieFormType::class, $categorie);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager->persist($categorie);
            $entityManager->flush();
            $this->addFlash('notice', 'Catégorie ajoutée avec succès.');
            return $this->redirectToRoute('app_categorie');
        }
        return $this->render('admin/categorie/ajouter_categorie.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}/edit', name: 'edit')]
    public function edit(Request $request, categorie $categorie, EntityManagerInterface $entityManager): Response
    {
        $form =$this->createForm(CategorieFormType::class, $categorie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $entityManager->flush();
            $this->addFlash('success', 'Category edited successfully');
            return $this->redirectToRoute('app_categorie');
        }

        return $this->render('admin/categorie/edit.html.twig', [
            'categorie' => $categorie,
            'form' => $form,
        ]);
    }

    #[Route('/delete/{id}', name: 'delete')]
public function deletecategorie(CategorieRepository $categorieRepository, EntityManagerInterface $entityManager, Request $request, $id) {
    $cat = $categorieRepository->find($id);

    if (!$cat) {
        throw $this->createNotFoundException('No categorie found for id '.$id);
    }
    $entityManager->remove($cat);
    $entityManager->flush();
    $this->addFlash('success', 'Category deleted successfully');
    return $this->redirectToRoute('app_categorie');
}

}