<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{
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
    public function show($slug)
    {
        $comments = [
            'Loren text etexteasd nawnjqwd',
            'LOrem Ipsum atext awd nqwajksjh he',
            'Ipsume text teshahhj ejkq asfjr fksmsj'
        ];
        return $this->render('article/show.html.twig',[
            'text' => ucwords(str_replace('-',' ', $slug)),
            'comments' => $comments
        ]);
    }
}
