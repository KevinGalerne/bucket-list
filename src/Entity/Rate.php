<?php

namespace App\Entity;

use App\Repository\RateRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RateRepository::class)
 */
class Rate
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $Rate;

    /**
     * @ORM\ManyToOne(targetEntity=Idea::class, inversedBy="rates")
     * @ORM\JoinColumn(nullable=false)
     */
    private $idea;


    public function getRate(): ?int
    {
        return $this->Rate;
    }

    public function setRate(int $Rate): self
    {
        $this->Rate = $Rate;

        return $this;
    }

    public function getIdea(): ?Idea
    {
        return $this->idea;
    }

    public function setIdea(?Idea $idea): self
    {
        $this->idea = $idea;

        return $this;
    }

}
