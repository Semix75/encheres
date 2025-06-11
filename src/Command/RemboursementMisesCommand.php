<?php

namespace App\Command;

use App\Repository\EnchereRepository;
use App\Repository\MiseRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'app:remboursement-mises',
    description: 'Rembourse les jetons des mises perdues après la fin des enchères',
)]
class RemboursementMisesCommand extends Command
{
    public function __construct(
        private EnchereRepository $enchereRepository,
        private MiseRepository $miseRepository,
        private EntityManagerInterface $em
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $encheresTerminees = $this->enchereRepository->createQueryBuilder('e')
            ->where('e.dateFin <= :now')
            ->setParameter('now', new \DateTimeImmutable())
            ->getQuery()
            ->getResult();

        foreach ($encheresTerminees as $enchere) {
            $gagnante = $this->miseRepository->trouverGagnant($enchere);

            foreach ($enchere->getMises() as $mise) {
                if ($mise === $gagnante || $mise->isRemboursee()) {
                    continue;
                }

                $utilisateur = $mise->getUtilisateur();
                $utilisateur->setJetons($utilisateur->getJetons() + $mise->getMontant());
                $mise->setRemboursee(true);

                $output->writeln("💸 {$utilisateur->getEmail()} remboursé de {$mise->getMontant()} jetons.");
            }
        }

        $this->em->flush();

        $output->writeln('✅ Remboursements terminés.');
        return Command::SUCCESS;
    }
}
