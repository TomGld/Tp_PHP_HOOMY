<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{

    private $encoder;
    public function __construct(UserPasswordHasherInterface $encoder)
    {
        $this->encoder = $encoder;
    }


    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        $this->loadUsers($manager);

        $manager->flush();
    }

    public function loadUsers(ObjectManager $manager): void
    {
        $array_users = [
            [
                'name' => 'admin',
                'password' => 'admin1',
                'roles' => ['ROLE_ADMIN']
            ],
        ];

        foreach ($array_users as $key => $value) {
            $user = new User();
            $user->setName($value['name']);
            $user->setPassword($this->encoder->hashPassword($user, $value['password']));
            // $user->setFirstname($value['firstname']);
            // $user->setLastname($value['lastname']);
            $user->setRoles($value['roles']);
            $manager->persist($user);

            // Définir une référence pour chaque utilisateur
            $this->addReference('user_' . ($key + 1), $user);
        }

        $manager->flush();
    }
}
