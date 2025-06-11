<?php

namespace App\Entity;

use App\Repository\MiseRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MiseRepository::class)]
class Mise
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $montant = null;

    #[ORM\Column(type: 'datetime_immutable')]
    private ?\DateTimeImmutable $dateMise = null;

    #[ORM\Column(type: 'boolean')]
    private bool $remboursee = false;

    #[ORM\ManyToOne(inversedBy: 'mises')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Utilisateur $utilisateur = null;

    

    #[ORM\ManyToOne(inversedBy: 'mises')]
    #[ORM\JoinColumn(nullable: false)]

    
    private ?Enchere $enchere = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMontant(): ?int
    {
        return $this->montant;
    }

    public function setMontant(int $montant): static
    {
        $this->montant = $montant;
        return $this;
    }

    public function getDateMise(): ?\DateTimeImmutable
    {
        return $this->dateMise;
    }

    public function setDateMise(\DateTimeImmutable $dateMise): static
    {
        $this->dateMise = $dateMise;
        return $this;
    }

    public function isRemboursee(): bool
    {
        return $this->remboursee;
    }

    public function setRemboursee(bool $remboursee): static
    {
        $this->remboursee = $remboursee;
        return $this;
    }

    public function getUtilisateur(): ?Utilisateur
    {
        return $this->utilisateur;
    }

    public function setUtilisateur(?Utilisateur $utilisateur): static
    {
        $this->utilisateur = $utilisateur;
        return $this;
    }

    public function getEnchere(): ?Enchere
    {
        return $this->enchere;
    }

    public function setEnchere(?Enchere $enchere): static
    {
        $this->enchere = $enchere;
        return $this;
    }
}
