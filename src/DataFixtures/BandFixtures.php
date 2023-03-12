<?php

namespace App\DataFixtures;

use App\Entity\Band;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class BandFixtures extends Fixture implements DependentFixtureInterface
{
    public const KINJAZ = "kinjaz";
    public const JABBAWOCKEEZ = "jabbawockeez";
    public function load(ObjectManager $manager): void
    {
        $band1 = new Band();
        $band1->setBandName('Kinjaz')
            ->addArtistMember($this->getReference(ArtistFixtures::ARTIST_SEAN_LEW))
            ->addArtistMember($this->getReference(ArtistFixtures::ARTIST_ANTHONY_LEE))
            ->addArtistMember($this->getReference(ArtistFixtures::ARTIST_BAM_MARTIN))
            ->setPicture('kinjaz.jpeg');
        $manager->persist($band1);

        $band2 = new Band();
        $band2->setBandName('Jabbawockeez')
            ->addArtistMember($this->getReference(ArtistFixtures::ARTIST_KEVIN_BREWER))
            ->setPicture('jabbawockeez.jpeg');
        $manager->persist($band2);

        $manager->flush();

        $this->addReference(self::KINJAZ, $band1);
        $this->addReference(self::JABBAWOCKEEZ, $band2);
    }

    public function getDependencies(): array
    {
        return [
            ArtistFixtures::class
        ];
    }
}
