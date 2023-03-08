<?php

namespace App\Entity;

use App\Repository\OffreRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: OffreRepository::class)]
class Offre
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;
    
    //#[ORM\JoinColumn(onDelete:"CASCADE")]
    #[ORM\Column]
    #[Assert\NotBlank(message: "les points est vide.")]
    private ?int $points = null;

    #[ORM\Column]
    #[Assert\NotBlank(message: "le prix est vide.")]
    #[Assert\Positive(message:"Le prix doit etre positive")]
    #[Assert\Regex(
      pattern:"/^[0-9]+$/",
      message:"Le prix ne doit contenir que des chiffres"
  )]
    private ?float $prix = null;

    #[ORM\Column]
    #[Assert\NotBlank(message: "le pourcentage est vide.")]
    #[Assert\Positive(message:"le pourcentage doit etre positive")]
    #[Assert\Regex(
      pattern:"/^[0-9]+$/",
      message:"le pourcentage ne doit contenir que des chiffres"
    )]
    private ?float $pourcentage = null;

    #[ORM\ManyToOne(inversedBy: 'offres')]
    private ?Abonnement $abonnement_nom = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\NotBlank(message:"date début est vide")]
    private ?\DateTimeInterface $dateDebut = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\NotBlank(message:"date début est vide")]
    private ?\DateTimeInterface $dateFin = null;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPoints(): ?int
    {
        return $this->points;
    }

    public function setPoints(int $points= null): self
    {
        $this->points = $points;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix= null): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getPourcentage(): ?float
    {
        return $this->pourcentage;
    }

    public function setPourcentage(float $pourcentage= null): self
    {
        $this->pourcentage = $pourcentage;

        return $this;
    }

    public function getAbonnementNom(): ?Abonnement
    {
        return $this->abonnement_nom;
    }

    public function setAbonnementNom(?Abonnement $abonnement_nom= null): self
    {
        $this->abonnement_nom = $abonnement_nom;

        return $this;
    }

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->dateDebut;
    }

    public function setDateDebut(\DateTimeInterface $dateDebut= null): self
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->dateFin;
    }

    public function setDateFin(\DateTimeInterface $dateFin= null): self
    {
        $this->dateFin = $dateFin;

        return $this;
    }

    

    
}
