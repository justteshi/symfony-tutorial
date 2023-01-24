<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleFormType;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleAdminController extends AbstractController
{
    /**
     * @Route ("/admin/article/new", name="admin_article_new")
     * @IsGranted("ROLE_ADMIN_ARTICLE")
     */
    public function new(EntityManagerInterface $em, Request $request)
    {
        $form = $this->createForm(ArticleFormType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $article = new Article();
            $article
                ->setTitle($data['title'])
                ->setContent('content')
                ->setAuthor($this->getUser())
            ;
            $em->persist($article);
            $em->flush();

            $this->addFlash('success', 'Article created !');
            return $this->redirectToRoute('admin_article_list');
        }
        return $this->render('article_admin/new.html.twig', [
            'articleForm' => $form->createView(),
        ]);
    }

    /**
     * @Route ("/admin/article/{id}/edit")
     * @IsGranted("MANAGE", subject="article")
     */
    public function edit(Article $article)
    {
//        $this->denyAccessUnlessGranted('MANAGE', $article);
        dd($article);
    }

    /**
     * @Route("/admin/article", name="admin_article_list")
     * @IsGranted("ROLE_ADMIN_ARTICLE")
     */
    public function allArticles(ArticleRepository $articleRepo) {
        $articles = $articleRepo->findall();
        return $this->render('article_admin/list.html.twig', [
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
