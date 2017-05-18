<?php

namespace EVO\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use EVO\UserBundle\Entity\Pedidos;
use EVO\UserBundle\Form\PedidosType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;



class PedidosController extends Controller
{
	
	
	public function listadopedidosAction(Request $request)
	{
		
		
		//PEDIDOS
		$em = $this->getDoctrine()->getManager();
		$dql = "SELECT u FROM EVOUserBundle:Pedidos u ORDER BY u.id DESC";
		$ped = $em->createQuery($dql);
	
		$paginator = $this->get('knp_paginator');
		$pagination = $paginator->paginate(
				$ped, $request->query->getInt('page', 1),
				5
				);
	
		$deleteFormAjax = $this->createCustomForm(':PEDIDOS_ID', 'DELETE', 'evo_pedidos_delete');
		
		$updateForm = $this->createCustomForm(':PEDIDOS_ID', 'PUT', 'evo_pedidos_process');
		
		
		//VENTAS
		$dql2 = "SELECT u FROM EVOUserBundle:Compras u ORDER BY u.id DESC";
		$comp = $em->createQuery($dql2);
		
		$paginator2 = $this->get('knp_paginator');
		$pagination2 = $paginator2->paginate(
				$comp, $request->query->getInt('page', 1),
				5
				);
		
		$deleteFormAjax2 = $this->createCustomForm(':COMPRAS_ID', 'DELETE', 'evo_compras_delete');
		
		$updateForm2 = $this->createCustomForm(':COMPRAS_ID', 'PUT', 'evo_compras_process');
	
		
		
		return $this->render('EVOUserBundle:Pedidos:listadopedidos.html.twig', array('pagination' => $pagination,'pagination2' => $pagination2, 'delete_form_ajax' => $deleteFormAjax->createView(), 'update_form' => $updateForm->createView(), 'delete_form_ajax2' => $deleteFormAjax2->createView(), 'update_form2' => $updateForm2->createView()));
	}
	
	
	
	
	public function addAction()
	{
		$ped = new Pedidos();
		$form = $this ->createCreateForm($ped);
		 
		return $this->render('EVOUserBundle:Pedidos:add.html.twig', array('form' => $form->createView()));
		 
	}
	
	
	
	
	
	
	private function createCreateForm(Pedidos $entity)
	{
		$form = $this ->createForm(new PedidosType(), $entity, array (
				'action' => $this->generateUrl('evo_pedidos_create'),
				'method' => 'POST'
    
		));
		 
		return $form;
		 
	}
	
	
	
	public function createAction(Request $request)
	{
	
	
		$ped = new Pedidos();
		$form = $this->createCreateForm($ped);
		$form->handleRequest($request);
	
		if($form->isValid())
		{
				$ped->setStatus(0);
				$em = $this->getDoctrine()->getManager();
				$em->persist($ped);
				$em->flush();
	
				$successMessage = ('El pedido ha sido registrado');
				$this->addFlash('mensaje', $successMessage);
	
				return $this->redirectToRoute('evo_pedidos_listadopedidos');
			}
			
	
		return $this->render('EVOUserBundle:Pedidos:add.html.twig', array('form' => $form->createView()));
	}
	 
	 
	
	
	
	public function viewAction($id)
	{
		 
		$repository = $this->getDoctrine()->getRepository('EVOUserBundle:Pedidos');
		 
		$ped = $repository -> find($id);
		 
		if (!$ped){
			throw $this->createNotFoundException('Pedido no encontrado');
		}
		
		$proveedor = $ped->getProveedores();
		$producto = $ped->getProductos();
		
		$deleteForm = $this->createDeleteForm($ped);
		 
		return $this->render('EVOUserBundle:Pedidos:view.html.twig', array('ped' => $ped,'proveedor' => $proveedor,'producto' => $producto, 'delete_form' => $deleteForm->createView()));
		 
		 
	}
	
	
	
	public function editAction($id)
	{
		 
		$em = $this->getDoctrine()->getManager();
		$ped = $em->getRepository('EVOUserBundle:Pedidos')->find($id);
		 
		if (!$ped){
			throw $this->createNotFoundException('Pedido no encontrado');
		}
		 
		$form = $this->createEditForm($ped);
		 
		return $this->render('EVOUserBundle:Pedidos:edit.html.twig', array ('ped' => $ped, 'form' => $form->createView()));
		 
		 
	}
	
	
	private function createEditForm(Pedidos $entity)
	{
		 
		$form = $this->createForm(new PedidosType(), $entity, array('action' => $this->generateUrl('evo_pedidos_update', array ('id' => $entity->getId())), 'method' => 'PUT'));
		 
		return $form;
		 
	}
	
	
	public function updateAction($id, Request $request)
	{
	
		$em = $this->getDoctrine()->getManager();
		 
		$ped = $em->getRepository('EVOUserBundle:Pedidos')->find($id);
		if(!$ped)
		{
			$messageException = ('Pedido no encontrado');
			throw $this->createNotFoundException($messageException);
		}
		 
		$form = $this->createEditForm($ped);
		$form->handleRequest($request);
		 
		if($form->isSubmitted() && $form->isValid())
		{

			$em->flush();
			 
			$successMessage = ('El pedido ha sido modificado');
			$this->addFlash('mensaje', $successMessage);
			return $this->redirectToRoute('evo_pedidos_listadopedidos');
		}
		return $this->render('EVOUserBundle:Pedidos:edit.html.twig', array('ped' => $ped, 'form' => $form->createView()));
		 
	}
	
	
	
	private function createDeleteForm($pedidos)
	{
		 
		return $this->createFormBuilder()
		->setAction($this->generateUrl('evo_pedidos_delete', array('id' => $pedidos->getId())))
		->setMethod('DELETE')
		->getForm();
	}
	
	
	
	
	public function deleteAction(Request $request, $id)
	
	{
		$em = $this->getDoctrine()->getManager();
		 
		$ped = $em->getRepository('EVOUserBundle:Pedidos')->find($id);
		 
		if(!$ped)
		{
			$messageException = ('Pedido no encontrado');
			throw $this->createNotFoundException($messageException);
		}
		 
		
		 
		
		$form = $this->createCustomForm($ped->getId(), 'DELETE', 'evo_pedidos_delete');
		$form->handleRequest($request);
		 
		if($form->isSubmitted() && $form->isValid())
		{
			$em->remove($ped);
			$em->flush();
			$this->addFlash('mensaje', 'Pedido eliminado');
			return $this->redirectToRoute('evo_pedidos_listadopedidos');
		}
	
	}
	
	

	
	
	private function createCustomForm($id, $method, $route)
	{
		return $this->createFormBuilder()
		->setAction($this->generateUrl($route, array('id' => $id)))
		->setMethod($method)
		->getForm();
	}
	
	
	
	public function processAction($id, Request $request)
	{
		
		
		$em = $this->getDoctrine()->getManager();
	
		$ped = $em->getRepository('EVOUserBundle:Pedidos')->find($id);
	
		if(!$ped)
		{
			throw $this>createNotFoundException('Pedido no encontrado');
		}
	
		
		$form = $this->createCustomForm($ped->getId(), 'PUT', 'evo_pedidos_process');
		$form->handleRequest($request);
	
		
		
		if($form->isSubmitted() && $form->isValid())
		{
	
			$successMessage = 'El pedido ha sido procesado';
			$warningMessage = 'El pedido ya había sido procesado';
	
			if ($ped->getStatus() == 0)
			{
				$ped->setStatus(1);
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
