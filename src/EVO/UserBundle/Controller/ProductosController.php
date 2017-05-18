<?php

namespace EVO\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use EVO\UserBundle\Entity\Productos;
use EVO\UserBundle\Form\ProductosType;
use EVO\UserBundle\Form\ProductosType2;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;



class ProductosController extends Controller
{
	
	
	public function listadoproductosAction(Request $request)
	{
		 
		 
		$em = $this->getDoctrine()->getManager();
		$dql = "SELECT u FROM EVOUserBundle:Productos u ORDER BY u.id DESC";
		$productos = $em->createQuery($dql);
	
		$paginator = $this->get('knp_paginator');
		$pagination = $paginator->paginate(
				$productos, $request->query->getInt('page', 1),
				6
				);
	
		$deleteFormAjax = $this->createCustomForm(':PRODUCTOS_ID', 'DELETE', 'evo_productos_delete');
	
		return $this->render('EVOUserBundle:Productos:listadoproductos.html.twig', array('pagination' => $pagination, 'delete_form_ajax' => $deleteFormAjax->createView()));
	}
	
	
	
	
	public function addAction()
	{
		$prod = new Productos();
		$form = $this ->createCreateForm($prod);
		 
		return $this->render('EVOUserBundle:Productos:add.html.twig', array('form' => $form->createView()));
		 
	}
	
	
	
	
	
	
	private function createCreateForm(Productos $entity)
	{
		$form = $this ->createForm(new ProductosType(), $entity, array (
				'action' => $this->generateUrl('evo_productos_create'),
				'method' => 'POST'
    
		));
		 
		return $form;
		 
	}
	
	
	
	public function createAction(Request $request)
	{
	
	
		$prod = new Productos();
		$form = $this->createCreateForm($prod);
		$form->handleRequest($request);
	
		if($form->isValid())
		{
			
				$file = $prod->getImg();
				
				$fileName = md5(uniqid()). '.' .$file->guessExtension();
				
				$imgDir = $this->container->getParameter('kernel.root_dir').'/../web/img/productos';
				$file->move($imgDir, $fileName);
				
				$prod->setImg($fileName);
				
			
				$em = $this->getDoctrine()->getManager();
				$em->persist($prod);
				$em->flush();
	
				$successMessage = ('El producto ha sido creado');
				$this->addFlash('mensaje', $successMessage);
	
				return $this->redirectToRoute('evo_productos_listadoproductos');
			}
			
	
		return $this->render('EVOUserBundle:Productos:add.html.twig', array('form' => $form->createView()));
	}
	 
	 
	
	
	
	public function viewAction($id)
	{
		 
		$repository = $this->getDoctrine()->getRepository('EVOUserBundle:Productos');
		 
		$prod = $repository -> find($id);
		 
		if (!$prod){
			throw $this->createNotFoundException('Producto no encontrado');
		}
		
		$proveedor = $prod->getProveedores();
		
		$deleteForm = $this->createDeleteForm($prod);
		 
		return $this->render('EVOUserBundle:Productos:view.html.twig', array('prod' => $prod,'proveedor'=>$proveedor, 'delete_form' => $deleteForm->createView()));
		 
		 
	}
	
	
	
	public function editAction($id)
	{
		 
		$em = $this->getDoctrine()->getManager();
		$prod = $em->getRepository('EVOUserBundle:Productos')->find($id);
		 
		if (!$prod){
			throw $this->createNotFoundException('Producto no encontrado');
		}
		 
		$form = $this->createEditForm($prod);
		 
		return $this->render('EVOUserBundle:Productos:edit.html.twig', array ('prod' => $prod, 'form' => $form->createView()));
		 
		 
	}
	
	
	private function createEditForm(Productos $entity)
	{
		 
		$form = $this->createForm(new ProductosType2(), $entity, array(
				'action' => $this->generateUrl('evo_productos_update', array ('id' => $entity->getId())), 
				'method' => 'PUT'));
		 
		return $form;
		 
	}
	
	
	public function updateAction($id, Request $request)
	{
	
		$em = $this->getDoctrine()->getManager();
		 
		$prod = $em->getRepository('EVOUserBundle:Productos')->find($id);
		if(!$prod)
		{
			$messageException = ('Producto no encontrado');
			throw $this->createNotFoundException($messageException);
		}
		 
		$form = $this->createEditForm($prod);
		$form->handleRequest($request);
		 
		if($form->isSubmitted() && $form->isValid())
		{

			$em->flush();
			 
			$successMessage = ('El producto ha sido modificado');
			$this->addFlash('mensaje', $successMessage);
			return $this->redirectToRoute('evo_productos_listadoproductos');
		}
		return $this->render('EVOUserBundle:Productos:edit.html.twig', array('prod' => $prod, 'form' => $form->createView()));
		 
	}
	
	
	
	private function createDeleteForm($prod)
	{
		 
		return $this->createFormBuilder()
		->setAction($this->generateUrl('evo_productos_delete', array('id' => $prod->getId())))
		->setMethod('DELETE')
		->getForm();
	}
	
	
	
	
	public function deleteAction(Request $request, $id)
	
	{
		$em = $this->getDoctrine()->getManager();
		 
		$prod = $em->getRepository('EVOUserBundle:Productos')->find($id);
		 
		if(!$prod)
		{
			$messageException = ('Producto no encontrado');
			throw $this->createNotFoundException($messageException);
		}

		$form = $this->createCustomForm($prod->getId(), 'DELETE', 'evo_productos_delete');
		$form->handleRequest($request);
		
		if($form->isSubmitted() && $form->isValid())
		{
 
			$em->remove($prod);
			$em->flush();
		
			$this->addFlash('mensaje', 'Producto eliminado');
			return $this->redirectToRoute('evo_productos_listadoproductos');
		}
	
	}
	
	

	
	
	private function createCustomForm($id, $method, $route)
	{
		return $this->createFormBuilder()
		->setAction($this->generateUrl($route, array('id' => $id)))
		->setMethod($method)
		->getForm();
	}
	
	
	
	
	
	public function prodAction($id)
	{
			
		$repository = $this->getDoctrine()->getRepository('EVOUserBundle:Productos');
			
		$prod = $repository -> find($id);
			
		if (!$prod){
			throw $this->createNotFoundException('Producto no encontrado');
		}
		
		
			
		return $this->render('EVOUserBundle:Productos:prod.html.twig', array('prod' => $prod));

			
			
	}
	
   
}
