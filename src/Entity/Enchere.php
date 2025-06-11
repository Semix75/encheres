<?php

namespace App\Entity;

use App\Repository\EnchereRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Produit;
use App\Entity\Mise;

#[ORM\Entity(repositoryClass: EnchereRepository::class)]
class Enchere
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?\DateTime $dateDebut = null;

    #[ORM\Column]
    private ?\DateTime $dateFin = null;

    #[ORM\Column]
    private ?int $coutJeton = null;

    #[ORM\OneToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Produit $produit = null;

    #[ORM\OneToMany(mappedBy: 'enchere', targetEntity: Mise::class, cascade: ['persist', 'remove'], orphanRemoval: true)]
    private Collection $mises;

    public function __construct()
    {
        $this->mises = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateDebut(): ?\DateTime
    {
        return $this->dateDebut;
    }

    public function setDateDebut(\DateTime $dateDebut): static
    {
        $this->dateDebut = $dateDebut;
        return $this;
    }

    public function getDateFin(): ?\DateTime
    {
        return $this->dateFin;
    }

    public function setDateFin(\DateTime $dateFin): static
    {
        $this->dateFin = $dateFin;
        return $this;
    }

    public function getCoutJeton(): ?int
    {
        return $this->coutJeton;
    }

    public function setCoutJeton(int $coutJeton): static
    {
        $this->coutJeton = $coutJeton;
        return $this;
    }

    public function getProduit(): ?Produit
    {
        return $this->produit;
    }

    public function setProduit(Produit $produit): static
    {
        $this->produit = $produit;
        return $this;
    }

    /** @return Collection<int, Mise> */
    public function getMises(): Collection
    {
        return $this->mises;
    }

    public function addMise(Mise $mise): static
    {
        if (!$this->mises->contains($mise)) {
            $this->mises->add($mise);
            $mise->setEnchere($this);
        }

        return $this;
    }

    public function removeMise(Mise $mise): static
    {
        if ($this->mises->removeElement($mise)) {
            if ($mise->getEnchere() === $this) {
                $mise->setEnchere(null);
            }
        }

        return $this;
    }

    public function getMiseGagnante(): ?Mise
    {
        if ($this->mises->isEmpty()) {
            return null;
        }

        $gagnante = null;
        foreach ($this->mises as $mise) {
            if ($gagnante === null || $mise->getMontant() < $gagnante->getMontant()) {
                $gagnante = $mise;
            }
        }
    }

   
    }   