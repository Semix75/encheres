<?php

namespace App\Controller;

use App\Repository\EnchereRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class DashboardController extends AbstractController
{
    #[Route('/dashboard', name: 'app_dashboard')]
    #[IsGranted('ROLE_USER')]
    public function index(EnchereRepository $enchereRepository): Response
    {
        $now = new \DateTimeImmutable('now', new \DateTimeZone('Europe/Paris'));

        // 🧠 Optimisation Doctrine : on charge aussi les produits (évite les requêtes N+1)
        $query = $enchereRepository->createQueryBuilder('e')
            ->leftJoin('e.produit', 'p')
            ->addSelect('p') // charge les données produit en même temps
            ->where('e.dateDebut <= :now')
            ->andWhere('e.dateFin >= :now')
            ->setParameter('now', $now)
            ->orderBy('e.dateFin', 'ASC')
            ->getQuery();

        $encheres = $query->getResult();

        return $this->render('dashboard/index.html.twig', [
            'encheres' => $encheres,
            'now' => $now, // facultatif si tu veux l'utiliser dans la vue
        ]);
    }
}
