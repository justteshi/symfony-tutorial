<?php

namespace App\Controller;

use App\Repository\CommentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommentAdminController extends AbstractController
{
    /**
     * @Route("/admin/comment", name="app_comment_admin")
     */
    public function index(CommentRepository $repo, Request $request): Response
    {
        $q = $request->get('q');
//        $comments = $repo->findBy([],['createdAt' => 'DESC']);
        $comments = $repo->findAllSearch($q);
        return $this->render('comment_admin/index.html.twig', [
            'comments' => $comments,
        ]);
    }

}
