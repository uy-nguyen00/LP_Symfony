<?php

namespace App\DataFixtures;

use App\Entity\Concert;
use App\Entity\Reservation;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ConcertFixtures extends Fixture implements DependentFixtureInterface
{
    public const WORLD_TOUR = 'world-of-dance';
    public const ON_THE_STREET = 'on-the-street';
    public const NOT_SO_SURE = 'not-so-sure';

    public function load(ObjectManager $manager): void
    {
        $concert1 = new Concert();
        $concert1->setConcertName('World Of Dance 2023')
            ->setConcertHall($this->getReference(ConcertHallFixtures::THE_GRAND_HALL))
            ->setConcertDate(\DateTime::createFromFormat('d/m/Y', '02/05/2023'))
            ->setStatus('confirmed')
            ->addBand($this->getReference(BandFixtures::KINJAZ))
            ->addArtist($this->getReference(ArtistFixtures::ARTIST_SEAN_LEW))
            ;
        $manager->persist($concert1);

        $concert2 = new Concert();
        $concert2->setConcertName('On The Street 2023')
            ->setConcertHall($this->getReference(ConcertHallFixtures::EL_PANAMA))
            ->setConcertDate(\DateTime::createFromFormat('d/m/Y', '20/03/2023'))
            ->setStatus('confirmed')
            ->addBand($this->getReference(BandFixtures::JABBAWOCKEEZ))
            ->addArtist($this->getReference(ArtistFixtures::ARTIST_KEVIN_BREWER))
            ->addArtist($this->getReference(ArtistFixtures::ARTIST_ANTHONY_LEE))
        ;
        $manager->persist($concert2);

        $concert3 = new Concert();
        $concert3->setConcertName('Not So Sure')
            ->setConcertHall($this->getReference(ConcertHallFixtures::MARINA_BAY_SANDS))
            ->setConcertDate(\DateTime::createFromFormat('d/m/Y', '21/07/2049'))
            ->setStatus('canceled')
            ->addBand($this->getReference(BandFixtures::JABBAWOCKEEZ))
            ->addBand($this->getReference(BandFixtures::KINJAZ))
            ->addArtist($this->getReference(ArtistFixtures::ARTIST_ANTHONY_LEE))
            ->addArtist($this->getReference(ArtistFixtures::ARTIST_BAM_MARTIN))
        ;
        $manager->persist($concert3);

        $manager->flush();

        $this->setReference(self::WORLD_TOUR, $concert1);
        $this->setReference(self::ON_THE_STREET, $concert2);
        $this->setReference(self::NOT_SO_SURE, $concert3);
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
