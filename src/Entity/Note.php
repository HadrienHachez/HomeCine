<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;


/**
 * @ORM\Entity(repositoryClass="App\Repository\NoteRepository")
 */
class Note
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Movie", inversedBy="score")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Movie;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Serializer\Type("integer")
     */
    private $score;

    /**
     * @ORM\Column(type="text")
     * @Serializer\Type("string")
     */
    private $commentary;

    /**
     * @ORM\Column(type="datetime")
     * @Serializer\Type("Datetime<'Y-m-d'>")
     */
    private $created_at;

    /**
     * @ORM\Column(type="string", length=255)
     * @Serializer\Type("string")
     */
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMovie(): ?Movie
    {
        return $this->Movie;
    }

    public function setMovie(?Movie $Movie): self
    {
        $this->Movie = $Movie;

        return $this;
    }

    public function getScore(): ?int
    {
        return $this->score;
    }

    public function setScore(?int $score): self
    {
        $this->score = $score;

        return $this;
    }

    public function getCommentary(): ?string
    {
        return $this->commentary;
    }

    public function setCommentary(string $commentary): self
    {
        $this->commentary = $commentary;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUser(): ?string
    {
        return $this->user;
    }

    public function setUser(string $user): self
    {
        $this->user = $user;

        return $this;
    }
}
