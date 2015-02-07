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
        $formAction = $this->get('oro_entity.routing_helper')
            ->generateUrlByRequest('dusan_simple_create', $this->getRequest());
        $entity = new SimpleCrud();
        return $this->update($entity, $formAction);
    }

    /**
     * @Route("/update/{id}", name="dusan_simple_update", requirements={"id"="\d+"})
     * @Template
     */
    public function updateAction(SimpleCrud $entity)
    {
        $formAction = $this->get('router')->generate('dusan_simple_update', ['id' => $entity->getId()]);

        return $this->update($entity, $formAction);
    }

    /**
     * @param SimpleCrud   $entity
     * @param string $formAction
     *
     * @return array
     */
    protected function update(SimpleCrud $entity, $formAction)
    {
        $saved = false; 

        if ($this->get('dusan_simple.form.handler')->process($entity)) {
            if (!$this->getRequest()->get('_widgetContainer')) {
                $this->get('session')->getFlashBag()->add(
                    'success',
                    $this->get('translator')->trans('dusan_simple.simple_crud.controller.saved.message')
                );

                return $this->get('oro_ui.router')->redirectAfterSave(
                    ['route' => 'dusan_simple_update', 'parameters' => ['id' => $entity->getId()]],
                    ['route' => 'dusan_simple_index'],
                    $entity
                );
            }
            $saved = true;
        }
        
        return array(
            'entity'     => $entity,
            'saved'      => $saved,
            'form'       => $this->get('dusan_simple.form.handler')->getForm()->createView(),
            'formAction' => $formAction
        );
    }

    /**
     * @Route("/delete/{id}", name="dusan_simple_delete", requirements={"id"="\d+"})
     * @Template
     */
    public function deleteAction($id)
    {
        $manager = $this->getDoctrine()->getManager();
        $entity = $manager->find('Dusan\Bundle\SimpleBundle\Entity\SimpleCrud', $id);

        if (!$entity) {
            $this->get('session')->getFlashBag()->add(
                'error',
                $this->get('translator')->trans('dusan_simple.simple_crud.controller.notfound.message')
            );
            return $this->redirect($this->generateUrl('dusan_simple_index'));
        }

        $manager->remove($entity);
        $manager->flush();

        $this->get('session')->getFlashBag()->add(
            'success',
            $this->get('translator')->trans('dusan_simple.simple_crud.controller.deleted.message')
        );

        return $this->redirect($this->generateUrl('dusan_simple_index'));
    }
}
