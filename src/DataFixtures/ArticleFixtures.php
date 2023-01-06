<?php

namespace App\DataFixtures;

use App\Entity\Article;
use Doctrine\Persistence\ObjectManager;

class ArticleFixtures extends BaseFixtures
{
    protected function loadData(ObjectManager $manager): void
    {
        $this->createMany(Article::class, 10, function (Article $article, $count) {
            $authors = [
                'Mike Mikey',
                'Tom Tomson',
            ];
            $images = [
                'asteroid.jpeg',
                'lightspeed.png',
                'mercury.jpeg',
                'meteor-shower.jpg',
                'space-nav.jpg'
            ];
            $randNum = rand(100, 999);
            $date = new \DateTime('now');
            $article->setTitle(sprintf("Why Asteroids Taste Bacon %s", $randNum))
                ->setSlug(sprintf("why-asteroids-taste-bacon-%s", $count))
                ->setAuthor($authors[rand(0, 1)])
                ->setImageFilename($images[rand(0, 4)])
                ->setPublishedAt($date)
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
        });
        $manager->flush();
    }
}
