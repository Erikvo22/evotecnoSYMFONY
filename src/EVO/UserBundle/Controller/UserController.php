<?php

namespace EVO\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use EVO\UserBundle\Entity\User;
use EVO\UserBundle\Form\UserType;
use EVO\UserBundle\Form\UserTypeC;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\FormError;

class UserController extends Controller
{
	
	
	public function myworkAction(Request $request)
	{
		
		return $this->render('EVOUserBundle:User:mywork.html.twig');
	}
	

	
	public function homeAction()
	{
		return $this->render('EVOUserBundle:User:home.html.twig');
	}
	
	
	public function indexAction(Request $request)
	{
		
		$em = $this->getDoctrine()->getManager();
		$dql = "SELECT p FROM EVOUserBundle:Productos p ORDER BY p.id DESC";
		$prod = $em->createQuery($dql);
		
		$paginator = $this->get('knp_paginator');
		$pagination = $paginator->paginate(
					
				$prod,
				$request->query->getInt('page', 1),
				6
		
				);

	
		return $this->render('EVOUserBundle:User:index.html.twig', array('pagination' => $pagination));
		
		
	}
	
	
	public function contactoAction()
	{
	
	
		return $this->render('EVOUserBundle:User:contacto.html.twig');
	}
	
	
	
	
	

	public function serviciosAction()
	{
	
	
		return $this->render('EVOUserBundle:User:servicios.html.twig');
	}
	
	
	
	public function registroAction()
	{
		$clientes = new User();
		$form = $this ->createCCreateForm($clientes);
		
		return $this->render('EVOUserBundle:User:registro.html.twig', array('form' => $form->createView()));
	}
	
	
	private function createCCreateForm(User $entity)
	{
		$form = $this ->createForm(new UserType(), $entity, array (
				'action' => $this->generateUrl('evo_user_createC'),
				'method' => 'POST'
    
		));
		 
		return $form;
		 
	}
	
	
	
	public function createCAction(Request $request)
	{
	
	
		$clientes = new User();
		$form = $this->createCCreateForm($clientes);
		$form->handleRequest($request);
	
		if($form->isValid())
		{
			$password = $form->get('password')->getData();
	
			$passwordConstraint = new Assert\NotBlank();
			$errorList = $this->get('validator')->validate($password, $passwordConstraint);
	
			if(count($errorList) == 0)
			{
				$encoder = $this->container->get('security.password_encoder');
				$encoded = $encoder->encodePassword($clientes, $password);
	
				$clientes->setPassword($encoded);
	
				$em = $this->getDoctrine()->getManager();
				$em->persist($clientes);
				$em->flush();
	
				$successMessage = ('El usuario ha sido creado');
				$this->addFlash('mensaje', $successMessage);
	
				return $this->redirectToRoute('evo_user_login');
			}
			else
			{
				$errorMessage = new FormError($errorList[0]->getMessage());
				$form->get('password')->addError($errorMessage);
			}
		}
	
		return $this->render('EVOUserBundle:User:registro.html.twig', array('form' => $form->createView()));
	}
	 
	
	
	
	public function editCAction($id)
	{
		 
		$em = $this->getDoctrine()->getManager();
		$clientes = $em->getRepository('EVOUserBundle:User')->find($id);
		 
		if (!$clientes){
			throw $this->createNotFoundException('Usuario no encontrado');
		}
		 
		$form = $this->createEditFormC($clientes);
		 
		return $this->render('EVOUserBundle:User:editC.html.twig', array ('clientes' => $clientes, 'form' => $form->createView()));
		 
		 
	}
	
	
	
	private function createEditFormC(User $entity)
	{
		 
		$form = $this->createForm(new UserTypeC(), $entity, array('action' => $this->generateUrl('evo_user_updateC', array ('id' => $entity->getId())), 'method' => 'PUT'));
		 
		return $form;
		 
	}
	
	
	
	
	
