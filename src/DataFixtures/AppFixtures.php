<?php

namespace App\DataFixtures;

use App\Constants\UserConstants;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function __construct
    (
        private readonly UserPasswordHasherInterface $userPasswordHasherInterface
    )
    {
    }

    public function load(ObjectManager $manager): void
    {
        $user = (new User())
            ->setEmail('superadmin@myges.fr')
            ->setPassword($this->userPasswordHasherInterface->hashPassword(new User(), 'superadmin'))
            ->setRoles([UserConstants::ROLE_SUPER_ADMIN])
            ->setUsername('superadmin')
            ->setFirstname('Super')
            ->setLastname('Admin')
            ->setBiography('Super Admin');
        $manager->persist($user);
        $manager->flush();
    }
}
