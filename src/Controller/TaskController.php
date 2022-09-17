<?php 

namespace App\Controller;

use App\Entity\Task;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TaskController extends AbstractController
{
  /**
   * Lista as tarefas do sistema
   */
  public function index(EntityManagerInterface $entity)
  {

    $repository = $entity->getRepository(Task::class); 

    $tasks = $repository->findAll();

    return new Response($this->render("tasks/index.html.twig", [
      "tasks" => $tasks
      ]));
  }

  /**
   * Mostra tarefa específica
   * 
   */

  public function show($id, EntityManagerInterface $entity)
  {
        $repository = $entity->getRepository(Task::class); 
        
        $task = $repository->find($id);

        return new Response($this->render("tasks/show.html.twig", [
            "task" => $task
        ]));
  }

  /**
   * Inserir uma tarefa
   *
   * @return void
   */
  public function create(EntityManagerInterface $entity)
  {
        $task = new Task;
        $task->setTitle("Visitar o cliente X");
        $task->setDescription("Visitar o cliente X por razão X");
        $task->setScheduling(new \DateTime()); //hora atual

        // var_dump($task);
        // var_dump($task->getDescription());

        $entity->persist($task);
        $entity->flush();
        return new Response("Registro criado com sucesso id: " . $task->getId());
  }

}