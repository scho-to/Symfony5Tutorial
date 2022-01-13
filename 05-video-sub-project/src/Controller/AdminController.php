<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use App\Utils\CategoryTreeAdminList;
use App\Utils\CategoryTreeAdminOptionList;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin')]
class AdminController extends AbstractController
{
    #[Route('/', name: 'admin_main_page')]
    public function index(): Response
    {
        return $this->render('admin/my_profile.html.twig');
    }

    #[Route('/categories', name: 'categories', methods: ['GET', 'POST'])]
    public function categories(CategoryTreeAdminList $categories, Request $request, CategoryRepository $categoryRepository, ManagerRegistry $doctrine): Response
    {
        $categories->getCategoryList($categories->buildTree());

        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);
        $is_invalid = null;
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $category->setName($request->request->get('category')['name']);
            $parent = $categoryRepository->find($request->request->get('category')['parent']);
            $category->setParent($parent);

            $entityManager = $doctrine->getManager();
            $entityManager->persist($category);
            $entityManager->flush();

            return $this->redirectToRoute('categories');
        }
        elseif($request->isMethod('post'))
        {
            $is_invalid = ' is-invalid';
        }

        return $this->render('admin/categories.html.twig', [
            'categories' => $categories->categorylist,
            'form' => $form->createView(),
            'isInvalid' => $is_invalid 
        ]);
    }

    #[Route('/edit-category/{id}', name: 'edit_category')]
    public function editCategory(Category $category): Response
    {
        return $this->render('admin/edit_category.html.twig', [
            'category' => $category
        ]);
    }

    #[Route('/delete-category/{id}', name: 'delete_category')]
    public function deleteCategory(Category $category,  ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();
        $entityManager->remove($category);
        $entityManager->flush();
        return $this->redirectToRoute('categories');;
    }

    #[Route('/videos', name: 'videos')]
    public function videos(): Response
    {
        return $this->render('admin/videos.html.twig');
    }

    #[Route('/upload-video', name: 'upload_video')]
    public function uploadVideo(): Response
    {
        return $this->render('admin/upload_video.html.twig');
    }

    #[Route('/users', name: 'users')]
    public function users(): Response
    {
        return $this->render('admin/users.html.twig');
    }

    public function getAllCategories(CategoryTreeAdminOptionList $categories, $editedCategory = null): Response
    {
        $categories->getCategoryList($categories->buildTree());
        return $this->render('admin/_all_categories.html.twig', [
            'categories' => $categories->categorylist,
            'editedCategory' => $editedCategory
        ]);
    }
}
