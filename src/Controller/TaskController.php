<?php 

namespace App\Controller;

use App\Entity\Task;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class TaskController extends AbstractController
{
  /**
   * Lista as tarefas do sistema
   */
  public function index(ManagerRegistry $doctrine)
  {

    $repository = $doctrine->getManager()->getRepository(Task::class); 
  
    return $this->render("tasks/index.html.twig", [
      "tasks" => $repository->findAll()
    ]);
  }

  /**
   * Mostra tarefa específica
   * 
   */

  public function show(Task $task, ManagerRegistry $doctrine)
  {
      return $this->render("tasks/show.html.twig", [
            "task" => $task
      ]);
  }

  /**
   * Inserir uma tarefa
   *
   * @return void
   */
  public function create(ManagerRegistry $doctrine)
  {
        $task = new Task;
        $task->setTitle("Visitar o cliente X");
        $task->setDescription("Visitar o cliente X por razão X");
        $task->setScheduling(new \DateTime()); //hora atual

        $entity = $doctrine->getManager();
        $entity->persist($task);
        $entity->flush();

        $this->generateUrl("task_show", ["id" => $task->getId()]);
        return $this->redirectToRoute("task_show", ["id" => $task->getId()]);
  }

}   