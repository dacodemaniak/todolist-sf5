<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
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
     * @Route("/task", methods={"GET", "HEAD"}, name="task")
     */
    public function index(): Response
    {
        $this->tasks = $this->getDoctrine()->getRepository(Task::class)->findAll();
        return $this->render('task/index.html.twig', [
            "tasks" => $this->tasks,
        ]);
    }

    /**
     * @Route("/task", methods={"POST", "HEAD"}, name="add_task")
     */
    public function addTask(Request $request): Response {
        // Get the body content
        $jsonData = json_decode($request->getContent());
        
        $newTask = new Task();
        $newTask
            ->setTitle($jsonData->title)
            ->setSummary($jsonData->summary)
            ->setCreatedAt(\DateTime::createFromFormat("Y-m-d", $jsonData->createdAt))
            ->setIsEnabled($jsonData->isEnabled)
            ->setPriority($jsonData->priority);
        // Get the entity Manager
        $entityManager = $this->getDoctrine()->getManager();
        
        // Persist the new task
        $entityManager->persist($newTask);
        
        // Flush datas
        $entityManager->flush();
        
        return $this->render('task/index.html.twig', [
            "tasks" => $this->getDoctrine()->getRepository(Task::class)->findAll(),
        ]);
    }
    
    /**
     * @Route("/task", methods={"PUT", "HEAD"}, name="update_task")
     * 
     * @param Request $request
     * @return Response
     */
    public function updateTask(Request $request): Response {
        // Get the id of the task to update
        $id = $request->query->get("id");
        
        // Get the task to update from his id
        $repository = $this->getDoctrine()->getRepository(Task::class);
        $task = $repository->find($id);
        
        // Get the request payload (body)
        $jsonData = json_decode($request->getContent());
        
        // Update the task content
        $task
            ->setTitle($jsonData->title)
            ->setSummary($jsonData->summary)
            ->setPriority($jsonData->priority);
        
        // Persist and flush updated datas
        $this->getDoctrine()->getManager()->persist($task);
        $this->getDoctrine()->getManager()->flush();
        
        return $this->render('task/index.html.twig', [
            "tasks" => $this->getDoctrine()->getRepository(Task::class)->findAll(),
        ]);
    }
    
    /**
     * @Route("/task/{id}", name="one_task", methods={"GET", "HEAD"}, requirements={"id"="\d+"})
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
     * @Route("/task/{id}", name="delete_task", methods={"DELETE", "HEAD"}, requirements={"id"="\d+"})
     *  
     * @param int $id
     * @return Response
     */
    public function deleteTask(int $id): Response {
        $repository = $this->getDoctrine()->getRepository(Task::class);
        
        $task = $repository->find($id); // Récupère la tâche souhaitée
        
        if ($task) {
            $this->getDoctrine()->getManager()->remove($task);
            
            $this->getDoctrine()->getManager()->flush();
            
            return new Response(
                "Task " . $id . " supprimée",
                Response::HTTP_OK,
                [
                    "content-type" => "application/json"
                ]
            );
        }
        
        return new Response(
            "Task " . $id . " non trouvé",
            Response::HTTP_NOT_FOUND,
            [
                "content-type" => "application/json"
            ]
        );
    }
    
    /**
     * @Route("/task/setup", name="task_setup")
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
