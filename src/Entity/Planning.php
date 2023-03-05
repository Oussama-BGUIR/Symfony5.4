<?php

namespace App\Entity;

use App\Repository\PlanningRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: PlanningRepository::class)]
class Planning
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\Length( min: 2, minMessage: 'minimum 2 caracteres',)]
    #[Assert\NotBlank(message: "vous devez mettre le nom du semaine!!!")]
    private ?string $semaine = null;
    

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\Length( min: 50, max: 500, minMessage: 'décrivez la semaine plus ',)]
    #[Assert\NotBlank(message:"il faut décrire la semmaine !")]
    private ?string $description = null;

    #[ORM\OneToMany(mappedBy: 'planning', targetEntity: Cours::class)]
    private Collection $courses;


    public function __toString() {
        return $this->semaine;
    }
    

    public function __construct()
    {
        $this->courses = new ArrayCollection();
    }

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

    /**
     * @return Collection<int, Cours>
     */
    public function getCourses(): Collection
    {
        return $this->courses;
    }

    public function addCourse(Cours $course): self
    {
        if (!$this->courses->contains($course)) {
            $this->courses->add($course);
            $course->setPlanning($this);
        }

        return $this;
    }

    public function removeCourse(Cours $course): self
    {
        if ($this->courses->removeElement($course)) {
            // set the owning side to null (unless already changed)
            if ($course->getPlanning() === $this) {
                $course->setPlanning(null);
            }
        }

        return $this;
    }
}
