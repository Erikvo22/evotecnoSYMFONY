<?php

namespace EVO\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use EVO\UserBundle\Entity\Task;
use EVO\UserBundle\Form\TaskType;


class TaskController extends Controller
{
	
	public function listadoAction(Request $request)
	{
		$em = $this->getDoctrine()->getManager();
		$dql = "SELECT t FROM EVOUserBundle:Task t ORDER BY t.id DESC";
		$tasks = $em->createQuery($dql);
		
		$paginator = $this->get('knp_paginator');
		$pagination = $paginator->paginate(
			
			$tasks,
			$request->query->getInt('page', 1),
				3
				
		);
		
		return $this-> render('EVOUserBundle:Task:listado.html.twig', array ('pagination' => $pagination));
	
	}
	
	
	
	
	
	public function addAction()
	{
		$task = new Task();
		$form = $this->createCreateForm($task);
		
		return $this->render('EVOUserBundle:Task:add.html.twig', array('form' => $form->createView()));
	}
	
	
	
	
	
	
	private function createCreateForm(Task $entity)
	{
		$form = $this->createForm(new TaskType(), $entity, array(
				'action' => $this->generateUrl('evo_task_create'),
				'method' => 'POST'
				
		));
		return $form;
	}
	
	
	
	
	
	
	
	public function createAction(Request $request)
	{
		$task = new Task();
		$form = $this->createCreateForm($task);
		$form->handleRequest($request);
		
		if($form->isValid())
		{
			$task->setStatus(0);
			$em = $this->getDoctrine()->getManager();
			$em->persist($task);
			$em ->flush();
			
			$this->addFlash('mensaje', 'La tarea ha sido creada');
			return $this->redirectToRoute('evo_task_listado');
			
		}
		
		return $this->render('EVOUserBundle:Task:add.html.twig', array('form' => $form->createView()));
	}
	
	
	
	
	public function viewAction($id)
	{
		$task = $this->getDoctrine()->getRepository('EVOUserBundle:Task')->find($id);
		
		if(!$task)
		{
			throw $this-> createNotFoundException('La tarea ya no existe');
		
		}
		
		$deleteForm = $this->createCustomForm($task->getId(), 'DELETE', 'evo_task_delete');
		
		$user = $task->getUser();
		
		return $this->render('EVOUserBundle:Task:view.html.twig', array('task' => $task, 'user' => $user, 'delete_form' => $deleteForm->createView()));
	}
	
	
	
	
	
	
	public function editAction($id)
	{
		$em = $this ->getDoctrine()->getManager();
		
		$task = $em->getRepository('EVOUserBundle:Task')->find($id);
		
		if(!$task)
		{
			throw $this-> createNotFoundException('La tarea no se ha encontrado');
		
		}
		
		$form = $this->createEditForm($task);
		
		return $this->render('EVOUserBundle:Task:edit.html.twig', array('task' => $task, 'form' => $form->createView()));
	}
	
	
	
	
	
	
	private function createEditForm(Task $entity)
	{
		$form = $this->createForm(new TaskType(), $entity, array(
				'action' => $this->generateUrl('evo_task_update', array('id' => $entity->getId())),
				'method' => 'PUT'		
		));
		
		return $form;
	}
	
	
	
	
	
	public function updateAction($id, Request $request)
	{
		$em = $this->getDoctrine()->getManager();
	
		$task = $em->getRepository('EVOUserBundle:Task')->find($id);
	
		if(!$task)
		{
			throw $this->createNotFoundException('La tarea no se ha encontrado');
		}
	
		$form = $this->createEditForm($task);
		$form->handleRequest($request);
	
		if($form->isSubmitted() and $form->isValid())
		{
			$task->setStatus(0);
			$em->flush();
			$this->addFlash('mensaje', 'La tarea ha sido modificada');
			return $this->redirectToRoute('evo_task_edit', array('id' => $task->getId()));
		}
	
		return $this->render('EVOUserBundle:Task:edit.html.twig', array('task' => $task, 'form' => $form->createView()));
	}
	
	
	
	
	
	
	
	
	
	
	public function deleteAction(Request $request, $id)
	{
		$em = $this->getDoctrine()->getManager();
	
		$task = $em->getRepository('EVOUserBundle:Task')->find($id);
	
		if(!$task)
		{
			throw $this->createNotFoundException('La tarea no se ha encontrado');
		}
	
		$form = $this->createCustomForm($task->getId(), 'DELETE', 'evo_task_delete');
		$form->handleRequest($request);
	
		if($form->isSubmitted() and $form->isValid())
		{
			$em->remove($task);
			$em->flush();
	
			
			$this->addFlash('mensaje', 'La tarea ha sido eliminada');
	
			return $this->redirectToRoute('evo_task_listado');
		}
	}
	
	
	
	
	private function createCustomForm($id, $method, $route)
	{
		return $this->createFormBuilder()
		->setAction($this->generateUrl($route, array('id' => $id)))
		->setMethod($method)
		->getForm();
	}
	
	
	
	
	public function customAction(Request $request)
	{
		$idUser = $this->get('security.token_storage')->getToken()->getUser()->getId();
	
		$em = $this->getDoctrine()->getManager();
		$dql = "SELECT t FROM EVOUserBundle:Task t JOIN t.user u WHERE u.id = :idUser ORDER BY t.id DESC";
	
		$tasks = $em->createQuery($dql)->setParameter('idUser' , $idUser);
	
		$paginator = $this->get('knp_paginator');
		$pagination = $paginator->paginate(
				$tasks,
				$request->query->getInt('page', 1),
				3
				);
	
		
	
		return $this->render('EVOUserBundle:Task:custom.html.twig', array('pagination' => $pagination));
	}
	
	
	
	
	
	
	public function processAction($id, Request $request)
	{
		$em = $this->getDoctrine()->getManager();
	
		$task = $em->getRepository('EVOUserBundle:Task')->find($id);
	
		if(!$task)
		{
			throw $this>createNotFoundException('Tarea no encontrada');
		}
	
		$form = $this->createCustomForm($task->getId(), 'PUT', 'evo_task_process');
		$form->handleRequest($request);
	
		if($form->isSubmitted() && $form->isValid())
		{
	
			$successMessage = 'La tarea ha sido procesada';
			$warningMessage = 'La tarea ya había sido procesada';
	
			if ($task->getStatus() == 0)
			{
				$task->setStatus(1);
				$em->flush();
	
				if($request->isXMLHttpRequest())
				{
					return new Response(
							json_encode(array('processed' => 1, 'success' => $successMessage)),
							200,
							array('Content-Type' => 'application/json')
							);
				}
			}
			else
			{
				if($request->isXMLHttpRequest())
				{
					return new Response(
							json_encode(array('processed' => 0, 'warning' => $warningMessage)),
							200,
							array('Content-Type' => 'application/json')
							);
				}
			}
		}
	}
}
