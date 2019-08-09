<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PartenaireRepository")
 */
class Partenaire
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nompartenaire;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $adresseP;


    /**
     * @ORM\Column(type="string", length=255)
     */
    private $raisonSociale;

    /**
     * @ORM\Column(type="integer")
     */
    private $ninea;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $etatP;

  



    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Compte", mappedBy="Partenaire")
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

    public function getNompartenaire(): ?string
    {
        return $this->nompartenaire;
    }

    public function setNompartenaire(string $nompartenaire): self
    {
        $this->nompartenaire = $nompartenaire;

        return $this;
    }

    public function getAdresseP(): ?string
    {
        return $this->adresseP;
    }

    public function setAdresseP(string $adresseP): self
    {
        $this->adresseP = $adresseP;

        return $this;
    }

   

    public function getRaisonSociale(): ?string
    {
        return $this->raisonSociale;
    }

    public function setRaisonSociale(string $raisonSociale): self
    {
        $this->raisonSociale = $raisonSociale;

        return $this;
    }

    public function getNinea(): ?int
    {
        return $this->ninea;
    }

    public function setNinea(int $ninea): self
    {
        $this->ninea = $ninea;

        return $this;
    }

    public function getEtatP(): ?string
    {
        return $this->etatP;
    }

    public function setEtatP(string $etatP): self
    {
        $this->etatP = $etatP;

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
            $compte->setPartenaire($this);
        }

        return $this;
    }

    public function removeCompte(Compte $compte): self
    {
        if ($this->comptes->contains($compte)) {
            $this->comptes->removeElement($compte);
            // set the owning side to null (unless already changed)
            if ($compte->getPartenaire() === $this) {
                $compte->setPartenaire(null);
            }
        }

        return $this;
    }
}
