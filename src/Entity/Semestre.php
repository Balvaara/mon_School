<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SemestreRepository")
 *@ApiResource()
 */
class Semestre
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"note"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $numsemestre;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"note"})
     */
    private $libellesemestre;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Note", mappedBy="sems")
     */
    private $notes;

   

    public function __construct()
    {
        $this->notes = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumsemestre(): ?string
    {
        return $this->numsemestre;
    }

    public function setNumsemestre(string $numsemestre): self
    {
        $this->numsemestre = $numsemestre;

        return $this;
    }

    public function getLibellesemestre(): ?string
    {
        return $this->libellesemestre;
    }

    public function setLibellesemestre(string $libellesemestre): self
    {
        $this->libellesemestre = $libellesemestre;

        return $this;
    }

    /**
     * @return Collection|Note[]
     */
    public function getNotes(): Collection
    {
        return $this->notes;
    }

    public function addNote(Note $note): self
    {
        if (!$this->notes->contains($note)) {
            $this->notes[] = $note;
            $note->setSems($this);
        }

        return $this;
    }

    public function removeNote(Note $note): self
    {
        if ($this->notes->contains($note)) {
            $this->notes->removeElement($note);
            // set the owning side to null (unless already changed)
            if ($note->getSems() === $this) {
                $note->setSems(null);
            }
        }

        return $this;
    }

   

  
}
