<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Task;

class TaskController extends AbstractController
{
    /**
     * Collection d'objets de type Task
     * @var array
     */
    private $tasks;
    
    public function __construct() {
        $task = new Task();
        $task
            ->setTitle("Tâche 1")
            ->setSummary("Un test pour la tâche n° 1")
            ->setCreatedAt(new \DateTime())
            ->setPriority(3);
        $this->tasks[] = $task;
        
        $otherTask = clone $task;
        $otherTask
            ->setTitle("Tâche 2")
            ->setSummary("Test pour la tâche 2");
        $this->tasks[] = $otherTask;
    }
    
    /**
     * @Route("/task", name="task")
     */
    public function index(): Response
    {
        return $this->render('task/index.html.twig', [
            "tasks" => $this->tasks,
        ]);
    }
    
    /**
     * @Route("/task/{id}", name="one_task", requirements={"id"="\d+"})
     * 
     * @param int $id
     * @return Response
     */
    public function aTask($id): Response {
        return $this->render('task/task.html.twig', [
            "task" => $this->tasks[$id]
        ]);
    }
}
