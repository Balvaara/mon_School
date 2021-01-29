<?php

namespace App\Entity;

use App\Entity\Matiere;
use App\Entity\Semestre;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\NoteRepository")
 *@ApiResource(normalizationContext={"groups"={"note"}})
 */
class Note
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"note"})
     */
    private $id;

 

   

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Eleve", inversedBy="notes")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"note"})
     */
    private $eleves;

    

   

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"note"})
     */
    private $appreciation;

    /**
     * @ORM\Column(type="decimal", precision=20, scale=0)
     * @Groups({"note"})
     */
    private $valeur;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Semestre", inversedBy="notes")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"note"})
     */
    private $sems;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Matiere", inversedBy="notes")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"note"})
     */
    private $matieres;

   


    public function __construct()
    {
        $this->matieres = new ArrayCollection();
    }

   

   

    public function getId(): ?int
    {
        return $this->id;
    }


    public function getEleves(): ?Eleve
    {
        return $this->eleves;
    }

    public function setEleves(?Eleve $eleves): self
    {
        $this->eleves = $eleves;

        return $this;
    }


    
    public function getAppreciation(): ?string
    {
        return $this->appreciation;
    }

    public function setAppreciation(?string $appreciation): self
    {
        $this->appreciation = $appreciation;

        return $this;
    }

    public function getValeur(): ?string
    {
        return $this->valeur;
    }

    public function setValeur(string $valeur): self
    {
        $this->valeur = $valeur;

        return $this;
    }

    public function getSems(): ?Semestre
    {
        return $this->sems;
    }

    public function setSems(?Semestre $sems): self
    {
        $this->sems = $sems;

        return $this;
    }

    public function getMatieres(): ?Matiere
    {
        return $this->matieres;
    }

    public function setMatieres(?Matiere $matieres): self
    {
        $this->matieres = $matieres;

        return $this;
    }

    

    
}
