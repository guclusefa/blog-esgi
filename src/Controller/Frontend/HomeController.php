<?php

namespace App\Controller\Frontend;

use App\Constants\RouteConstants;
use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    public function __construct
    (
        private readonly ArticleRepository $articleRepository
    )
    {
    }

    #[Route('/', name: RouteConstants::HOME)]
    public function index(): Response
    {
        // Get 3 latest articles
        $articles = $this->articleRepository->findBy([], ['createdAt' => 'DESC'], 3);

        return $this->render('frontend/home/index.html.twig', [
            'controller_name' => 'HomeController',
            'articles' => $articles
        ]);
    }
}
