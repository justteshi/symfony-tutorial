<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleAdminController extends AbstractController
{
    /**
     * @Route ("/admin/article/new", name="admin_article_new")
     * @IsGranted("ROLE_ADMIN_ARTICLE")
     */
    public function new(Article $article)
    {
        return $this->redirect(sprintf('/news/%s',$article->getSlug()));
    }

    /**
     * @Route ("/admin/article/{id}/edit")
     */
    public function edit(Article $article)
    {
        if ($article->getAuthor() != $this->getUser() && !$this->isGranted('ROLE_ADMIN_ARTICLE')) {
            throw $this->createAccessDeniedException('No access !');
        }
        dd($article);
    }

    /**
     * @Route("/admin/article")
     * @IsGranted("ROLE_ADMIN_ARTICLE")
     */
    public function allArticles(ArticleRepository $articleRepo) {
        $articles = $articleRepo->findall();
        return $this->render('article_admin/index.html.twig', [
            'articles'=> $articles
        ]);
    }

    /**
     * @Route("/admin/article/delete-all")
     * @IsGranted("ROLE_ADMIN_ARTICLE")
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
     * @IsGranted("ROLE_ADMIN_ARTICLE")
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
