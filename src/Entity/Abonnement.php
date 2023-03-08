<?php

namespace App\Entity;

use App\Repository\AbonnementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;


#[ORM\Entity(repositoryClass: AbonnementRepository::class)]
class Abonnement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    
   
    private ?int $id = null;

    #[ORM\Column(length: 20)]
    #[Groups('abonnements')]
    #[Assert\NotBlank(message: "le nom est vide.")]
    #[Assert\Regex(
        pattern:"/^[a-zA-Z]+$/",
        message:"le nom doit contenir que des lettres"
    )]
    private ?string $nom = null;

    #[ORM\Column(length: 20)]
    #[Groups('abonnements')]
    #[Assert\NotBlank(message: "le type est vide.")]
    private ?string $type = null;


    #[ORM\Column(length: 255)]
    #[Groups('abonnements')]
    #[Assert\NotBlank(message: "le prenom est vide.")]
    #[Assert\Regex(
        pattern:"/^[a-zA-Z]+$/",
        message:"le prenom doit contenir que des lettres"
    )]
    private ?string $prenom = null;

    #[ORM\Column]
    #[Groups('abonnements')]
    #[Assert\NotBlank(message:"le numéro de téléphone est vide")]
    #[Assert\Positive(message:"le numéro de téléphone doit etre positive")]
    #[Assert\Regex(pattern: '/^\d{8}$/', message: 'Le numéro de téléphone doit être composé de 8 chiffres.')]
    private ?int $numero = null;

    #[ORM\OneToMany(mappedBy: 'abonnement_nom', targetEntity: Offre::class , cascade:['persist','remove'])]
 
    private Collection $offres;

    #[ORM\Column(length: 255)]
    #[Groups('abonnements')]
    #[Assert\NotBlank(message:"l'adresse mail est vide")]
    #[Assert\Email(message:"l'adresse mail est non valide")]
    private ?string $email = null;

    public function __construct()
    {
        $this->offres = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom= null): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type= null): self
    {
        $this->type = $type;

        return $this;
    }


    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom= null): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getNumero(): ?int
    {
        return $this->numero;
    }

    public function setNumero(int $numero = null): self
    {
        $this->numero = $numero;

        return $this;
    }

    /**
     * @return Collection<int, Offre>
     */
    public function getOffres(): Collection
    {
        return $this->offres;
    }

    public function addOffre(Offre $offre): self
    {
        if (!$this->offres->contains($offre)) {
            $this->offres->add($offre);
            $offre->setAbonnementNom($this);
        }

        return $this;
    }

    public function removeOffre(Offre $offre): self
    {
        if ($this->offres->removeElement($offre)) {
            // set the owning side to null (unless already changed)
            if ($offre->getAbonnementNom() === $this) {
                $offre->setAbonnementNom(null);
            }
        }

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email = null): self
    {
        $this->email = $email;
        

        return $this;
    }
}
