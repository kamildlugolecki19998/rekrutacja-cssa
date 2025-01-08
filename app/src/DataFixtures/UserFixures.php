<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixures extends Fixture
{

    public function __construct(private UserPasswordHasherInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }
    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setEmail('user@example.com');
        // Użyj encodera do zahashowania hasła
        $user->setPassword($this->passwordEncoder->hashPassword($user, 'password'));
        
        // Zapisz użytkownika do bazy
        $manager->persist($user);

        // Zapisz dane do bazy
        $manager->flush();
        $manager->flush();
    }
}
