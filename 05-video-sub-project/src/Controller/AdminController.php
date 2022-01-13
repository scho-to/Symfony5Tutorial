<?php

namespace App\Controller;

use App\Entity\Category;
use App\Utils\CategoryTreeAdminList;
use App\Utils\CategoryTreeAdminOptionList;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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

    #[Route('/categories', name: 'categories')]
    public function categories(CategoryTreeAdminList $categories): Response
    {
        $categories->getCategoryList($categories->buildTree());
        return $this->render('admin/categories.html.twig', [
            'categories' => $categories->categorylist
        ]);
    }

    #[Route('/edit-category/{id}', name: 'edit_category')]
    public function editCategory(Category $category): Response
    {
        return $this->render('admin/edit_category.html.twig');
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

    public function getAllCategories(CategoryTreeAdminOptionList $categories): Response
    {
        $categories->getCategoryList($categories->buildTree());
        return $this->render('admin/_all_categories.html.twig', [
            'categories' => $categories->categorylist
        ]);
    }
}
