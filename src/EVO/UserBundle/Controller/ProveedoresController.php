<?php

namespace EVO\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use EVO\UserBundle\Entity\Proveedores;
use EVO\UserBundle\Form\ProveedoresType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;



class ProveedoresController extends Controller
{
	
	
	public function listadoproveedoresAction(Request $request)
	{
		 
		 
		$em = $this->getDoctrine()->getManager();
		$dql = "SELECT u FROM EVOUserBundle:Proveedores u ORDER BY u.id DESC";
		$prov = $em->createQuery($dql);
	
		$paginator = $this->get('knp_paginator');
		$pagination = $paginator->paginate(
				$prov, $request->query->getInt('page', 1),
				10
				);
	
		$deleteFormAjax = $this->createCustomForm(':PROVEEDORES_ID', 'DELETE', 'evo_proveedores_delete');
	
		return $this->render('EVOUserBundle:Proveedores:listadoproveedores.html.twig', array('pagination' => $pagination, 'delete_form_ajax' => $deleteFormAjax->createView()));
	}
	
	
	
	public function addAction()
	{
		$prov = new Proveedores();
		$form = $this ->createCreateForm($prov);
			
		return $this->render('EVOUserBundle:Proveedores:add.html.twig', array('form' => $form->createView()));
			
	}
	
	
	
	
	
	
	private function createCreateForm(Proveedores $entity)
	{
		$form = $this ->createForm(new ProveedoresType(), $entity, array (
				'action' => $this->generateUrl('evo_proveedores_create'),
				'method' => 'POST'
	
		));
			
		return $form;
			
	}
	
	
	
	public function createAction(Request $request)
	{
	
	
		$prov = new Proveedores();
		$form = $this->createCreateForm($prov);
		$form->handleRequest($request);
	
		if($form->isValid())
		{
				
			$em = $this->getDoctrine()->getManager();
			$em->persist($prov);
			$em->flush();
	
			$successMessage = ('El proveedor ha sido registrado');
			$this->addFlash('mensaje', $successMessage);
	
			return $this->redirectToRoute('evo_proveedores_listadoproveedores');
		}
			
	
		return $this->render('EVOUserBundle:Proveedores:add.html.twig', array('form' => $form->createView()));
	}
	
	
	
	
	
	public function viewAction($id)
	{
			
		$repository = $this->getDoctrine()->getRepository('EVOUserBundle:Proveedores');
			
		$prov = $repository -> find($id);
			
		if (!$prov){
			throw $this->createNotFoundException('Proveedor no encontrado');
		}
			
		$deleteForm = $this->createDeleteForm($prov);
			
		return $this->render('EVOUserBundle:Proveedores:view.html.twig', array('prov' => $prov, 'delete_form' => $deleteForm->createView()));
			
			
	}
	
	
	
	public function editAction($id)
	{
			
		$em = $this->getDoctrine()->getManager();
		$prov = $em->getRepository('EVOUserBundle:Proveedores')->find($id);
			
		if (!$prov){
			throw $this->createNotFoundException('Proveedor no encontrado');
		}
			
		$form = $this->createEditForm($prov);
			
		return $this->render('EVOUserBundle:Proveedores:edit.html.twig', array ('prov' => $prov, 'form' => $form->createView()));
			
			
	}
	
	
	private function createEditForm(Proveedores $entity)
	{
			
		$form = $this->createForm(new ProveedoresType(), $entity, array('action' => $this->generateUrl('evo_proveedores_update', array ('id' => $entity->getId())), 'method' => 'PUT'));
			
		return $form;
			
	}
	
	
	public function updateAction($id, Request $request)
	{
	
		$em = $this->getDoctrine()->getManager();
			
		$prov = $em->getRepository('EVOUserBundle:Proveedores')->find($id);
		if(!$prov)
		{
			$messageException = ('Proveedor no encontrado');
			throw $this->createNotFoundException($messageException);
		}
			
		$form = $this->createEditForm($prov);
		$form->handleRequest($request);
			
		if($form->isSubmitted() && $form->isValid())
		{
	
			$em->flush();
	
			$successMessage = ('El proveedor ha sido modificado');
			$this->addFlash('mensaje', $successMessage);
			return $this->redirectToRoute('evo_proveedores_listadoproveedores');
		}
		return $this->render('EVOUserBundle:Proveedores:edit.html.twig', array('prov' => $prov, 'form' => $form->createView()));
			
	}
	
	
	
	private function createDeleteForm($prov)
	{
			
		return $this->createFormBuilder()
		->setAction($this->generateUrl('evo_proveedores_delete', array('id' => $prov->getId())))
		->setMethod('DELETE')
		->getForm();
	}
	
	
	
	
	public function deleteAction(Request $request, $id)
	
	{
		$em = $this->getDoctrine()->getManager();
			
		$prov = $em->getRepository('EVOUserBundle:Proveedores')->find($id);
			
		if(!$prov)
		{
			$messageException = ('Proveedores no encontrado');
			throw $this->createNotFoundException($messageException);
		}
			
	
			
		// $form = $this->createDeleteForm($user);
		$form = $this->createCustomForm($prov->getId(), 'DELETE', 'evo_proveedores_delete');
		$form->handleRequest($request);
			
		if($form->isSubmitted() && $form->isValid())
		{
			
			$em->remove($prov);
			$em->flush();
			$this->addFlash('mensaje', 'Proveedor eliminado');
			return $this->redirectToRoute('evo_proveedores_listadoproveedores');
		}
	
	}
	
	
	
	
	
	private function createCustomForm($id, $method, $route)
	{
		return $this->createFormBuilder()
		->setAction($this->generateUrl($route, array('id' => $id)))
		->setMethod($method)
		->getForm();
	}
	
	 
	}
	