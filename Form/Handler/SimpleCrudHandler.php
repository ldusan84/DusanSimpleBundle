<?php

namespace Dusan\Bundle\SimpleBundle\Form\Handler;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\Request;

use Doctrine\Common\Persistence\ObjectManager;

use Oro\Bundle\EntityBundle\Tools\EntityRoutingHelper;

use Dusan\Bundle\SimpleBundle\Entity\SimpleCrud;

class SimpleCrudHandler
{
    /** @var FormInterface */
    protected $form;

    /** @var string */
    protected $formName;

    /** @var string */
    protected $formType;

    /** @var Request */
    protected $request;

    /** @var ObjectManager */
    protected $manager;

    /** @var EntityRoutingHelper */
    protected $entityRoutingHelper;

    /** @var FormFactory */
    protected $formFactory;

    /**
     * @param string                 $formName
     * @param string                 $formType
     * @param Request                $request
     * @param ObjectManager          $manager
     * @param EntityRoutingHelper    $entityRoutingHelper
     * @param FormFactory            $formFactory
     */
    public function __construct(
        $formName,
        $formType,
        Request $request,
        ObjectManager $manager,
        EntityRoutingHelper $entityRoutingHelper,
        FormFactory $formFactory
    ) {
        $this->formName            = $formName;
        $this->formType            = $formType;
        $this->request             = $request;
        $this->manager             = $manager;
        $this->entityRoutingHelper = $entityRoutingHelper;
        $this->formFactory         = $formFactory;
    }

    /**
     * Process form
     *
     * @param  SimpleCrud $entity
     *
     * @return bool  True on successful processing, false otherwise
     */
    public function process(SimpleCrud $entity)
    {
        $options = [];
        
        $this->form = $this->formFactory->createNamed($this->formName, $this->formType, $entity, $options);
        $this->form->setData($entity);

        if (in_array($this->request->getMethod(), array('POST', 'PUT'))) {
            $this->form->submit($this->request);

            if ($this->form->isValid()) {
                $this->onSuccess($entity);
                return true;
            }
        }

        return false;
    }

    /**
     * "Success" form handler
     *
     * @param SimpleCrud $entity
     */
    protected function onSuccess(SimpleCrud $entity)
    {
        $this->manager->persist($entity);
        $this->manager->flush();
    }

    /**
     * Get form, that build into handler, via handler service
     *
     * @return FormInterface
     */
    public function getForm()
    {
        return $this->form;
    }
}
