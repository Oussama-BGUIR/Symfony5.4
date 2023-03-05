<?php

namespace App\Entity;

use App\Repository\PlatRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

use Symfony\Component\Serializer\Annotation\Groups;


#[ORM\Entity(repositoryClass: PlatRepository::class)]
class Plat
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups('plats')]
    public ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\Length( min: 3, minMessage: 'nom doit avoir au minimum 3 caracteres',)]
    #[Assert\NotBlank(message: "vous devez mettre le nom du plat !!!")]
    #[Groups('plats')]

    public ?string $nom = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\Length( min: 10, max: 500, minMessage: 'Vous devez decrire plus de details ',)]
    #[Assert\NotBlank(message:"vous devez decrire le plat")]
    #[Groups('plats')]

    public ?string $description = null;

    #[ORM\Column]
    #[Groups('plats')]

    public ?bool $disponibilte = null;

    #[ORM\Column]
    #[Assert\NotBlank(message:"vous declarer les calories")]
    #[Assert\Range(
        min: 250,
        max: 700,
        notInRangeMessage: 'il faut que les calories du plat est équilibré (entre 250 et 700 calories))',
        
    )]
    #[Groups('plats')]

    public ?int $calorie = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups('plats')]

    public ?string $image = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: '0')]
    #[Assert\Positive(message:" donner un prix réel en dinar")]
    #[Assert\NotBlank(message:"donner un prix !")]
    #[Groups('plats')]

    public ?string $prix = null;

    #[ORM\ManyToOne(inversedBy: 'plats')]
    #[ORM\JoinColumn(onDelete:"CASCADE")]
    private ?Menu $menu = null;

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function isDisponibilte(): ?bool
    {
        return $this->disponibilte;
    }

    public function setDisponibilte(bool $disponibilte): self
    {
        $this->disponibilte = $disponibilte;

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

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getPrix(): ?string
    {
        return $this->prix;
    }

    public function setPrix(string $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getMenu(): ?Menu
    {
        return $this->menu;
    }

    public function setMenu(?Menu $menu): self
    {
        $this->menu = $menu;

        return $this;
    }
}









// aamalna groups ou use ou public f 3oudh private