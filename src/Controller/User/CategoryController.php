<?php

namespace App\Controller\User;

use App\Entity\Category;
use App\Form\Category1Type;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/category')]
class CategoryController extends AbstractController
{
    #[Route('/', name: 'app_user_category_index', methods: ['GET'])]
    public function index(CategoryRepository $categoryRepository): Response
    {
        
        return $this->render('user/category/index.html.twig', [
            'categories' => $categoryRepository->findAll(),
        ]);
    }

    #[Route('/{id}', name: 'app_user_category_show', methods: ['GET'])]
    public function show(Category $category): Response
    {
        $articles = $category->getArticles();
        return $this->render('user/category/show.html.twig', [
            'category' => $category,
            'articles' => $articles
        ]);
    }
}
