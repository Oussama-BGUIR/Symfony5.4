<?php

namespace App\Entity;

use App\Repository\PlanningRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\component\validator\Constraints as Assert;
#[ORM\Entity(repositoryClass: PlanningRepository::class)]
class Planning
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;
   

    #[ORM\Column(length: 255)]
    /*#[Assert\NotBlank(message:"ce champ est obligatoire")]*/
    private ?string $semaine = null;

    #[ORM\Column(length: 255)]
   /* #[Assert\NotBlank(message:"ce champ est obligatoire")]*/
    private ?string $description = null;


    

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?User $id_c = null;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSemaine(): ?string
    {
        return $this->semaine;
    }

    public function setSemaine(string $semaine): self
    {
        $this->semaine = $semaine;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getIdC(): ?user
    {
        return $this->id_c;
    }

    public function setIdC(?user $id_c): self
    {
        $this->id_c = $id_c;

        return $this;
    }

    public function __toString()
    {
        return (string) $this->getIdC();
    }
}
