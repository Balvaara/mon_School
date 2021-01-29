<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AppreciationsRepository")
 * @ApiResource()
 *  @ApiFilter(SearchFilter::class, properties={"val": "exact"})
 */
class Appreciations
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $val;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $libApp;

    /**
     * @ORM\Column(type="integer")
     */
    private $valSup;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getVal(): ?int
    {
        return $this->val;
    }

    public function setVal(int $val): self
    {
        $this->val = $val;

        return $this;
    }

    public function getLibApp(): ?string
    {
        return $this->libApp;
    }

    public function setLibApp(string $libApp): self
    {
        $this->libApp = $libApp;

        return $this;
    }

    public function getValSup(): ?int
    {
        return $this->valSup;
    }

    public function setValSup(int $valSup): self
    {
        $this->valSup = $valSup;

        return $this;
    }
}
