<?php

namespace App\Entity;

use App\Repository\FicheRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\DBAL\Types\Types;



#[ORM\Entity(repositoryClass: FicheRepository::class)]
class Fiche
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;


    #[ORM\Column(type: 'string' , length: 255)]
    #[Assert\Length( min: 3, minMessage: 'nom doit avoir au minimum 3 caracteres',)]
    #[Assert\NotBlank(message: "Veuillez entrer votre nom")]
    private $nom;
    

    #[ORM\Column(type: 'string' , length: 255)]
    #[Assert\Length( min: 3, minMessage: 'prenom doit avoir au minimum 3 caracteres',)]
    #[Assert\NotBlank(message: "Veuillez entrer votre prenom")]
    private $prenom;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank(message:"Veuillez entre votre email")]
    #[Assert\Email(message:"Votre email n'est pas valide")]
    public ?string $email = null;

    #[ORM\Column(type: 'datetime')]
    #[Assert\GreaterThan("today", message:"La date doit être dés maintenant.")]
     private $date;

    
     #[ORM\Column(type: 'string')]
     #[Assert\Regex(pattern: "/^\d{1,2}:\d{1,2}$/",message :"La durée doit être au format HH:MM.")]
     private $duree;

    
    #[ORM\Column(type: 'integer')]
    #[Assert\NotBlank(message:"Veuillez entre votre numero de telephone")]
    #[Assert\Regex(pattern: '/^\d{8}$/', message: 'Le numéro de téléphone doit être composé de 8 chiffres.')]
    private $numtel;

    #[ORM\Column(type: 'text')]
    #[Assert\Length( min: 5, max: 150, minMessage: 'Description doit avoir au minimum 5 caracteres ',)]
    #[Assert\NotBlank(message:"Vous devez decrire plus de détails ")]
    private $description;


    #[ORM\OneToOne(targetEntity: Rdv::class, cascade: ['persist', 'remove'])]
    private $Rdvs;


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

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getDuree(): ?string
    {
        return $this->duree;
    }

    public function setDuree(string $duree): self
    {
        $this->duree = $duree;

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

    public function getRdvs(): ?Rdv
    {
        return $this->Rdvs;
    }

    public function setRdvs(?Rdv $Rdvs): self
    {
        $this->Rdvs = $Rdvs;

        return $this;
    }

    public function getNumtel(): ?int
    {
        return $this->numtel;
    }

    public function setNumtel(int $numtel): self
    {
        $this->numtel = $numtel;

        return $this;
    }
}
