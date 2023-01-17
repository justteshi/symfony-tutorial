<?php

namespace App\Controller;

use App\Repository\CommentRepository;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @IsGranted("ROLE_ADMIN")
 */
class CommentAdminController extends AbstractController
{
    /**
     * @Route("/admin/comment", name="app_comment_admin")
     */
    public function index(CommentRepository $repo, Request $request, PaginatorInterface $paginator ): Response
    {
        $q = $request->get('q');
        $query = $repo->getSearchQueryBuilder($q);

        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            10 /*limit per page*/
        );

        return $this->render('comment_admin/index.html.twig', [
            'pagination'=> $pagination
        ]);
    }

}
