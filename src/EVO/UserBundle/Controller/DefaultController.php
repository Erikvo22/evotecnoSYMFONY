<?php

namespace EVO\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('EVOUserBundle:Default:index.html.twig');
    }
}
