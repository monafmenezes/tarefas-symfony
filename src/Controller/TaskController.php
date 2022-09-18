<?php 

namespace App\Controller;

use App\Entity\Task;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("task")
 */
class TaskController extends AbstractController
{
  /**
   * Lista tarefas do banco de dados
   * 
   * @Route("/", name="task_index", methods="GET")
   * 
   * 
   * @return Response
   */
  public function index(ManagerRegistry $doctrine)
  {

    $repository = $doctrine->getManager()->getRepository(Task::class); 
  
    return $this->render("tasks/index.html.twig", [
      "tasks" => $repository->findAll()
    ]);
  }


  /**
   * Cria uma nova tarefa
   * 
   * @Route("/new", name="task_new", methods={"GET", "POST"})
   *
   * @param Request $request
   * @return Response
   */
  public function new(ManagerRegistry $doctrine, Request $request) : Response
  {
        $isTokenValid = $this->isCsrfTokenValid('cadastro_tarefas', $request->request->get('_token'));

        if ($request->isMethod("POST") && $isTokenValid) {

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
  * Mostra uma tarefa específica 
  * 
  * @Route("/{id}", name="task_show", methods="GET")
  *
  * @param Task $task
  * @param ManagerRegistry $doctrine
  * @return void
  */

  public function show(Task $task, ManagerRegistry $doctrine)
  {
      return $this->render("tasks/show.html.twig", [
            "task" => $task
      ]);
  }

  /**
   * Edita uma tarefa no banco de dados
   *  
   * @Route("/{id}/edit", name="task_edit",  methods={"GET", "POST"})
   * @param Request $request
   * @param Task $task
   * @return Response
   */
  public function edit(Request $request, Task $task, ManagerRegistry $doctrine): Response
  {
    $isTokenValid = $this->isCsrfTokenValid('cadastro_tarefas', $request->request->get('_token'));

    if ($request->isMethod("POST") && $isTokenValid) {
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
   * Apaga uma tarefa no banco de dados
   * @Route("/{id}", name="task_delete",  methods="DELETE")
   * @param Task $task
   * @return Response
   */
  
  public function delete(Task $task, ManagerRegistry $doctrine, Request $request): Response
  {
    $isTokenValid = $this->isCsrfTokenValid('deletar_tarefa', $request->request->get('_token'));

    if ($isTokenValid) {
      $entity = $doctrine->getManager();
      $entity->remove($task);
      $entity->flush();
    }

    return $this->redirectToRoute("task_index");
  }

}   