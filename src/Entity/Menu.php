<?php

namespace App\Entity;

use App\Repository\MenuRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: MenuRepository::class)]
class Menu
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups('menus')]
    public ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\Length( min: 3, minMessage: 'nom doit avoir au minimum 3 caracteres',)]
    #[Assert\NotBlank(message: "vous devez mettre le nom du menu!!!")]
    #[Groups('menus')]
    public ?string $nom = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\Length( min: 50, max: 500, minMessage: 'Vous devez decrire plus de details ',)]
    #[Assert\NotBlank(message:"vous devez decrire le menu")]
    #[Groups('menus')]
    public ?string $description = null;


    #[ORM\Column]
    #[Groups('menus')]
    public ?bool $disponibilite = null;

    #[ORM\Column]
    #[Assert\NotBlank(message:"vous declarer les calories")]
    #[Assert\Range(
        min: 1500,
        max: 2500,
        notInRangeMessage: 'il faut que les calories des plats sont équilibrés (entre 1500 et 2500 calories))',
        
    )]
    #[Groups('menus')]
    public ?int $calorie = null;



    #[ORM\Column(length: 255, nullable: true)]
    #[Groups('menus')]
    public ?string $image = null;

    #[ORM\OneToMany(mappedBy: 'menu', targetEntity: Plat::class)]
    private Collection $plats;



    public function __construct()
    {
        $this->plats = new ArrayCollection();
    }

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

    public function __toString() {
        return $this->nom;
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

    public function isDisponibilite(): ?bool
    {
        return $this->disponibilite;
    }

    public function setDisponibilite(bool $disponibilite): self
    {
        $this->disponibilite = $disponibilite;

        return $this;
    }

    public function getCalorie(): ?int
    {
        return $this->calorie;
    }

    public function setCalorie(int $calorie): self
    {
        $this->calorie = $calorie;

        return $this;
    }


    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    /**
     * @return Collection<int, Plat>
     */
    public function getPlats(): Collection
    {
        return $this->plats;
    }

    public function addPlat(Plat $plat): self
    {
        if (!$this->plats->contains($plat)) {
            $this->plats->add($plat);
            $plat->setMenu($this);
        }

        return $this;
    }

    public function removePlat(Plat $plat): self
    {
        if ($this->plats->removeElement($plat)) {
            // set the owning side to null (unless already changed)
            if ($plat->getMenu() === $this) {
                $plat->setMenu(null);
            }
        }

        return $this;
    }


}












// aamalna groups ou use ou public f 3oudh private