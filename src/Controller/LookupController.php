<?php

namespace App\Controller;

use App\Repository\ArticlesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LookupController extends AbstractController
{
    #[Route('/lookup', name: 'app_lookup')]
    public function index(Request $request, ArticlesRepository $articlesRepository): Response
    {
        $search = $request->query->get('search');
        return $this->render('lookup/index.html.twig', [
            'controller_name' => 'LookupController',
            'articles'=>$articlesRepository->findBySearch($search)
        ]);
    }
}
