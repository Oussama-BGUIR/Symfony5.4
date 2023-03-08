<?php

namespace App\Entity;

use App\Repository\ProduitRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ProduitRepository::class)]
class Produit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups('produits')]
    public ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Veuillez saisir le nom du produit !!")]
    #[Groups('produits')]
    public ?string $nom = null;

    #[ORM\Column]
    #[Assert\NotBlank(message: "Veuillez saisir le prix du produit !!")]
    #[Groups('produits')]
    public ?float $prix = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Veuillez ajouter une description du produit !!")]
    #[Groups('produits')]
    public ?string $description = null;

    #[ORM\ManyToOne(inversedBy: 'produits')]
    public ?Categorie $categorie = null;

    #[ORM\Column(length: 255)]
    #[Groups('produits')]
    public ?string $image = null;

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

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): self
    {
        $this->prix = $prix;

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

    public function getCategorie(): ?Categorie
    {
        return $this->categorie;
    }

    public function setCategorie(?Categorie $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }
}
