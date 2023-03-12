<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture implements DependentFixtureInterface
{
    private UserPasswordHasherInterface $hasher;

    public const USER_ADMIN = 'user-admin';

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {

        $u1 = new User();
        $u1->setUsername('admin')
            ->setRoles(['ROLE_ADMIN'])
            ->setFirstName('ADMIN');
        $password = $this->hasher->hashPassword($u1, 'admin');
        $u1->setPassword($password);
        $manager->persist($u1);

        $u2 = new User();
        $u2->setUsername('user')
            ->setFirstName('USER');

        $password = $this->hasher->hashPassword($u2, 'user');
        $u2->setPassword($password);
        $manager->persist($u2);

        $manager->flush();

        $this->setReference(self::USER_ADMIN, $u1);
    }

    public function getDependencies(): array
    {
        return [
            ArtistFixtures::class
        ];
    }
}
