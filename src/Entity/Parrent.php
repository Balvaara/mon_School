<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiFilter;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;


/**
 * @ORM\Entity(repositoryClass="App\Repository\ParrentRepository")
 * @ApiResource(normalizationContext={"groups"={"parrent"}})
* @ApiFilter(SearchFilter::class, properties={"tel": "exact"})
 */
class Parrent
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"parrent"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"parrent"})
     */
    private $prenomP;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"parrent"})
     */
    private $nomP;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"parrent"})
     */
    private $adresse;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"parrent"})
     */
    private $tel;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Eleve", mappedBy="parents")
     * @Groups({"parrent"})
     */
    private $eleves;

    public function __construct()
    {
        $this->eleves = new ArrayCollection();
    }

  

    

    

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrenomP(): ?string
    {
        return $this->prenomP;
    }

    public function setPrenomP(string $prenomP): self
    {
        $this->prenomP = $prenomP;

        return $this;
    }

    public function getNomP(): ?string
    {
        return $this->nomP;
    }

    public function setNomP(string $nomP): self
    {
        $this->nomP = $nomP;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getTel(): ?string
    {
        return $this->tel;
    }

    public function setTel(string $tel): self
    {
        $this->tel = $tel;

        return $this;
    }

    /**
     * @return Collection|Eleve[]
     */
    public function getEleves(): Collection
    {
        return $this->eleves;
    }

    public function addElefe(Eleve $elefe): self
    {
        if (!$this->eleves->contains($elefe)) {
            $this->eleves[] = $elefe;
            $elefe->setParents($this);
        }

        return $this;
    }

    public function removeElefe(Eleve $elefe): self
    {
        if ($this->eleves->contains($elefe)) {
            $this->eleves->removeElement($elefe);
            // set the owning side to null (unless already changed)
            if ($elefe->getParents() === $this) {
                $elefe->setParents(null);
            }
        }

        return $this;
    }

}
