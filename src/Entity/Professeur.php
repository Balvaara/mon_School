<?php

namespace App\Entity;

use App\Entity\Matiere;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinTable;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;


/**
 * @ORM\Entity(repositoryClass="App\Repository\ProfesseurRepository")
 * @ApiResource(normalizationContext={"groups"={"prof"}})
 */
class Professeur
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"prof","mat"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"prof","mat"})
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"prof","mat"})
     */
    private $nom;
    

  

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"prof","mat"})
     */
    private $adressePr;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"prof","mat"})
     */
    private $telPr;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"prof","mat"})
     */
    private $matriculeP;

    /**
     * @ORM\Column(type="date")
     * @Groups({"prof","mat"})
     */
    private $datenessaince;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"prof","mat"})
     */
    private $lieunessaince;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Matiere", inversedBy="professeurs")
     * @Groups({"prof"})
     * @ORM\JoinTable(name="professeur_matiere")
     */
    private $mats;



    public function __construct()
    {
        $this->mats = new ArrayCollection();
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

   
    public function getAdressePr(): ?string
    {
        return $this->adressePr;
    }

    public function setAdressePr(string $adressePr): self
    {
        $this->adressePr = $adressePr;

        return $this;
    }

    public function getTelPr(): ?string
    {
        return $this->telPr;
    }

    public function setTelPr(string $telPr): self
    {
        $this->telPr = $telPr;

        return $this;
    }

    public function getMatriculeP(): ?string
    {
        return $this->matriculeP;
    }

    public function setMatriculeP(string $matriculeP): self
    {
        $this->matriculeP = $matriculeP;

        return $this;
    }

    public function getDatenessaince(): ?\DateTimeInterface
    {
        return $this->datenessaince;
    }

    public function setDatenessaince(\DateTimeInterface $datenessaince): self
    {
        $this->datenessaince = $datenessaince;

        return $this;
    }

    public function getLieunessaince(): ?string
    {
        return $this->lieunessaince;
    }

    public function setLieunessaince(string $lieunessaince): self
    {
        $this->lieunessaince = $lieunessaince;

        return $this;
    }

    /**
     * @return Collection|Matiere[]
     */
    public function getMats(): Collection
    {
        return $this->mats;
    }

    public function addMat(Matiere $mat): self
    {
        if (!$this->mats->contains($mat)) {
            $this->mats[] = $mat;
        }

        return $this;
    }

    public function removeMat(Matiere $mat): self
    {
        if ($this->mats->contains($mat)) {
            $this->mats->removeElement($mat);
        }

        return $this;
    }

    
}
