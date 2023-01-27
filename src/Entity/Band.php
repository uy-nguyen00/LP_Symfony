<?php

namespace App\Entity;

use App\Repository\BandRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BandRepository::class)]
class Band
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $bandName = null;

    #[ORM\OneToMany(mappedBy: 'band', targetEntity: Artist::class)]
    private Collection $artistMembers;

    #[ORM\ManyToMany(targetEntity: Concert::class, mappedBy: 'bands')]
    private Collection $concerts;

    public function __construct()
    {
        $this->artistMembers = new ArrayCollection();
        $this->concerts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBandName(): ?string
    {
        return $this->bandName;
    }

    public function setBandName(string $bandName): self
    {
        $this->bandName = $bandName;

        return $this;
    }

    /**
     * @return Collection<int, Artist>
     */
    public function getArtistMembers(): Collection
    {
        return $this->artistMembers;
    }

    public function addArtistMember(Artist $artistMember): self
    {
        if (!$this->artistMembers->contains($artistMember)) {
            $this->artistMembers->add($artistMember);
            $artistMember->setBand($this);
        }

        return $this;
    }

    public function removeArtistMember(Artist $artistMember): self
    {
        if ($this->artistMembers->removeElement($artistMember)) {
            // set the owning side to null (unless already changed)
            if ($artistMember->getBand() === $this) {
                $artistMember->setBand(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Concert>
     */
    public function getConcerts(): Collection
    {
        return $this->concerts;
    }

    public function addConcert(Concert $concert): self
    {
        if (!$this->concerts->contains($concert)) {
            $this->concerts->add($concert);
            $concert->addBand($this);
        }

        return $this;
    }

    public function removeConcert(Concert $concert): self
    {
        if ($this->concerts->removeElement($concert)) {
            $concert->removeBand($this);
        }

        return $this;
    }
}
