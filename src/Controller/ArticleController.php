<?php

namespace App\Controller;

use App\Service\MarkdownHelper;
use App\Service\SlackClient;
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
    public function homepage()
    {
        return $this->render('article/home.html.twig');
    }

    /**
     * @Route("/news/{slug}", name="article_show")
     */
    public function show($slug, MarkdownHelper $markdownHelper, SlackClient $slack)
    {
        if($slug == 'slack') {
            $slack->sendMessage(
                'New Beautiful Tiger',
                'Pretty new message from tigerland'
            );
        }


        $articleText = <<<EOF
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
EOF;

        $articleText = $markdownHelper->parse($articleText);

        $comments = [
            'Loren text etexteasd nawnjqwd',
            'LOrem Ipsum atext awd nqwajksjh he',
            'Ipsume text teshahhj ejkq asfjr fksmsj'
        ];

        return $this->render('article/show.html.twig',[
            'text' => ucwords(str_replace('-',' ', $slug)),
            'comments' => $comments,
            'articleText' => $articleText,
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
