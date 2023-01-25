<?php

namespace App\DataFixtures;

use App\Entity\ConcertHall;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ConcertHallFixtures extends Fixture
{
    public const THE_GRAND_HALL = 'the-grand-hall';

    public function load(ObjectManager $manager): void
    {
        $hall1 = new ConcertHall();
        $hall1->setConcertHallName('The Grand Hall');
        $manager->persist($hall1);

        $manager->flush();

        $this->addReference(self::THE_GRAND_HALL, $hall1);
    }
}
