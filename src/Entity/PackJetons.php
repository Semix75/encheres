<?php

namespace App\Entity;

use App\Repository\PackJetonsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PackJetonsRepository::class)]
class PackJetons
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nomPack = null;

    #[ORM\Column]
    private ?int $nbJetons = null;

    #[ORM\Column]
    private ?float $prixPack = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomPack(): ?string
    {
        return $this->nomPack;
    }

    public function setNomPack(string $nomPack): static
    {
        $this->nomPack = $nomPack;

        return $this;
    }

    public function getNbJetons(): ?int
    {
        return $this->nbJetons;
    }

    public function setNbJetons(int $nbJetons): static
    {
        $this->nbJetons = $nbJetons;

        return $this;
    }

    public function getPrixPack(): ?float
    {
        return $this->prixPack;
    }

    public function setPrixPack(float $prixPack): static
    {
        $this->prixPack = $prixPack;

        return $this;
    }
}
