<?php

namespace Ignitho\ApiBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use Ignitho\ApiBundle\Exception\InvalidFormException;
use Ignitho\AdminBundle\Form\PageType;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations\Post;

class PageApiController extends FOSRestController
{
    /**
     * Create an Page from the submitted data.
     *
     * @ApiDoc(
     *   resource = true,
     *   description = "Creates a new page from the submitted data.",
     *   input = "Ignitho\AdminBundle\Form\PageType",
     *   output = "Ignitho\AdminBundle\Entity\Page",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     400 = "Returned when the form has errors"
     *   }
     * )
     *
     * @Post("/create/page")
     *
     * @param Request $request the request object
     *
     * @return mixed
     */
    public function postCreatePageAction(Request $request)
    {
        try {
            $page = new PageType();

            $data = $request->request->get($page->getBlockPrefix()) ? $request->request->get($page->getBlockPrefix()) : array();

            $newPage = $this->get('ignitho.api.page.handler')
                ->post($data);

            return $newPage;

        } catch (InvalidFormException $exception) {

            return $exception->getForm();
        }
    }
}
