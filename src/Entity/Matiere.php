<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinTable;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;


/**
 * @ORM\Entity(repositoryClass="App\Repository\MatiereRepository")
 * @ApiResource(normalizationContext={"groups"={"mat"}})
 */
class Matiere
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"prof"})
     * @Groups({"mat"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"prof"})
     * @Groups({"mat"})
     * @Groups({"note"})
     */
    private $libelle;

 

    /**
     * @ORM\Column(type="integer")
     * @Groups({"prof"})
     * @Groups({"mat"})
     * @Groups({"note"})
     */
    private $coef;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Professeur", mappedBy="mats")
     * @Groups({"mat"})
     */
    private $professeurs;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Note", mappedBy="matieres")
     * @Groups({"mat"})
     *  @ORM\JoinTable(name="professeur_matiere")
     */
    private $notes;

 


    public function __construct()
    {
        $this->professeurs = new ArrayCollection();
        $this->notes = new ArrayCollection();
    }

    





 


   

  

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }


    public function getCoef(): ?int
    {
        return $this->coef;
    }

    public function setCoef(int $coef): self
    {
        $this->coef = $coef;

        return $this;
    }

    /**
     * @return Collection|Professeur[]
     */
    public function getProfesseurs(): Collection
    {
        return $this->professeurs;
    }

    public function addProfesseur(Professeur $professeur): self
    {
        if (!$this->professeurs->contains($professeur)) {
            $this->professeurs[] = $professeur;
            $professeur->addMat($this);
        }

        return $this;
    }

    public function removeProfesseur(Professeur $professeur): self
    {
        if ($this->professeurs->contains($professeur)) {
            $this->professeurs->removeElement($professeur);
            $professeur->removeMat($this);
        }

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
            $note->setMatieres($this);
        }

        return $this;
    }

    public function removeNote(Note $note): self
    {
        if ($this->notes->contains($note)) {
            $this->notes->removeElement($note);
            // set the owning side to null (unless already changed)
            if ($note->getMatieres() === $this) {
                $note->setMatieres(null);
            }
        }

        return $this;
    }



 

  

}
