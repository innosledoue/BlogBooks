<?php

namespace App\Controller\User;

use App\Entity\Articles;
use App\Form\Articles1Type;
use App\Repository\ArticlesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/article')]
class ArticleController extends AbstractController
{
    #[Route('/', name: 'app_user_article_index', methods: ['GET'])]
    public function index(ArticlesRepository $articlesRepository): Response
    {
        return $this->render('user/article/index.html.twig', [
            'articles' => $articlesRepository->findAll(),
        ]);
    }

    #[Route('/{id}', name: 'app_user_article_show', methods: ['GET'])]
    public function show(Articles $article): Response
    {
        
        return $this->render('user/article/show.html.twig', [
            'article' => $article,
            'comments'=> $article->getComments()
        ]);
    }

}
