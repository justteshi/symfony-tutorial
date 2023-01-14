<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;

class UserFixture extends BaseFixtures
{
    protected function loadData(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
//        $this->createMany(10, 'main_users', function(User $user, $i) {
//            $user = new User();
//            $user->setEmail(sprintf('spacebar&d@example.com', $i));
//            $user->setFirstName($this->faker->firstName);
//
//            return $user;
//        });
        $manager->flush();
    }
}
