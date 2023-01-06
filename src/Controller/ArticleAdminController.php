<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class ArticleAdminController extends AbstractController
{
    /**
     * @Route ("/admin/article/new")
     */
    public function new(EntityManagerInterface $em)
    {
        $article = new Article();
        $article->setTitle("Why Asteroids Taste Bacon")
            ->setSlug('why-asteroids-taste-bacon-'.rand(100,999))
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
        $em->persist($article);
        $em->flush();
//        return new Response('Created New Article');
        return $this->redirect(sprintf('/news/%s',$article->getSlug()));
    }

    /**
     * @Route("/admin/article/all")
     */
    public function all(ArticleRepository $articleRepo) {
        $articles = $articleRepo->findall();
        dump($articles);die;
    }

}
