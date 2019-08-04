<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\OperationRepository")
 */
class Operation
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="bigint")
     */
    private $soldeAnterieur;

    /**
     * @ORM\Column(type="bigint")
     */
    private $nouveauSolde;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateDepot;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Compte", mappedBy="Operation")
     */
    private $comptes;

    public function __construct()
    {
        $this->comptes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSoldeAnterieur(): ?int
    {
        return $this->soldeAnterieur;
    }

    public function setSoldeAnterieur(int $soldeAnterieur): self
    {
        $this->soldeAnterieur = $soldeAnterieur;

        return $this;
    }

    public function getNouveauSolde(): ?int
    {
        return $this->nouveauSolde;
    }

    public function setNouveauSolde(int $nouveauSolde): self
    {
        $this->nouveauSolde = $nouveauSolde;

        return $this;
    }

    public function getDateDepot(): ?\DateTimeInterface
    {
        return $this->dateDepot;
    }

    public function setDateDepot(\DateTimeInterface $dateDepot): self
    {
        $this->dateDepot = $dateDepot;

        return $this;
    }

    /**
     * @return Collection|Compte[]
     */
    public function getComptes(): Collection
    {
        return $this->comptes;
    }

    public function addCompte(Compte $compte): self
    {
        if (!$this->comptes->contains($compte)) {
            $this->comptes[] = $compte;
            $compte->setOperation($this);
        }

        return $this;
    }

    public function removeCompte(Compte $compte): self
    {
        if ($this->comptes->contains($compte)) {
            $this->comptes->removeElement($compte);
            // set the owning side to null (unless already changed)
            if ($compte->getOperation() === $this) {
                $compte->setOperation(null);
            }
        }

        return $this;
    }
}
