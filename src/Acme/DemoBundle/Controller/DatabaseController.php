<?php

namespace Acme\DemoBundle\Controller;

use Acme\DemoBundle\Entity\Todo;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

// Import annotations
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;

class DatabaseController extends Controller
{
    /**
     * @Route("/create", name="database_create")
     * @Method("POST")
     * @Template
     */
    public function createAction(Request $request)
    {
        $todo = new Todo();
        $form = $this->getTodoForm($todo);

        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($todo);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('database_list'));
    }

    /**
     * @Route("/list", name="database_list")
     * @Template
     */
    public function listAction()
    {
        $em = $this->getDoctrine()->getManager();
        return array(
            'todos' => $em->getRepository('AcmeDemoBundle:Todo')->findAll(),
            'form'  => $this->getTodoForm()->createView()
        );
    }

    protected function getTodoForm(Todo $todo = null)
    {
        return $this->createFormBuilder($todo)
            ->add('title')
            ->getForm()
        ;
    }
}
