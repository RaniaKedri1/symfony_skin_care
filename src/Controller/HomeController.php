<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Repository\CategorieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(CategorieRepository $categorieRepository): Response
    {
        return $this->render('home/index.html.twig', [
            'categories' => $categorieRepository->findAll(),
        ]);
    }

    // #[Route('/listeCategories', name: 'liste_categories')]
    // public function listeCategories(EntityManagerInterface $entityManager): Response
    // {
    //     // Récupérer toutes les catégories depuis la base de données
    //     $categories = $entityManager->getRepository(Categorie::class)->findAll();

    //     return $this->render('categorie/liste_categories.html.twig', [
    //         'categories' => $categories,
    //     ]);
    // }
}
