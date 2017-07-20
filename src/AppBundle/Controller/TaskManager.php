<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Tasks;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class TaskManager extends Controller
{
  /**
   * @Route("/", name="main")
   */
  public function indexAction(Request $request)
  {
    $tasks = $this->getDoctrine()->getRepository("AppBundle:Tasks")
        ->findAll();

    return $this->render('task_manager/index.html.twig', [
        'tasks' => $tasks
    ]);
  }

  /**
   * @Route("/delete/{id}", name="task.delete")
   */
  public function delete($id)
  {


    $task = $this->getDoctrine()->getRepository("AppBundle:Tasks")
        ->find($id);

    $em = $this->getDoctrine()->getManager();


    $em->remove($task);
    $em->flush();

    $tasks = $this->getDoctrine()->getRepository("AppBundle:Tasks")
        ->findAll();

    return $this->render('task_manager/index.html.twig', [
        'tasks' => $tasks
    ]);
  }

  /**
   * @Route("/create", name="task.create")
   */
  public function create(Request $request)
  {

    $name = $request->request->get("name");

    $em = $this->getDoctrine()->getManager();

    $task = new Tasks();
    $task->setName($name);
    $task->setStatus("Incomplete");

    $em->persist($task);
    $em->flush();

    $tasks = $this->getDoctrine()->getRepository("AppBundle:Tasks")
        ->findAll();

    return $this->render('task_manager/index.html.twig', [
        'tasks' => $tasks
    ]);
  }


  /**
   * @Route("/edit", name="task.edit")
   */
  public function edit(Request $request)
  {

    $id = $request->request->get("id");
    $name = $request->request->get("name");

    $task = $this->getDoctrine()->getRepository("AppBundle:Tasks")
        ->find($id);

    $em = $this->getDoctrine()->getManager();

    $task->setName($name);

    $em->persist($task);
    $em->flush();

    $tasks = $this->getDoctrine()->getRepository("AppBundle:Tasks")
        ->findAll();

    return $this->render('task_manager/index.html.twig', [
        'tasks' => $tasks
    ]);

  }

  /**
   * @Route("/edit/state", name="task.edit.state")
   */
  public function stateChange(Request $request)
  {

    $id = $request->request->get("id");
    $state = $request->request->get("state");

    $task = $this->getDoctrine()->getRepository("AppBundle:Tasks")
        ->find($id);

    $em = $this->getDoctrine()->getManager();

    $task->setStatus($state);
    $em->persist($task);
    $em->flush();

    $tasks = $this->getDoctrine()->getRepository("AppBundle:Tasks")
        ->findAll();

    return $this->render('task_manager/index.html.twig', [
        'tasks' => $tasks
    ]);

  }

}
