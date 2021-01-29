<?php

namespace App\Entity;

use App\Entity\Parrent;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiFilter;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EleveRepository")
 * @ApiResource(normalizationContext={"groups"={"eleve"}})
 *  @ApiFilter(SearchFilter::class, properties={"matricule": "exact"})
 */
class Eleve
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"classe"})
     * @Groups({"eleve"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"classe"})
     *@Groups({"eleve"})
     *@Groups({"note"})
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"classe"})
     *  @Groups({"eleve"})
     * @Groups({"note"})
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"eleve"})
     * @Groups({"note"})
     */
    private $residence;

 

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"eleve"})
     * @Groups({"note"})
     */
    private $lieuness;

   

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Note", mappedBy="eleves",cascade={"remove"})
     * @ORM\JoinColumn(nullable=true)
     * @Groups({"eleve"})
     */
    private $notes;

  
    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"eleve"})
     * @Groups({"note"})
     */
    private $matricule;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Parrent", inversedBy="eleves")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"eleve"})
     */
    private $parents;

    /**
     * @ORM\Column(type="date")
     * @Groups({"eleve"})
     * @Groups({"note"})
     */
    private $dateness;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Classe", inversedBy="eleves")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"eleve"})
     */
    private $myclasses;


   

  

  

   

   
   

    public function __construct()
    {
    
        $this->notes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getResidence(): ?string
    {
        return $this->residence;
    }

    public function setResidence(string $residence): self
    {
        $this->residence = $residence;

        return $this;
    }

    

  

    public function getLieuness(): ?string
    {
        return $this->lieuness;
    }

    public function setLieuness(string $lieuness): self
    {
        $this->lieuness = $lieuness;

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
            $note->setEleves($this);
        }

        return $this;
    }

    public function removeNote(Note $note): self
    {
        if ($this->notes->contains($note)) {
            $this->notes->removeElement($note);
            // set the owning side to null (unless already changed)
            if ($note->getEleves() === $this) {
                $note->setEleves(null);
            }
        }

        return $this;
    }

   

    public function getMatricule(): ?string
    {
        return $this->matricule;
    }

    public function setMatricule(string $matricule): self
    {
        $this->matricule = $matricule;

        return $this;
    }

    public function getParents(): ?Parrent
    {
        return $this->parents;
    }

    public function setParents(?Parrent $parents): self
    {
        $this->parents = $parents;

        return $this;
    }

    public function getDateness(): ?\DateTimeInterface
    {
        return $this->dateness;
    }

    public function setDateness(\DateTimeInterface $dateness): self
    {
        $this->dateness = $dateness;

        return $this;
    }

    public function getMyclasses(): ?Classe
    {
        return $this->myclasses;
    }

    public function setMyclasses(?Classe $myclasses): self
    {
        $this->myclasses = $myclasses;

        return $this;
    }

}
