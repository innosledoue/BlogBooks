<?php

namespace App\Controller\User;

use App\Entity\Articles;
use App\Entity\Comments;
use App\Form\CommentsType;
use App\Repository\CommentsRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/article/{id}/comments')]
class CommentsController extends AbstractController
{
    #[Route('/', name: 'app_user_comments_index', methods: ['GET'])]
    public function index(CommentsRepository $commentsRepository): Response
    {
        return $this->render('user/comments/index.html.twig', [
            'comments' => $commentsRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_user_comments_new', methods: ['GET', 'POST'])]
    public function new(Request $request, Articles $article, CommentsRepository $commentsRepository,
    EntityManagerInterface $entityManager): Response
    {
        $comment = new Comments();
        $comment->setUser($this->getUser());
        $comment->setArticles($article);
        $comment->setCreatedAt(new DateTimeImmutable());
        $form = $this->createForm(CommentsType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $entityManager->persist($comment);
            $entityManager->flush();

            $this->addFlash('success', 'votre commentaire a éte envoyé avec succès !');

            return $this->redirectToRoute('app_user_article_show', [
                'id'=> $article->getId()
            ], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user/comments/new.html.twig', [
            'comment' => $comment,
            'form' => $form,
        ]);
    }
}
