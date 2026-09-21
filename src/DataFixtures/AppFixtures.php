<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function __construct(private UserPasswordHasherInterface $hasher){}
   
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        $admin = new User();
        $admin->setEmail('admin@admin.com');
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setPassword($this->hasher->hashPassword($admin,"adminadmin"));

         $user = new User();
        $user->setEmail('user@user.com');
        $user->setRoles(['ROLE_USER']);
        $user->setPassword($this->hasher->hashPassword($user,"useruser"));


        $manager->persist($admin);
        $manager->persist($user);
        $manager->flush();
    }
}
