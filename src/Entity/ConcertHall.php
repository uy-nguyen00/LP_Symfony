<?php

namespace App\Entity;

use App\Repository\ConcertHallRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ConcertHallRepository::class)]
class ConcertHall
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $concertHallName = null;

    #[ORM\OneToMany(mappedBy: 'concertHall', targetEntity: concert::class)]
    private Collection $concerts;

    public function __construct()
    {
        $this->concerts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getConcertHallName(): ?string
    {
        return $this->concertHallName;
    }

    public function setConcertHallName(string $concertHallName): self
    {
        $this->concertHallName = $concertHallName;

        return $this;
    }

    /**
     * @return Collection<int, concert>
     */
    public function getConcerts(): Collection
    {
        return $this->concerts;
    }

    public function addConcert(concert $concert): self
    {
        if (!$this->concerts->contains($concert)) {
            $this->concerts->add($concert);
            $concert->setConcertHall($this);
        }

        return $this;
    }

    public function removeConcert(concert $concert): self
    {
        if ($this->concerts->removeElement($concert)) {
            // set the owning side to null (unless already changed)
            if ($concert->getConcertHall() === $this) {
                $concert->setConcertHall(null);
            }
        }

        return $this;
    }
}
