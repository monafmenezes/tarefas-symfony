<?php 

namespace App\Controller;

use App\Entity\Task;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
   * Cria uma nova tarefa
   *
   * @param Request $request
   * @return Response
   */
  public function new(ManagerRegistry $doctrine, Request $request) : Response
  {
        if ($request->isMethod("POST")) {

            // var_dump(
            //   $request->request->get('title')
            // );

            // var_dump($request->request->get("title") == ""); // verifica se o campo é vazio
            // return new Response("");

            $task = new Task;
            $task->setTitle($request->request->get('title'));
            $task->setDescription($request->request->get('description'));
            $task->setScheduling(new \DateTime()); //hora atual

            $entity = $doctrine->getManager();
            $entity->persist($task);
            $entity->flush();

            $this->generateUrl("task_show", ["id" => $task->getId()]);
            return $this->redirectToRoute("task_show", ["id" => $task->getId()]);
        }

        // var_dump($request->headers->all());

        //var_dump($request->server->all());

        // var_dump($request->attributes->all());
        
        return $this->render("tasks/new.html.twig");
  }

  /**
   * Editamos as tarefas
   *
   * @param Request $request
   * @param Task $task
   * @return Response
   */
  public function edit(Request $request, Task $task, ManagerRegistry $doctrine): Response
  {
    if ($request->isMethod("POST")) {
        $task->setTitle($request->request->get('title'));
        $task->setDescription($request->request->get('description'));

        $doctrine->getManager()->flush();

        return $this->redirectToRoute("task_show", ['id' => $task->getId()]);
    }
    return $this->render("tasks/edit.html.twig", [
      "task" => $task
    ]);
  }

  /**
   * Undocumented function
   *
   * @param Task $task
   * @return Response
   */
  
  public function delete(Task $task, ManagerRegistry $doctrine): Response
  {
    $entity = $doctrine->getManager();
    $entity->remove($task);
    $entity->flush();

    return $this->redirectToRoute("task_index");
  }

}   