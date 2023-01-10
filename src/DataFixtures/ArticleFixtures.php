<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Comment;
use Doctrine\Persistence\ObjectManager;

class ArticleFixtures extends BaseFixtures
{
    protected function loadData(ObjectManager $manager): void
    {
        $this->createMany(Article::class, 10, function (Article $article, $count) use ($manager) {
            $images = [
                'asteroid.jpeg',
                'lightspeed.png',
                'mercury.jpeg',
                'meteor-shower.jpg',
                'space-nav.jpg'
            ];

            $article->setTitle($this->faker->country)
                ->setAuthor($this->faker->name)
                ->setImageFilename($images[rand(0, 4)])
                ->setPublishedAt($this->faker->dateTimeBetween('-50days', '-1days'))
                ->setHeartCount($this->faker->numberBetween(0,100))
                ->setContent(<<<EOF
Lorem Ipsum is **simply dummy** text of the printing and typesetting industry. 
Lorem Ipsum has been the [industry's standard dummy](https://google.com/) text ever since the 1500s,
when an unknown **printer** **took** a galley of type and scrambled it to make a type specimen book.
 
It has survived not only five centuries, but also the leap into electronic typesetting,
remaining essentially unchanged.
It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, 
and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.

It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, 
and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.

It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, 
and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
EOF
                );
            $comment1 = new Comment();
            $comment1->setAuthor($this->faker->name);
            $comment1->setContent('It was popularised in the 1960s with the release of Letraset sheets ');
            $comment1->setArticle($article);
            $manager->persist($comment1);

            $comment2 = new Comment();
            $comment2->setAuthor($this->faker->name);
            $comment2->setContent('software like Aldus PageMaker');
            $comment2->setArticle($article);
            $manager->persist($comment2);

            $comment3 = new Comment();
            $comment3->setAuthor($this->faker->name);
            $comment3->setContent('Aldus PageMaker including versions of Lorem Ipsum.');
            $comment3->setArticle($article);
            $manager->persist($comment3);

        });
        $manager->flush();
    }
}
