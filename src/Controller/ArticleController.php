<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use App\Service\SlackClient;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{

    private $isDebug;

    public function __construct(bool $isDebug)
    {
        $this->isDebug = $isDebug;
    }

    /**
     * @Route("/", name="app_homepage")
     */
    public function homepage(ArticleRepository $articleRepo)
    {
        $articles = $articleRepo->findAllPublishedOrderByNewest();
        return $this->render('article/home.html.twig', [
            'articles' => $articles
        ]);
    }

    /**
     * @Route("/news/{slug}", name="article_show")
     */
    public function show(Article $article, SlackClient $slack)
    {
        if($article->getSlug() == 'slack') {
            $slack->sendMessage(
                'New Beautiful Tiger',
                'Pretty new message from tigerland'
            );
        }

        $comments = $article->getComments();
        dump($article);die;

        return $this->render('article/show.html.twig',[
            'comments' => $comments,
            'article' => $article,
        ]);
    }

    /**
     * @Route("/news/{slug}/heart", name="like_article", methods={"POST"})
     */

    public function toggleArticleHeart(Article $article, LoggerInterface $logger, EntityManagerInterface $em)
    {
        //TODO - like/unlike the article
        $article->incHeartCount();
        $em->flush();
        $logger->info('Article is being liked');
        return new JsonResponse(['hearts' => $article->getHeartCount()]);
    }
}
