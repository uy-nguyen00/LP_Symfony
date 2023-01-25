<?php

namespace App\Entity;

use App\Repository\ConcertRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ConcertRepository::class)]
class Concert
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $concertName = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $concertDate = null;

    #[ORM\ManyToMany(targetEntity: band::class, inversedBy: 'concerts')]
    private Collection $bands;

    #[ORM\OneToMany(mappedBy: 'concert', targetEntity: Reservation::class)]
    private Collection $reservations;

    #[ORM\ManyToOne(inversedBy: 'concerts')]
    #[ORM\JoinColumn(nullable: false)]
    private ?ConcertHall $concertHall = null;

    #[ORM\ManyToMany(targetEntity: artist::class, inversedBy: 'concerts')]
    private Collection $artists;

    public function __construct()
    {
        $this->bands = new ArrayCollection();
        $this->reservations = new ArrayCollection();
        $this->artists = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getConcertName(): ?string
    {
        return $this->concertName;
    }

    public function setConcertName(string $concertName): self
    {
        $this->concertName = $concertName;

        return $this;
    }

    public function getConcertDate(): ?\DateTimeInterface
    {
        return $this->concertDate;
    }

    public function setConcertDate(\DateTimeInterface $concertDate): self
    {
        $this->concertDate = $concertDate;

        return $this;
    }

    /**
     * @return Collection<int, band>
     */
    public function getBands(): Collection
    {
        return $this->bands;
    }

    public function addBand(band $band): self
    {
        if (!$this->bands->contains($band)) {
            $this->bands->add($band);
        }

        return $this;
    }

    public function removeBand(band $band): self
    {
        $this->bands->removeElement($band);

        return $this;
    }

    /**
     * @return Collection<int, Reservation>
     */
    public function getReservations(): Collection
    {
        return $this->reservations;
    }

    public function addReservation(Reservation $reservation): self
    {
        if (!$this->reservations->contains($reservation)) {
            $this->reservations->add($reservation);
            $reservation->setConcert($this);
        }

        return $this;
    }

    public function removeReservation(Reservation $reservation): self
    {
        if ($this->reservations->removeElement($reservation)) {
            // set the owning side to null (unless already changed)
            if ($reservation->getConcert() === $this) {
                $reservation->setConcert(null);
            }
        }

        return $this;
    }

    public function getConcertHall(): ?ConcertHall
    {
        return $this->concertHall;
    }

    public function setConcertHall(?ConcertHall $concertHall): self
    {
        $this->concertHall = $concertHall;

        return $this;
    }

    /**
     * @return Collection<int, artist>
     */
    public function getArtists(): Collection
    {
        return $this->artists;
    }

    public function addArtist(artist $artist): self
    {
        if (!$this->artists->contains($artist)) {
            $this->artists->add($artist);
        }

        return $this;
    }

    public function removeArtist(artist $artist): self
    {
        $this->artists->removeElement($artist);

        return $this;
    }
}
