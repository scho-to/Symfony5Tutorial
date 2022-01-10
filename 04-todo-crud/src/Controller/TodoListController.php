<?php

namespace App\Controller;

use App\Entity\Task;
use App\Repository\TaskRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;

class TodoListController extends AbstractController
{
    #[Route("/",name:"todo_list")]
    public function index(TaskRepository $taskRepository): Response
    {
        return $this->render('todo_list/index.html.twig', [
            'controller_name' => 'TodoListController',
            'tasks' => $taskRepository->findBy([],['id' => 'DESC'])
        ]);
    }

    #[Route("/create",name:"create_task",methods:["POST"])]
    public function create(Request $request, ManagerRegistry $doctrine): Response
    {
        $title = trim($request->request->get("title"));
        if(empty($title))
        {
            return $this->redirectToRoute('todo_list');
        }

        $entityManager = $doctrine->getManager();

        $task = new Task();
        $task->setTitle($title);
        $task->setStatus(false);
        $entityManager->persist($task);
        $entityManager->flush();
        return $this->redirectToRoute('todo_list');
    }

    #[Route("/switch-status/{id}",name:"switch_status")]
    public function switchStatus(Task $id, ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();

        $id->setStatus(!$id->getStatus());

        $entityManager->persist($id);
        $entityManager->flush();

        return $this->redirectToRoute('todo_list');
    }

    #[Route("/delete/{id}",name:"delete_task")]
    public function deleteTask(Task $id, ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();
        
        $entityManager->remove($id);
        $entityManager->flush();

        return $this->redirectToRoute('todo_list');
    }
}
