<?php

namespace Ignitho\ApiBundle\Handler;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\Mapping\Entity;
use Ignitho\ApiBundle\Entity\ApiEntityInterface;
use Ignitho\ApiBundle\Exception\InvalidFormException;
use Ignitho\ApiBundle\Form\ApiFormInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\FormFactoryInterface;

class ApiHandler extends Controller implements ApiHandlerInterface
{
    /**
     * @var ObjectManager
     */
    private $om;

    /**
     * @var FormFactoryInterface
     */
    private $formFactory;

    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @var \Doctrine\Common\Persistence\ObjectRepository
     */
    private $repository;

    /**
     * @var Entity
     */
    private $entityClass;

    /**
     * @var EntityType
     */
    private $entityTypeClass;

    public function __construct(
        ObjectManager $om,
        $entityClass,
        $entityTypeClass,
        FormFactoryInterface $formFactory,
        ContainerInterface $container
    )
    {
        $this->om =$om;
        $this->entityClass = $entityClass;
        $this->entityTypeClass = $entityTypeClass;
        $this->formFactory = $formFactory;
        $this->repository = $this->om->getRepository($this->entityClass);
        $this->container = $container;
    }

    /**
     * {@inheritdoc}
     */
    public function all()
    {
        return $this->repository->findAll();
    }

    /**
     * {@inheritdoc}
     */
    public function get($id)
    {
        return $this->repository->find($id);
    }

    /**
     * {@inheritdoc}
     */
    public function post(array $parameters)
    {
        $entity = $this->createEntity();
        $entityType = $this->createEntityType();

        return $this->processForm($entity, $entityType, $parameters, 'POST');
    }

    /**
     * Process an entity
     *
     * @param ApiEntityInterface $apiEntityInterface
     * @param ApiEntityInterface $entityType
     * @param array $parameters
     * @param string $method
     *
     * @return Entity $entity
     *
     * @throws InvalidFormException
     */
    private function processForm(ApiEntityInterface $apiEntityInterface, ApiFormInterface $entityType, array $parameters, $method = "PUT")
    {
        $form = $this->formFactory->create($this->entityTypeClass, $apiEntityInterface, array('method' => $method));

        $form->submit($parameters, 'PATCH' !== $method);

        if ($form->isValid()) {
            $entity = $form->getData();
            $this->om->persist($entity);
            $this->om->flush($entity);

            return $entity;
        }

        throw new InvalidFormException('Invalid submitted data', $form);
    }

    public function delete($entity)
    {
//        $this->om->remove($entity);
//        $this->om->flush();
    }

    /**
     * Creates an entity class
     *
     * @return mixed
     */
    private function createEntity()
    {
        return new $this->entityClass();
    }

    /**
     * Creates an entity type class
     *
     * @return mixed
     */
    private function createEntityType()
    {
        return new $this->entityTypeClass();
    }
}