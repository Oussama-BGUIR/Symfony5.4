<?php

namespace App\Entity;

use App\Repository\CoursRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: CoursRepository::class)]
class Cours
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\Length( min: 4, minMessage: 'minimum 4 caracteres',)]
    #[Assert\NotBlank(message: "vous devez mettre le nom du semaine!!!")]
    private ?string $nom = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]


        // /**
        //  * @var string A "Y-m-d H:i:s" formatted value
        //  */
        // #[Assert\DateTime]
        // protected $createdAt;
    
  
    #[Assert\NotBlank(message: "il faut une durée valide")]
    private ?\DateTimeInterface $duree = null;

    #[ORM\Column(length: 255)]
    #[Assert\Length( min: 2, minMessage: 'donner le nom du salle',)]
    #[Assert\NotBlank(message: "il faut un nom précis")]
    private ?string $salle = null;

    #[ORM\ManyToOne(inversedBy: 'courses')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Planning $planning = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getDuree(): ?\DateTimeInterface
    {
        return $this->duree;
    }

    public function setDuree(\DateTimeInterface $duree): self
    {
        $this->duree = $duree;

        return $this;
    }

    public function getSalle(): ?string
    {
        return $this->salle;
    }

    public function setSalle(string $salle): self
    {
        $this->salle = $salle;

        return $this;
    }

    public function getPlanning(): ?Planning
    {
        return $this->planning;
    }

    public function setPlanning(?Planning $planning): self
    {
        $this->planning = $planning;

        return $this;
    }
}
