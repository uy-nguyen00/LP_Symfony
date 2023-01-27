<?php

namespace App\DataFixtures;

use App\Entity\Concert;
use App\Entity\Reservation;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ConcertFixtures extends Fixture implements DependentFixtureInterface
{
    public const WORLD_TOUR = 'world-tour';

    public function load(ObjectManager $manager): void
    {
        $concert1 = new Concert();
        $concert1->setConcertName('World Tour')
            ->setConcertHall($this->getReference(ConcertHallFixtures::THE_GRAND_HALL))
            ->setConcertDate(new \DateTime())
            ->addArtist($this->getReference(ArtistFixtures::ARTIST_SEAN_LEW));
        $manager->persist($concert1);

        $manager->flush();

        $this->setReference(self::WORLD_TOUR, $concert1);
    }

    public function getDependencies(): array
    {
        return [
            ConcertHallFixtures::class,
            ArtistFixtures::class,
            BandFixtures::class,
        ];
    }
}
