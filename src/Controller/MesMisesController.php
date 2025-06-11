<?php

namespace App\Controller;

use App\Repository\MiseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class MesMisesController extends AbstractController
{
    #[Route('/mes-mises', name: 'app_mes_mises')]
    #[IsGranted('ROLE_USER')]
    public function index(MiseRepository $miseRepository): Response
    {
        $utilisateur = $this->getUser();
        $mises = $miseRepository->findBy(['utilisateur' => $utilisateur]);

        return $this->render('mes_mises/index.html.twig', [
            'mises' => $mises,
        ]);
    }
}
