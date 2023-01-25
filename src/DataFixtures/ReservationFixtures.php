<?php

namespace App\DataFixtures;

use App\Entity\Reservation;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ReservationFixtures extends Fixture implements DependentFixtureInterface
{
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
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
            ConcertFixtures::class
        ];
    }
}
