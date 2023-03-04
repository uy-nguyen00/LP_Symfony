<?php

namespace App\DataFixtures;

use App\Entity\Band;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class BandFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $band1 = new Band();
        $band1->setBandName('Kinjaz')
            ->addArtistMember($this->getReference(ArtistFixtures::ARTIST_SEAN_LEW))
            ->addArtistMember($this->getReference(ArtistFixtures::ARTIST_ANTHONY_LEE))
            ->addArtistMember($this->getReference(ArtistFixtures::ARTIST_BAM_MARTIN))
            ->setPicture('kinjaz.jpeg');
        $manager->persist($band1);

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            ArtistFixtures::class
        ];
    }
}
