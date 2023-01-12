<?php

namespace App\DataFixtures;

use App\Entity\Tag;
use Doctrine\Persistence\ObjectManager;

class TagFixture extends BaseFixtures
{
    protected function loadData(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        $this->createMany(Tag::class, 10, function(Tag $tag) {
            $tag->setName($this->faker->realText(20));
        });
        $manager->flush();
    }
}
