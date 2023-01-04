<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{
    /**
     * @Route("/")
     */
    public function homepage()
    {
        return new Response('My first page');
    }

    /**
     * @Route("/news/{slug}")
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
