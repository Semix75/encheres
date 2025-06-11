<?php

namespace App\Controller;

use App\Repository\EnchereRepository;
use App\Repository\MiseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class ResultatsController extends AbstractController
{
    #[Route('/resultats', name: 'app_resultats')]
    #[IsGranted('ROLE_USER')]
    public function index(
        EnchereRepository $enchereRepository,
        MiseRepository $miseRepository
    ): Response {
        $encheresTerminees = $enchereRepository->findEncheresTerminees();
        $resultats = [];

        foreach ($encheresTerminees as $enchere) {
            $gagnante = $miseRepository->trouverGagnant($enchere);
            $moi = $miseRepository->findOneBy([
                'enchere' => $enchere,
                'utilisateur' => $this->getUser()
            ]);

            $resultats[] = [
                'enchere' => $enchere,
                'gagnant' => $gagnante,
                'maMise' => $moi,
                'estGagnant' => $gagnante && $moi && $gagnante->getId() === $moi->getId()
            ];
        }

        return $this->render('resultats/index.html.twig', [
            'resultats' => $resultats
        ]);
    }
}
