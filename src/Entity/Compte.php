<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CompteRepository")
 */
class Compte
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $numCompte;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $proprioCompte;

    

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Operation", inversedBy="comptes")
     */
    private $Operation;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Partenaire", inversedBy="comptes")
     */
    private $Partenaire;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\User", mappedBy="Compte")
     */
    private $users;

    /**
     * @ORM\Column(type="bigint")
     */
    private $soldeC;

    public function __construct()
    {
        $this->users = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumCompte(): ?int
    {
        return $this->numCompte;
    }

    public function setNumCompte(int $numCompte): self
    {
        $this->numCompte = $numCompte;

        return $this;
    }

    public function getProprioCompte(): ?string
    {
        return $this->proprioCompte;
    }

    public function setProprioCompte(string $proprioCompte): self
    {
        $this->proprioCompte = $proprioCompte;

        return $this;
    }

   

    public function getOperation(): ?Operation
    {
        return $this->Operation;
    }

    public function setOperation(?Operation $Operation): self
    {
        $this->Operation = $Operation;

        return $this;
    }

    public function getPartenaire(): ?Partenaire
    {
        return $this->Partenaire;
    }

    public function setPartenaire(?Partenaire $Partenaire): self
    {
        $this->Partenaire = $Partenaire;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->setCompte($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->contains($user)) {
            $this->users->removeElement($user);
            // set the owning side to null (unless already changed)
            if ($user->getCompte() === $this) {
                $user->setCompte(null);
            }
        }

        return $this;
    }

    public function getSoldeC(): ?int
    {
        return $this->soldeC;
    }

    public function setSoldeC(int $soldeC): self
    {
        $this->soldeC = $soldeC;

        return $this;
    }
}
