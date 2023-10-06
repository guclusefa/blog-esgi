<?php

namespace App\Controller\Backend;

use App\Constants\RouteConstants;
use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/categories')]
class CategoryController extends AbstractController
{
    #[Route('/', name: RouteConstants::ADMIN_CATEGORIES, methods: ['GET'])]
    public function index(CategoryRepository $categoryRepository): Response
    {
        return $this->render('backend/category/index.html.twig', [
            'categories' => $categoryRepository->findAll(),
        ]);
    }

    #[Route('/create', name: RouteConstants::ADMIN_CATEGORIES_CREATE, methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($category);
            $entityManager->flush();

            return $this->redirectToRoute(RouteConstants::ADMIN_CATEGORIES, [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('backend/category/new.html.twig', [
            'category' => $category,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: RouteConstants::ADMIN_CATEGORIES_ITEM, methods: ['GET'])]
    public function show(Category $category): Response
    {
        return $this->render('backend/category/show.html.twig', [
            'category' => $category,
        ]);
    }

    #[Route('/{id}/edit', name: RouteConstants::ADMIN_CATEGORIES_EDIT, methods: ['GET', 'POST'])]
    public function edit(Request $request, Category $category, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute(RouteConstants::ADMIN_CATEGORIES, [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('backend/category/edit.html.twig', [
            'category' => $category,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: RouteConstants::ADMIN_CATEGORIES_DELETE, methods: ['POST'])]
    public function delete(Request $request, Category $category, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$category->getId(), $request->request->get('_token'))) {
            $entityManager->remove($category);
            $entityManager->flush();
        }

        return $this->redirectToRoute(RouteConstants::ADMIN_CATEGORIES, [], Response::HTTP_SEE_OTHER);
    }
}
