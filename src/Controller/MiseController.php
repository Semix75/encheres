<?php

namespace App\Controller;

use App\Entity\Mise;
use App\Entity\Enchere;
use App\Form\MiseType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class MiseController extends AbstractController
{
    #[Route('/enchere/{id}/miser', name: 'app_miser')]
    #[IsGranted('ROLE_USER')]
    public function miser(
        Enchere $enchere,
        Request $request,
        EntityManagerInterface $entityManager
    ): Response {
        $utilisateur = $this->getUser();
    
        $dejaMise = $entityManager->getRepository(Mise::class)->findOneBy([
            'enchere' => $enchere,
            'utilisateur' => $utilisateur,
        ]);
    
        if ($dejaMise) {
            $this->addFlash('info', '❌ Vous avez déjà participé à cette enchère.');
            return $this->redirectToRoute('app_dashboard');
        }
    
        $mise = new Mise();
        $mise->setDateMise(new \DateTimeImmutable());
        $mise->setEnchere($enchere);
        $mise->setUtilisateur($utilisateur);
    
        $form = $this->createForm(MiseType::class, $mise);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($mise);
            $entityManager->flush();
    
            $this->addFlash('success', '✅ Votre mise a bien été enregistrée.');
            return $this->redirectToRoute('app_dashboard');
        }
    
        return $this->render('mise/miser.html.twig', [
            'form' => $form->createView(),
            'enchere' => $enchere,
        ]);
    }
    
    }
