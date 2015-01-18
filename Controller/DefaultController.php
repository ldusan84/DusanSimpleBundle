<?php

namespace Dusan\Bundle\SimpleBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Dusan\Bundle\SimpleBundle\Entity\SimpleCrud;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller

{

    /**
    * @Route("/index", name="dusan_simple_index")
    * @Template
    */

    public function indexAction()
    {
       return array();
    }
    
    /**
     * @Route("/create", name="dusan_simple_create")
     * @Template("DusanSimpleBundle:Default:update.html.twig")
     */
    public function createAction()
    {

    }

    /**
     * @Route("/update/{id}", name="dusan_simple_update", requirements={"id"="\d+"})
     * @Template
     */
    public function updateAction(SimpleCrud $entity)
    {

    }

    /**
     * @Route("/delete/{id}", name="dusan_simple_delete", requirements={"id"="\d+"})
     * @Template
     */
    public function deleteAction($id)
    {

    }
}
