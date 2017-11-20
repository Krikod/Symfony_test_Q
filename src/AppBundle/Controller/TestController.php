<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Task;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Form\TaskType;
use Symfony\Component\BrowserKit\Request;

class TestController extends Controller
{
    public function indexAction()
    {
        return $this->render('@App/index.html.twig');
    }

    public function newAction(Request $request)
    {
        $task = new Task();

        $form = $this->createForm(TaskType::class, $task);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $task = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($task);
            $em->flush();

            return $this->redirectToRoute('task_success');
        }
        return $this->render('@App/index.html.twig', array(
            'form' => $form->createView(),
        ));
    }

}
