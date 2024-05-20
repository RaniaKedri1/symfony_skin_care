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
        $categorie = $categorieRepository->findAll();
        return $this->render('home/index.html.twig', [
            'categories' => $categorie,
        ]);
    }

    // public function index(): Response
    // {
    //     $entityManager = $this->getDoctrine()->getManager();
    //     $repo = $entityManager->getRepository(Categorie::class);
    //     $categorie = $repo->findAll();
    //     return $this->render('home/index.html.twig', [
    //         'categories' => $categorie,
    //     ]);
    // }

}
