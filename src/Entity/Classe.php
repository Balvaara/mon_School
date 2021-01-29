<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiFilter;
use Symfony\Component\Serializer\Annotation\Groups;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;


/**
 * @ORM\Entity(repositoryClass="App\Repository\ClasseRepository")
 * @ApiResource(normalizationContext={"groups"={"classe"}}))
 * @ApiFilter(SearchFilter::class, properties={"id": "exact"})
 */
class Classe
{
    /**
     * @ORM\Id()
     * @Groups({"classe"})
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"classe"})
     * @Groups({"eleve"})
     */
    private $libclasse;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Cycle", inversedBy="classes")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"classe"})
     */
    private $cycles;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Eleve", mappedBy="myclasses")
	* @Groups({"classe"})
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

    public function getLibclasse(): ?string
    {
        return $this->libclasse;
    }

    public function setLibclasse(string $libclasse): self
    {
        $this->libclasse = $libclasse;

        return $this;
    }

    public function getCycles(): ?Cycle
    {
        return $this->cycles;
    }

    public function setCycles(?Cycle $cycles): self
    {
        $this->cycles = $cycles;

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
            $elefe->setMyclasses($this);
        }

        return $this;
    }

    public function removeElefe(Eleve $elefe): self
    {
        if ($this->eleves->contains($elefe)) {
            $this->eleves->removeElement($elefe);
            // set the owning side to null (unless already changed)
            if ($elefe->getMyclasses() === $this) {
                $elefe->setMyclasses(null);
            }
        }

        return $this;
    }

  

    

  


   
}
