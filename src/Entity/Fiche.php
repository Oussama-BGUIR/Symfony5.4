<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\FicheRepository;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;




#[ORM\Entity(repositoryClass: FicheRepository::class)]
class Fiche
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[Groups('fiches')]
    #[ORM\Column(type: 'integer')]
    private $id;


    #[ORM\Column(type: 'string' , length: 255)]
    #[Assert\Length( min: 3, minMessage: 'nom doit avoir au minimum 3 caracteres',)]
    #[Assert\NotBlank(message: "Veuillez entrer votre nom")]
    #[ORM\GeneratedValue]
    #[Groups('fiches')]
    private $nom;
    

    #[ORM\Column(type: 'string' , length: 255)]
    #[Assert\Length( min: 3, minMessage: 'prenom doit avoir au minimum 3 caracteres',)]
    #[Assert\NotBlank(message: "Veuillez entrer votre prenom")]
    #[ORM\GeneratedValue]
    #[Groups('fiches')]
    private $prenom;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank(message:"Veuillez entre votre email")]
    #[Assert\Email(message:"Votre email n'est pas valide")]
    #[ORM\GeneratedValue]
    #[Groups('fiches')]
    private ?string $email = null;

  
     

    
    #[ORM\Column(type: 'integer')]
    #[Assert\NotBlank(message:"Veuillez entre votre numero de telephone")]
    #[Assert\Regex(pattern: '/^\d{8}$/', message: 'Le numéro de téléphone doit être composé de 8 chiffres.')]
    #[ORM\GeneratedValue]
    #[Groups('fiches')]
    private $numtel;

    #[ORM\Column(type: 'text')]
    #[Assert\Length( min: 5, max: 150, minMessage: 'Description doit avoir au minimum 5 caracteres ',)]
    #[Assert\NotBlank(message:"Vous devez decrire plus de détails ")]
    #[ORM\GeneratedValue]
    #[Groups('fiches')]
    private $description;

    #[ORM\OneToMany(mappedBy: 'nom_nutritioniste', targetEntity: Rdv::class)]
    private Collection $fiche_nom;

    public function __construct()
    {
        $this->fiche_nom = new ArrayCollection();
    }




    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function __toString() {
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

   


    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

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

    /**
     * @return Collection<int, Rdv>
     */
    public function getFicheNom(): Collection
    {
        return $this->fiche_nom;
    }

    public function addFicheNom(Rdv $ficheNom): self
    {
        if (!$this->fiche_nom->contains($ficheNom)) {
            $this->fiche_nom->add($ficheNom);
            $ficheNom->setNomNutritioniste($this);
        }

        return $this;
    }

    public function removeFicheNom(Rdv $ficheNom): self
    {
        if ($this->fiche_nom->removeElement($ficheNom)) {
            // set the owning side to null (unless already changed)
            if ($ficheNom->getNomNutritioniste() === $this) {
                $ficheNom->setNomNutritioniste(null);
            }
        }

        return $this;
    }


}
