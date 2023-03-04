<?php

namespace App\DataFixtures;

use App\Entity\Artist;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ArtistFixtures extends Fixture
{
    public const ARTIST_SEAN_LEW = 'sean-lew';
    public const ARTIST_ANTHONY_LEE = 'anthony-lee';
    public const ARTIST_BAM_MARTIN = 'bam-martin';

    public function load(ObjectManager $manager): void
    {
        $artist1 = new Artist();
        $artist1->setArtistName('Sean Lew')
            ->setArtistTag('#seanlew')
            ->setPicture('seanlew.jpeg');
        $manager->persist($artist1);

        $artist2 = new Artist();
        $artist2->setArtistName('Anthony Lee')
            ->setArtistTag('#anthonylee')
            ->setPicture('anthonylee.jpeg');
        $manager->persist($artist2);

        $artist3 = new Artist();
        $artist3->setArtistName('Bam Martin')
            ->setArtistTag('#bammartin')
            ->setPicture('bammartin.jpeg');
        $manager->persist($artist3);

        $manager->flush();

        $this->addReference(self::ARTIST_SEAN_LEW, $artist1);
        $this->addReference(self::ARTIST_ANTHONY_LEE, $artist2);
        $this->addReference(self::ARTIST_BAM_MARTIN, $artist3);
    }
}
