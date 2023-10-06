<?php

namespace App\Controller\Backend;

use App\Constants\RouteConstants;
use App\Constants\ToastConstants;
use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/articles')]
class ArticleController extends AbstractController
{
    public function __construct
    (
        private readonly ArticleRepository      $articleRepository,
        private readonly EntityManagerInterface $em
    )
    {
    }

    private function checkArticle(?Article $article): void
    {
        if (!$article instanceof Article) {
            $this->addFlash(ToastConstants::ERROR, 'Article not found');
            throw $this->createNotFoundException('Article not found');
        }
    }

    #[Route('', name: RouteConstants::ADMIN_ARTICLES, methods: ['GET'])]
    public function list(): Response
    {
        $articles = $this->articleRepository->findAll();
        return $this->render('backend/article/list.html.twig', [
            'articles' => $articles,
        ]);
    }

    #[Route('/create', name: RouteConstants::ADMIN_ARTICLE_CREATE, methods: ['GET', 'POST'])]
    public function create(Request $request): Response|RedirectResponse
    {
        $article = new Article();

        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $article->setAuthor($this->getUser());

            $this->em->persist($article);
            $this->em->flush();
            $this->addFlash(ToastConstants::SUCCESS, 'Article created successfully!');

            return $this->redirectToRoute(RouteConstants::ADMIN_ARTICLES);
        }

        return $this->render('backend/article/create.html.twig', [
            'form' => $form
        ]);
    }

    #[Route('/{slug}', name: RouteConstants::ADMIN_ARTICLE_ITEM, methods: ['GET'])]
    public function item(?Article $article): Response
    {
        $this->checkArticle($article);
        return $this->render('backend/article/item.html.twig', [
            'article' => $article,
        ]);
    }

    #[Route('/{slug}/edit', name: RouteConstants::ADMIN_ARTICLE_EDIT, methods: ['GET', 'POST'])]
    public function edit(Request $request, ?Article $article): Response|RedirectResponse
    {
        $this->checkArticle($article);

        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->flush();
            $this->addFlash(ToastConstants::SUCCESS, 'Article updated successfully!');
            return $this->redirectToRoute(RouteConstants::ADMIN_ARTICLES);
        }

        return $this->render('backend/article/edit.html.twig', [
            'form' => $form,
            'article' => $article
        ]);
    }

    #[Route('/{slug}/delete', name: RouteConstants::ADMIN_ARTICLE_DELETE, methods: ['GET', 'POST'])]
    public function delete(Request $request, ?Article $article): Response|RedirectResponse
    {
        $this->checkArticle($article);

        if ($this->isCsrfTokenValid('delete' . $article->getId(), $request->request->get('_token'))) {
            $this->em->remove($article);
            $this->em->flush();
            $this->addFlash(ToastConstants::SUCCESS, 'Article deleted successfully!');
            return $this->redirectToRoute(RouteConstants::ADMIN_ARTICLES);
        }

        return $this->render('backend/article/delete.html.twig', [
            'article' => $article
        ]);
    }
}
