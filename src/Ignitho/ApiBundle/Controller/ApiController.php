<?php

namespace Ignitho\ApiBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use Ignitho\AdminBundle\Form\PageType;
use Ignitho\ApiBundle\Exception\InvalidFormException;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Request\ParamFetcherInterface;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations\Delete;
use FOS\RestBundle\Controller\Annotations\Get;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ApiController extends FOSRestController
{

    /**
     * List all entities based on service handle
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes = {
     *     200 = "Returned when successful"
     *   }
     * )
     * @QueryParam(name="handle", nullable=false, description="Service Handle")
     *
     * @param ParamFetcherInterface $paramFetcher Param fetcher service
     *
     * @return array
     */
    public function getListAction(ParamFetcherInterface $paramFetcher)
    {
        return $this->get($this->getServiceHandle($paramFetcher->get('handle')))->all();
    }

    /**
     * Get entity based on handle and id
     *
     * @ApiDoc(
     *   resource = true,
     *   description = "Gets an Entity for a given id",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when the entity is not found"
     *   }
     * )
     *
     * @QueryParam(name="handle", nullable=false, description="Service Handle")
     * @QueryParam(name="id", requirements="\d+", description="The entity primary key")
     *
     * @param ParamFetcherInterface $paramFetcher Param fetcher service
     *
     * @return mixed
     *
     * @throws NotFoundHttpException
     */
    public function getDetailsAction(ParamFetcherInterface $paramFetcher)
    {
        $entity = $this->getOr404($this->getServiceHandle($paramFetcher->get('handle')), $paramFetcher->get('id'));

        return $entity;
    }

    /**
     * Get service handle for the handle provided
     *
     * @param string $handle Service Handle
     *
     * @return mixed
     */
    protected function getServiceHandle($handle)
    {
        return 'ignitho.api.' . strtolower($handle) . '.handler';
    }

    /**
     * Fetch a Page or throw an 404 Exception.
     *
     * @param string $serviceName The name of the service to be called
     * @param mixed  $id          The id of the Entity
     *
     * @return mixed|string
     *
     * @throws NotFoundHttpException
     */
    protected function getOr404($serviceName, $id)
    {
        if (!($result = $this->get($serviceName)->get($id))) {

            throw new NotFoundHttpException(sprintf('The resource \'%s\' was not found.',$id));
        }

        /**
         * @var $serializer \JMS\Serializer\Serializer
         */
        $serializer = $this->get('jms_serializer');
        $result = $serializer->serialize($result, 'json');

        return $result;
    }

    /**
     * Get entity based on handle and id
     *
     * @ApiDoc(
     *   resource = true,
     *   description = "Deletes an Entity for a given id",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when the entity is not found"
     *   }
     * )
     *
     * @QueryParam(name="handle", nullable=false, description="Service Handle")
     * @QueryParam(name="id", requirements="\d+", description="The entity primary key")
     *
     * @Delete("/delete")
     *
     * @param ParamFetcherInterface $paramFetcher Param fetcher service
     *
     * @return mixed
     *
     * @throws NotFoundHttpException
     */
    public function deleteEntityAction($handle, $id)
    {
        $entity = $this->getOr404($this->getServiceHandle($handle), $id);

        if ($entity) {
            $this->get($this->getServiceHandle($handle))->delete($entity);

            $result = [
                'id' => $id,
                'message' => 'deleted'
            ];

            /**
             * @var $serializer \JMS\Serializer\Serializer
             */
            $serializer = $this->get('jms_serializer');
            $result = $serializer->serialize($result, 'json');

            return $result;
        }
    }
}
