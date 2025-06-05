<?php

namespace App\Entity;

use App\Repository\ReviewRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReviewRepository::class)]
class Review
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: self::class, inversedBy: 'Review')]
    private ?self $review = null;

    /**
     * @var Collection<int, self>
     */
    #[ORM\OneToMany(targetEntity: self::class, mappedBy: 'review')]
    private Collection $Review;

    #[ORM\Column(length: 255)]
    private ?string $game = null;

    public function __construct()
    {
        $this->Review = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReview(): ?self
    {
        return $this->review;
    }

    public function setReview(?self $review): static
    {
        $this->review = $review;

        return $this;
    }

    public function addReview(self $review): static
    {
        if (!$this->Review->contains($review)) {
            $this->Review->add($review);
            $review->setReview($this);
        }

        return $this;
    }

    public function removeReview(self $review): static
    {
        if ($this->Review->removeElement($review)) {
            // set the owning side to null (unless already changed)
            if ($review->getReview() === $this) {
                $review->setReview(null);
            }
        }

        return $this;
    }

    public function getGame(): ?string
    {
        return $this->game;
    }

    public function setGame(string $game): static
    {
        $this->game = $game;

        return $this;
    }
}
