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
        $articles = $articleRepo->findAll();
        return $this->render('article/home.html.twig', [
            'articles' => $articles
        ]);
    }

    /**
     * @Route("/news/{slug}", name="article_show")
     */
    public function show($slug, SlackClient $slack, EntityManagerInterface $em)
    {
        if($slug == 'slack') {
            $slack->sendMessage(
                'New Beautiful Tiger',
                'Pretty new message from tigerland'
            );
        }

        $repository = $em->getRepository(Article::class);
        $article = $repository->findOneBy(['slug' => $slug]);

        if (!$article) {
            throw $this->createNotFoundException(sprintf('NO articles for slug %s', $slug));
        }


        $comments = [
            'Loren text etexteasd nawnjqwd',
            'LOrem Ipsum atext awd nqwajksjh he',
            'Ipsume text teshahhj ejkq asfjr fksmsj'
        ];

        return $this->render('article/show.html.twig',[
            'text' => ucwords(str_replace('-',' ', $slug)),
            'comments' => $comments,
            'article' => $article,
            'slug' => $slug
        ]);
    }

    /**
     * @Route("/news/{slug}/heart", name="like_article", methods={"POST"})
     */

    public function toggleArticleHeart($slug, LoggerInterface $logger)
    {
        //TODO - like/unlike the article

        $logger->info('Article is being liked');
        return new JsonResponse(['hearts' => rand(5, 100)]);
    }
}
