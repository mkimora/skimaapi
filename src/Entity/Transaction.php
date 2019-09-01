<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\TransactionRepository")
 */
class Transaction
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
    private $montant;


    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nomEnvoyeur;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $prenomEnvoyeur;

    /**
     * @ORM\Column(type="integer")
     */
    private $telEnvoyeur;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nomBene;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $prenomBene;

    /**
     * @ORM\Column(type="string",length=255)
     */
    private $numBene;


    /**
     * @ORM\Column(type="bigint", nullable=true)
     */
    private $numCniBene;

    /**
     * @ORM\Column(type="bigint")
     */
    private $code;

    public function getId(): ?int
    {
        return $this->id;
    }

   

    public function getMontant(): ?int
    {
        return $this->montant;
    }

    public function setMontant(int $montant): self
    {
        $this->montant = $montant;

        return $this;
    }

    

    public function getNomEnvoyeur(): ?string
    {
        return $this->nomEnvoyeur;
    }

    public function setNomEnvoyeur(string $nomEnvoyeur): self
    {
        $this->nomEnvoyeur = $nomEnvoyeur;

        return $this;
    }

    public function getPrenomEnvoyeur(): ?string
    {
        return $this->prenomEnvoyeur;
    }

    public function setPrenomEnvoyeur(string $prenomEnvoyeur): self
    {
        $this->prenomEnvoyeur = $prenomEnvoyeur;

        return $this;
    }

    public function getTelEnvoyeur(): ?int
    {
        return $this->telEnvoyeur;
    }

    public function setTelEnvoyeur(int $telEnvoyeur): self
    {
        $this->telEnvoyeur = $telEnvoyeur;

        return $this;
    }

    public function getNomBene(): ?string
    {
        return $this->nomBene;
    }

    public function setNomBene(string $nomBene): self
    {
        $this->nomBene = $nomBene;

        return $this;
    }

    public function getPrenomBene(): ?string
    {
        return $this->prenomBene;
    }

    public function setPrenomBene(string $prenomBene): self
    {
        $this->prenomBene = $prenomBene;

        return $this;
    }

    public function getNumBene(): ?int
    {
        return $this->numBene;
    }

    public function setNumBene(int $numBene): self
    {
        $this->numBene = $numBene;

        return $this;
    }


    public function getNumCniBene(): ?int
    {
        return $this->numCniBene;
    }

    public function setNumCniBene(int $numCniBene): self
    {
        $this->numCniBene = $numCniBene;

        return $this;
    }

    public function getCode(): ?int
    {
        return $this->code;
    }

    public function setCode(int $code): self
    {
        $this->code = $code;

        return $this;
    }
}
