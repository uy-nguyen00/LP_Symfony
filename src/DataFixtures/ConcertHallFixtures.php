<?php

namespace App\DataFixtures;

use App\Entity\ConcertHall;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ConcertHallFixtures extends Fixture
{
    public const THE_GRAND_HALL = 'the-grand-hall';
    public const EL_PANAMA = 'el-panama';
    public const MARINA_BAY_SANDS = 'marina-bay-sands';

    public function load(ObjectManager $manager): void
    {
        $hall1 = new ConcertHall();
        $hall1->setConcertHallName('The Grand Hall');
        $manager->persist($hall1);

        $hall2 = new ConcertHall();
        $hall2->setConcertHallName('El Panama');
        $manager->persist($hall2);

        $hall3 = new ConcertHall();
        $hall3->setConcertHallName('Marina Bay Sands');
        $manager->persist($hall3);

        $manager->flush();

        $this->addReference(self::THE_GRAND_HALL, $hall1);
        $this->addReference(self::EL_PANAMA, $hall2);
        $this->addReference(self::MARINA_BAY_SANDS, $hall3);
    }
}