	public function updateCAction($id, Request $request)
	{
	
		$em = $this->getDoctrine()->getManager();
		 
		$clientes = $em->getRepository('EVOUserBundle:User')->find($id);
		if(!$clientes)
		{
			$messageException = ('Usuario no encontrado');
			throw $this->createNotFoundException($messageException);
		}
		 
		$form = $this->createEditFormC($clientes);
		$form->handleRequest($request);
		 
		if($form->isSubmitted() && $form->isValid())
		{
			$password = $form->get('password')->getData();
			if(!empty($password))
			{
				$encoder = $this->container->get('security.password_encoder');
				$encoded = $encoder->encodePassword($clientes, $password);
				$clientes->setPassword($encoded);
			}
			else
			{
				$recoverPass = $this->recoverPass($id);
				$clientes->setPassword($recoverPass[0]['password']);
			}
			 
	
			$em->flush();
			 
			$successMessage = ('El usuario ha sido modificado');
			$this->addFlash('mensaje', $successMessage);
			return $this->redirectToRoute('evo_user_miespacio');
		}
		return $this->render('EVOUserBundle:User:registro.html.twig', array('clientes' => $clientes, 'form' => $form->createView()));
		 
	}
	
	
	
	public function productosAction(Request $request)
	{
		
			$em = $this->getDoctrine()->getManager();
			$dql = "SELECT p FROM EVOUserBundle:Productos p ORDER BY p.id DESC";
			$prod = $em->createQuery($dql);
			
			$paginator = $this->get('knp_paginator');
			$pagination = $paginator->paginate(
						
					$prod,
					$request->query->getInt('page', 1),
					12
			
					);
			return $this->render('EVOUserBundle:User:productos.html.twig', array('pagination' => $pagination));
		
		
	}
	
	
	
	public function miespacioAction(Request $request)
	{
		
		$idUser = $this->get('security.token_storage')->getToken()->getUser()->getId();
		
		$em = $this->getDoctrine()->getManager();
		$dql = "SELECT u FROM EVOUserBundle:User u WHERE u.id = :idUser ORDER BY u.id DESC";
		
		$edit = $em->createQuery($dql)->setParameter('idUser' , $idUser);
		
		$paginator = $this->get('knp_paginator');
		$pagination = $paginator->paginate(
				$edit,
				$request->query->getInt('page', 1),
				3
				);
		
		return $this->render('EVOUserBundle:User:miespacio.html.twig', array('pagination' => $pagination));
		
		
	}
	
	
	
    public function listadoAction(Request $request)
    {
     
    	
    	$em = $this->getDoctrine()->getManager();
    	$dql = "SELECT u FROM EVOUserBundle:User u ORDER BY u.id DESC";
    	$users = $em->createQuery($dql);
        
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
        		$users, $request->query->getInt('page', 1),
        		10
        		);
        
        $deleteFormAjax = $this->createCustomForm(':USER_ID', 'DELETE', 'evo_user_delete');
        
