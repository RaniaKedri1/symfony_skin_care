<?php

namespace App\Controller;

use App\Entity\Produit;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin', name: 'app_')]
class AdminController extends AbstractController
{
    #[Route('/', name: 'admin')]
    public function index(): Response
    {
        return $this->render('admin/index.html.twig');
    }

    #[Route('/produit', name: 'produit')]
    public function getProduct(EntityManagerInterface $entityManager): Response
    {
        $repo = $entityManager->getRepository(Produit::class);
        $lesProduits = $repo->findAll();

        return $this->render('admin/produit/index.html.twig', [
            'lesProduits' => $lesProduits
        ]);
    }
}
