<?php

namespace EVO\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use EVO\UserBundle\Entity\Compras;
use EVO\UserBundle\Form\ComprasType;
use Symfony\Component\HttpFoundation\Request;

class ComprasController extends Controller
{

	
	
	
	
	public function historialAction(Request $request)
	{
	
		$idUser = $this->get('security.token_storage')->getToken()->getUser()->getId();
		
		$em = $this->getDoctrine()->getManager();
		$dql = "SELECT t FROM EVOUserBundle:Compras t JOIN t.user u WHERE u.id = :idUser ORDER BY t.id DESC";
		
		$comp = $em->createQuery($dql)->setParameter('idUser' , $idUser);
		
		$paginator = $this->get('knp_paginator');
		$pagination = $paginator->paginate(
				$comp,
				$request->query->getInt('page', 1),
				3
				);
		
	
	
		return $this->render('EVOUserBundle:Compras:historial.html.twig', array('pagination' => $pagination));
	}
	
	
	
	
	
	
	

	public function carritoAction()
	{
	
		
		
		return $this->render('EVOUserBundle:Compras:carrito.html.twig');
	}
    
   
	public function addAction()
	{
		$comp = new Compras();
		$form = $this ->createCreateForm($comp);
			
		return $this->render('EVOUserBundle:Compras:add.html.twig', array('form' => $form->createView()));
			
	}
	

	
	private function createCreateForm(Compras $entity)
	{
		$form = $this ->createForm(new ComprasType(), $entity, array (
				'action' => $this->generateUrl('evo_compras_create'),
				'method' => 'POST'
	
		));
			
		return $form;
			
	}
	
	
	
	public function createAction(Request $request)
	{
	
	
		$comp = new Compras();
		$form = $this->createCreateForm($comp);
		$form->handleRequest($request);
	
		if($form->isValid())
		{

			$em = $this->getDoctrine()->getManager();
			$em->persist($comp);
			$em->flush();
	
			$successMessage = ('La venta ha sido registrada');
			$this->addFlash('mensaje', $successMessage);
	
			return $this->redirectToRoute('evo_pedidos_listadopedidos');
		}
			
	
		return $this->render('EVOUserBundle:Compras:add.html.twig', array('form' => $form->createView()));
	}
	
	
	
	
	
	public function viewAction($id)
	{
			
		$repository = $this->getDoctrine()->getRepository('EVOUserBundle:Compras');
			
		$comp = $repository -> find($id);
			
		if (!$comp){
			throw $this->createNotFoundException('Venta no encontrada');
		}
	
		$user = $comp->getUser();
		$producto = $comp->getProductos();
	
		$deleteForm = $this->createDeleteForm($comp);
			
		return $this->render('EVOUserBundle:Compras:view.html.twig', array('comp' => $comp,'user' => $user,'producto' => $producto, 'delete_form' => $deleteForm->createView()));
			
			
	}
	
	
	
	
	
	public function editAction($id)
	{
			
		$em = $this->getDoctrine()->getManager();
		$comp = $em->getRepository('EVOUserBundle:Compras')->find($id);
			
		if (!$comp){
			throw $this->createNotFoundException('Pedido no encontrado');
		}
			
		$form = $this->createEditForm($comp);
			
		return $this->render('EVOUserBundle:Compras:edit.html.twig', array ('comp' => $comp, 'form' => $form->createView()));
			
			
	}
	
	
	private function createEditForm(Compras $entity)
	{
			
		$form = $this->createForm(new ComprasType(), $entity, array('action' => $this->generateUrl('evo_compras_update', array ('id' => $entity->getId())), 'method' => 'PUT'));
			
		return $form;
			
	}
	
	
	public function updateAction($id, Request $request)
	{
	
		$em = $this->getDoctrine()->getManager();
			
		$comp = $em->getRepository('EVOUserBundle:Compras')->find($id);
		
		if(!$comp)
		{
			$messageException = ('Venta no encontrada');
			throw $this->createNotFoundException($messageException);
		}
			
		$form = $this->createEditForm($comp);
		$form->handleRequest($request);
			
		if($form->isSubmitted() && $form->isValid())
		{
	
			$em->flush();
	
			$successMessage = ('La venta ha sido modificada');
			$this->addFlash('mensaje', $successMessage);
			return $this->redirectToRoute('evo_pedidos_listadopedidos');
		}
		return $this->render('EVOUserBundle:Compras:edit.html.twig', array('comp' => $comp, 'form' => $form->createView()));
			
	}
	
	
	
	private function createDeleteForm($compras)
	{
			
		return $this->createFormBuilder()
		->setAction($this->generateUrl('evo_compras_delete', array('id' => $compras->getId())))
		->setMethod('DELETE')
		->getForm();
	}
	
	
	
	
	public function deleteAction(Request $request, $id)
	
	{
		$em = $this->getDoctrine()->getManager();
			
		$comp = $em->getRepository('EVOUserBundle:Compras')->find($id);
			
		if(!$comp)
		{
			$messageException = ('Venta no encontrada');
			throw $this->createNotFoundException($messageException);
		}
			
	
			
	
		$form = $this->createCustomForm($comp->getId(), 'DELETE', 'evo_compras_delete');
		$form->handleRequest($request);
			
		if($form->isSubmitted() && $form->isValid())
		{
			$em->remove($comp);
			$em->flush();
			$this->addFlash('mensaje', 'Venta eliminada');
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
	
		$comp = $em->getRepository('EVOUserBundle:Compras')->find($id);
	
		if(!$comp)
		{
			throw $this>createNotFoundException('Venta no encontrada');
		}
	
	
		$form = $this->createCustomForm($comp->getId(), 'PUT', 'evo_compras_process');
		$form->handleRequest($request);
	
	
	
		if($form->isSubmitted() && $form->isValid())
		{
	
			$successMessage = 'La venta ha sido procesada';
			$warningMessage = 'La venta ya había sido procesada';
	
			if ($comp->getStatus() == 0)
			{
				$comp->setStatus(1);
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
	
