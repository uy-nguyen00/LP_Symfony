<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    public const USER_ADMIN = 'user-admin';

    public function load(ObjectManager $manager): void
    {
        $u1 = new User();
        $u1->setPseudo('admin')
            ->setRole('admin')
            ->setUserName('The Admin');
        $manager->persist($u1);

        $manager->flush();

        $this->setReference(self::USER_ADMIN, $u1);
    }
}
