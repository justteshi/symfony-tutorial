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
    public function new(Article $article)
    {

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
