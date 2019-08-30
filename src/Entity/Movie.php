<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MovieRepository")
 */
class Movie
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $code_allocine;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $originalTitle;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $productionYear;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $directors;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $actors;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Note", mappedBy="Movie", orphanRemoval=true)
     */
    private $note;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $synopsis;

    public function __construct()
    {
        $this->note = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCodeAllocine(): ?int
    {
        return $this->code_allocine;
    }

    public function setCodeAllocine(?int $code_allocine): self
    {
        $this->code_allocine = $code_allocine;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getOriginalTitle(): ?string
    {
        return $this->originalTitle;
    }

    public function setOriginalTitle(?string $originalTitle): self
    {
        $this->originalTitle = $originalTitle;

        return $this;
    }

    public function getProductionYear(): ?int
    {
        return $this->productionYear;
    }

    public function setProductionYear(?int $productionYear): self
    {
        $this->productionYear = $productionYear;

        return $this;
    }

    public function getDirectors(): ?string
    {
        return $this->directors;
    }

    public function setDirectors(?string $directors): self
    {
        $this->directors = $directors;

        return $this;
    }

    public function getActors(): ?string
    {
        return $this->actors;
    }

    public function setActors(?string $actors): self
    {
        $this->actors = $actors;

        return $this;
    }


    /**
     * @return Collection|Note[]
     */
    public function getNote(): Collection
    {
        return $this->note;
    }

    public function addScore(Note $score): self
    {
        if (!$this->note->contains($score)) {
            $this->note[] = $score;
            $score->setMovie($this);
        }

        return $this;
    }

    public function removeScore(Note $score): self
    {
        if ($this->note->contains($score)) {
            $this->note->removeElement($score);
            // set the owning side to null (unless already changed)
            if ($score->getMovie() === $this) {
                $score->setMovie(null);
            }
        }

        return $this;
    }

    public function getSynopsis(): ?string
    {
        return $this->synopsis;
    }

    public function setSynopsis(?string $synopsis): self
    {
        $this->synopsis = $synopsis;

        return $this;
    }
}
