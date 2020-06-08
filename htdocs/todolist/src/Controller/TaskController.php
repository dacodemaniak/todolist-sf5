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
    
    public function __construct() {}
    
    /**
     * @Route("/task", name="task")
     */
    public function index(): Response
    {
        $this->tasks = $this->getDoctrine()->getRepository(Task::class)->findAll();
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
        $repository = $this->getDoctrine()->getRepository(Task::class);
        return $this->render('task/task.html.twig', [
            "task" => $repository->find($id)
        ]);
    }
    
    /**
     * @Route("/setup", name="task_setup")
     * 
     * @return Response
     */
    public function fixture(): Response {
       $this->setTasks();
        
       return new Response(
           "2 rows were added to Task entity",
           Response::HTTP_OK,
           [
               "content-type" => "text/plain"
           ]
       );
    }
    
    private function setTasks() {
        $task = new Task(); // Première tâche
        $task
            ->setTitle("Tâche 1")
            ->setSummary("Un test pour la tâche n° 1")
            ->setCreatedAt(new \DateTime())
            ->setPriority(3);
        // Tell Doctrine to persist the new Entity
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($task);
        
        $task = new Task(); // Deuxième tâche
        $task
            ->setTitle("Tâche 2")
            ->setSummary("La tâche n° 2")
            ->setCreatedAt(new \DateTime())
            ->setPriority(1);
        $entityManager->persist($task);
        
        // On peut envoyer la transaction entière : 2 insertions
        $entityManager->flush(); // Write really datas for the current transaction
    }
}
