<?php

namespace App\DataFixtures;

use App\Entity\Reservation;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ReservationFixtures extends Fixture implements DependentFixtureInterface
{
    public const RES_0001 = 'res-0001';

    public function load(ObjectManager $manager): void
    {
        $res1 = new Reservation();
        $res1->setReservationRef('RES0001')
            ->setReservationDate(new \DateTime())
            ->setConcert($this->getReference(ConcertFixtures::WORLD_TOUR))
            ->setUser($this->getReference(UserFixtures::USER_ADMIN))
            ->setReservationStatus('pending');
        $manager->persist($res1);

        $manager->flush();
        $this->addReference(self::RES_0001, $res1);
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
            ConcertFixtures::class
        ];
    }
}
