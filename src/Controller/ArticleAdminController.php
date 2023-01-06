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
        $randNum = rand(100,999);
        $date = new \DateTime('now');
        $article = new Article();
        $article->setTitle(sprintf("Why Asteroids Taste Bacon %s", $randNum))
            ->setSlug( sprintf("why-asteroids-taste-bacon-%s", $randNum))
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
        )
            ->setPublishedAt($date);
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

    /**
     * @Route("/admin/article/delete-all")
     */
    public function deleteAll(EntityManagerInterface $em)
    {
        $repository = $em->getRepository(Article::class);
        $articles = $repository->findAll();

        foreach ($articles as $article) {
            $em->remove($article);
            $em->flush();
        }
        return new Response('All articles deleted !');
    }

    /**
     * @Route("/admin/article/delete/{slug}")
     */
    public function deleteOne($slug, EntityManagerInterface $em)
    {
        $repository = $em->getRepository(Article::class);
        $article = $repository->findOneBy(['slug' => $slug]);

        $em->remove($article);
        $em->flush();

        return new Response(sprintf('Article %s DELETED !', $article->getSlug() ));
    }

}