        return $this->render('EVOUserBundle:User:Listadousuarios.html.twig', array('pagination' => $pagination, 'delete_form_ajax' => $deleteFormAjax->createView()));
    }
    
    
    
    
    public function addAction()
    {
    	$user = new User();
    	$form = $this ->createCreateForm($user);
    	
    	return $this->render('EVOUserBundle:User:add.html.twig', array('form' => $form->createView()));
    	
    }
    
    
    
    
    
    
    private function createCreateForm(User $entity)
    {
    	$form = $this ->createForm(new UserType(), $entity, array (
    			'action' => $this->generateUrl('evo_user_create'),
    			'method' => 'POST'
    			
    	));
    	
    	return $form;
    	
    }
    
 
    
   public function createAction(Request $request)
   {
   	
   	
   	$user = new User();
   	$form = $this->createCreateForm($user);
   	$form->handleRequest($request);
   	
   	if($form->isValid())
   	{
   		$password = $form->get('password')->getData();
   	
   		$passwordConstraint = new Assert\NotBlank();
   		$errorList = $this->get('validator')->validate($password, $passwordConstraint);
   	
   		if(count($errorList) == 0)
   		{
   			$encoder = $this->container->get('security.password_encoder');
   			$encoded = $encoder->encodePassword($user, $password);
   	
   			$user->setPassword($encoded);
   	
   			$em = $this->getDoctrine()->getManager();
   			$em->persist($user);
   			$em->flush();
   	
   			$successMessage = ('El usuario ha sido creado');
   			$this->addFlash('mensaje', $successMessage);
   	
   			return $this->redirectToRoute('evo_user_listado');
   		}
   		else
   		{
   			$errorMessage = new FormError($errorList[0]->getMessage());
   			$form->get('password')->addError($errorMessage);
   		}
   	}
   	
   	return $this->render('EVOUserBundle:User:add.html.twig', array('form' => $form->createView()));
   	}
   
   
   	
  
   	
    public function viewAction($id)
    {
    	
    	$repository = $this->getDoctrine()->getRepository('EVOUserBundle:User');
    	
    	$user = $repository -> find($id);
    	
    	if (!$user){
    		throw $this->createNotFoundException('Usuario no encontrado');
    	}
    	
    	$deleteForm = $this->createDeleteForm($user);
    	
    	return $this->render('EVOUserBundle:User:view.html.twig', array('user' => $user, 'delete_form' => $deleteForm->createView()));
    	
    	
    }
    
    
    
    public function editAction($id)
    {
    	
    	$em = $this->getDoctrine()->getManager();
    	$user = $em->getRepository('EVOUserBundle:User')->find($id);
    	
    	if (!$user){
    		throw $this->createNotFoundException('Usuario no encontrado');
    	}
    	
    	$form = $this->createEditForm($user);
    	
    	return $this->render('EVOUserBundle:User:edit.html.twig', array ('user' => $user, 'form' => $form->createView()));
   
    	
    }
    
    
    
    
    private function createEditForm(User $entity)
    {	
    	
    	$form = $this->createForm(new UserType(), $entity, array('action' => $this->generateUrl('evo_user_update', array ('id' => $entity->getId())), 'method' => 'PUT'));
    	
    	return $form;
    	
    }
    
    
    public function updateAction($id, Request $request)
    {
    	 
    	$em = $this->getDoctrine()->getManager();
    	
    	$user = $em->getRepository('EVOUserBundle:User')->find($id);
    	if(!$user)
    	{
    		$messageException = ('Usuario no encontrado');
    		throw $this->createNotFoundException($messageException);
    	}
    	
    	$form = $this->createEditForm($user);
    	$form->handleRequest($request);
    	
    	if($form->isSubmitted() && $form->isValid())
    	{
    		$password = $form->get('password')->getData();
    		if(!empty($password))
    		{
    			$encoder = $this->container->get('security.password_encoder');
    			$encoded = $encoder->encodePassword($user, $password);
    			$user->setPassword($encoded);
    		}
    		else
    		{
    			$recoverPass = $this->recoverPass($id);
    			$user->setPassword($recoverPass[0]['password']);
    		}
    	
    		if($form->get('role')->getData() == 'ROLE_ADMIN')
    		{
    			$user->setIsActive(1);
    		}
    		$em->flush();
    	
    		$successMessage = ('El usuario ha sido modificado');
    		$this->addFlash('mensaje', $successMessage);
    		return $this->redirectToRoute('evo_user_listado');
    	}
    	return $this->render('EVOUserBundle:User:edit.html.twig', array('user' => $user, 'form' => $form->createView()));
    	
    }
    
    
    
   
    
   
    
    private function recoverPass($id)
    {
    	$em = $this->getDoctrine()->getManager();
    	$query = $em->createQuery(
    			'SELECT u.password
    			FROM EVOUserBundle:User u
    			WHERE u.id = :id'
    			)->setParameter('id', $id);
    	
    	$currentPass = $query->getResult();
    	return $currentPass;		
    }
    
    
    
    
    private function createDeleteForm($user)
    {
    	
    	return $this->createFormBuilder()
    			->setAction($this->generateUrl('evo_user_delete', array('id' => $user->getId())))
    			->setMethod('DELETE')
    			->getForm();
    }
    
    
    
    
    public function deleteAction(Request $request, $id)
    
    {
    	$em = $this->getDoctrine()->getManager();
    	
    	$user = $em->getRepository('EVOUserBundle:User')->find($id);
    	
    	if(!$user)
    	{
    		$messageException = ('Usuario no encontrado');
    		throw $this->createNotFoundException($messageException);
    	}
    	
    	$allUsers = $em->getRepository('EVOUserBundle:User')->findAll();
    	$countUsers = count($allUsers);
    	
    	// $form = $this->createDeleteForm($user);
    	$form = $this->createCustomForm($user->getId(), 'DELETE', 'evo_user_delete');
    	$form->handleRequest($request);
    	
    	if($form->isSubmitted() && $form->isValid())
    	{
    		if($request->isXMLHttpRequest())
    		{
    			$res = $this->deleteUser($user->getRole(), $em, $user);
    	
    			return new Response(
    					json_encode(array('removed' => $res['removed'], 'message' => $res['message'], 'countUsers' => $countUsers)),
    					200,
    					array('Content-Type' => 'application/json')
    					);
    		}
    	
    		$res = $this->deleteUser($user->getRole(), $em, $user);
    		$this->addFlash($res['alert'], $res['message']);
    		return $this->redirectToRoute('evo_user_listado');
    	}

    }
    
    
    
    
    
    private function deleteUser($role, $em, $user)
    {
    	
    	if($role == 'ROLE_USER')
    	{
    		$em->remove($user);
    		$em->flush();
    	
    		$message = ('El usuario ha sido eliminado');
    		$removed = 1;
    		$alert = 'mensaje';
    	}
    	
    	
    	if($role == 'ROLE_EMPLEADO')
    	{
    		$em->remove($user);
    		$em->flush();
    		 
    		$message = ('El usuario ha sido eliminado');
    		$removed = 1;
    		$alert = 'mensaje';
    	}
    	
    	
    	elseif($role == 'ROLE_ADMIN')
    	{
    		$message = ('El admin no puede ser eliminado');
    		$removed = 0;
    		$alert = 'error';
    	}
    	
    	return array('removed' => $removed, 'message' => $message, 'alert' => $alert);
   
    	
   
    }    
    
    
    private function createCustomForm($id, $method, $route)
    {
    	return $this->createFormBuilder()
    	->setAction($this->generateUrl($route, array('id' => $id)))
    	->setMethod($method)
    	->getForm();
    }
    
    
    
    
    /* CATEGORIAS DE LOS PRODUCTOS */
    
    
    public function productosmovilesAction(Request $request)
    {
    
    	$em = $this->getDoctrine()->getManager();
    	$dql = "SELECT p FROM EVOUserBundle:Productos p WHERE p.tipo = 'Moviles y SmarthPhone'";
    	$prod = $em->createQuery($dql);
    
    	$paginator = $this->get('knp_paginator');
    	$pagination = $paginator->paginate(
    				
    			$prod,
    			$request->query->getInt('page', 1),
    			9
    
    			);
    	return $this->render('EVOUserBundle:User:productos.html.twig', array('pagination' => $pagination));
    }
    
    
    
    public function productosinformaticaAction(Request $request)
    {
    
    	$em = $this->getDoctrine()->getManager();
    	$dql = "SELECT p FROM EVOUserBundle:Productos p WHERE p.tipo = 'Informatica'";
    	$prod = $em->createQuery($dql);
    
    	$paginator = $this->get('knp_paginator');
    	$pagination = $paginator->paginate(
    
    			$prod,
    			$request->query->getInt('page', 1),
    			9
    
    			);
    	return $this->render('EVOUserBundle:User:productos.html.twig', array('pagination' => $pagination));
    }
    
    
    
    public function productosgelectroAction(Request $request)
    {
    
    	$em = $this->getDoctrine()->getManager();
    	$dql = "SELECT p FROM EVOUserBundle:Productos p WHERE p.tipo = 'Grandes electrodomesticos'";
    	$prod = $em->createQuery($dql);
    
    	$paginator = $this->get('knp_paginator');
    	$pagination = $paginator->paginate(
    
    			$prod,
    			$request->query->getInt('page', 1),
    			9
    
    			);
    	return $this->render('EVOUserBundle:User:productos.html.twig', array('pagination' => $pagination));
    }
    
    
    public function productospelectroAction(Request $request)
    {
    
    	$em = $this->getDoctrine()->getManager();
    	$dql = "SELECT p FROM EVOUserBundle:Productos p WHERE p.tipo = 'Pequenos electrodomesticos'";
    	$prod = $em->createQuery($dql);
    
    	$paginator = $this->get('knp_paginator');
    	$pagination = $paginator->paginate(
    
    			$prod,
    			$request->query->getInt('page', 1),
    			9
    
    			);
    	return $this->render('EVOUserBundle:User:productos.html.twig', array('pagination' => $pagination));
    }
    
    
    
    public function productostvAction(Request $request)
    {
    
    	$em = $this->getDoctrine()->getManager();
    	$dql = "SELECT p FROM EVOUserBundle:Productos p WHERE p.tipo = 'TV'";
    	$prod = $em->createQuery($dql);
    
    	$paginator = $this->get('knp_paginator');
    	$pagination = $paginator->paginate(
    
    			$prod,
    			$request->query->getInt('page', 1),
    			9
    
    			);
    	return $this->render('EVOUserBundle:User:productos.html.twig', array('pagination' => $pagination));
    }
    
    
    
    public function productossonidoAction(Request $request)
    {
    
    	$em = $this->getDoctrine()->getManager();
    	$dql = "SELECT p FROM EVOUserBundle:Productos p WHERE p.tipo = 'Sonido'";
    	$prod = $em->createQuery($dql);
    
    	$paginator = $this->get('knp_paginator');
    	$pagination = $paginator->paginate(
    
    			$prod,
    			$request->query->getInt('page', 1),
    			9
    
    			);
    	return $this->render('EVOUserBundle:User:productos.html.twig', array('pagination' => $pagination));
    }
    
    
    
    public function productosfotografiaAction(Request $request)
    {
    
    	$em = $this->getDoctrine()->getManager();
    	$dql = "SELECT p FROM EVOUserBundle:Productos p WHERE p.tipo = 'Fotografia y video'";
    	$prod = $em->createQuery($dql);
    
    	$paginator = $this->get('knp_paginator');
    	$pagination = $paginator->paginate(
    
    			$prod,
    			$request->query->getInt('page', 1),
    			9
    
    			);
    	return $this->render('EVOUserBundle:User:productos.html.twig', array('pagination' => $pagination));
    }
    
    
    public function productoselectrodepAction(Request $request)
    {
    
    	$em = $this->getDoctrine()->getManager();
    	$dql = "SELECT p FROM EVOUserBundle:Productos p WHERE p.tipo = 'Electronica deportiva y drone'";
    	$prod = $em->createQuery($dql);
    
    	$paginator = $this->get('knp_paginator');
    	$pagination = $paginator->paginate(
    
    			$prod,
    			$request->query->getInt('page', 1),
    			9
    
    			);
    	return $this->render('EVOUserBundle:User:productos.html.twig', array('pagination' => $pagination));
    }
    
    
    
    public function productosconsolaAction(Request $request)
    {
    
    	$em = $this->getDoctrine()->getManager();
    	$dql = "SELECT p FROM EVOUserBundle:Productos p WHERE p.tipo = 'Consolas y juegos'";
    	$prod = $em->createQuery($dql);
    
    	$paginator = $this->get('knp_paginator');
    	$pagination = $paginator->paginate(
    
    			$prod,
    			$request->query->getInt('page', 1),
    			9
    
    			);
    	return $this->render('EVOUserBundle:User:productos.html.twig', array('pagination' => $pagination));
    }
    
    
    
    
  /* BUSQUEDA */  
    
    public function productosbusquedaAction(Request $request)
    {
    
    	$busqueda = trim($_POST['buscar']);
    	
    	$em = $this->getDoctrine()->getManager();
    	$dql = "SELECT p FROM EVOUserBundle:Productos p WHERE p.nombre LIKE '%" .$busqueda. "%' ORDER BY p.nombre";
    	$prod = $em->createQuery($dql);
    
    	$paginator = $this->get('knp_paginator');
    	$pagination = $paginator->paginate(
    
    			$prod,
    			$request->query->getInt('page', 1),
    			9
    
    			);
    	return $this->render('EVOUserBundle:User:productos.html.twig', array('pagination' => $pagination));
    }
    
    
    
    
    public function productospreciomenorAction(Request $request)
    {
    	 
    	$em = $this->getDoctrine()->getManager();
    	$dql = "SELECT p FROM EVOUserBundle:Productos p ORDER BY p.preciov ASC";
    	$prod = $em->createQuery($dql);
    
    	$paginator = $this->get('knp_paginator');
    	$pagination = $paginator->paginate(
    
    			$prod,
    			$request->query->getInt('page', 1),
    			9
    
    			);
    	return $this->render('EVOUserBundle:User:productos.html.twig', array('pagination' => $pagination));
    }
    
    
    
    
    public function productospreciomayorAction(Request $request)
    {
    
    	$em = $this->getDoctrine()->getManager();
    	$dql = "SELECT p FROM EVOUserBundle:Productos p ORDER BY p.preciov DESC";
    	$prod = $em->createQuery($dql);
    
    	$paginator = $this->get('knp_paginator');
    	$pagination = $paginator->paginate(
    
    			$prod,
    			$request->query->getInt('page', 1),
    			9
    
    			);
    	return $this->render('EVOUserBundle:User:productos.html.twig', array('pagination' => $pagination));
    }
   
}
