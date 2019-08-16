<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\TarifsRepository")
 */
class Tarifs
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
    private $limiteSup;

    /**
     * @ORM\Column(type="bigint")
     */
    private $limiteInf;

    /**
     * @ORM\Column(type="bigint")
     */
    private $frais;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLimiteSup(): ?int
    {
        return $this->limiteSup;
    }

    public function setLimiteSup(int $limiteSup): self
    {
        $this->limiteSup = $limiteSup;

        return $this;
    }

    public function getLimiteInf(): ?int
    {
        return $this->limiteInf;
    }

    public function setLimiteInf(int $limiteInf): self
    {
        $this->limiteInf = $limiteInf;

        return $this;
    }

    public function getFrais(): ?int
    {
        return $this->frais;
    }

    public function setFrais(int $frais): self
    {
        $this->frais = $frais;

        return $this;
    }
}
