<?php

namespace Ignitho\ApiBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Controller\Annotations;

class UserApiController extends FOSRestController
{
    /**
     * Get single Page.
     *
     * @ApiDoc(
     *     resource = true,
     *     description = "Gets a Page for a given id",
     *     output = "Acme\ApiBundle\Entity\Page",
     *     statusCodes = {
     *         200 = "Returned when successful",
     *         404 = "Returned when the page is not found"
     *     }
     * )
     *
     * @Annotations\View(templateVar="page")
     * @param int $id the page id
     * @return array
     * @throws NotFoundHttpException when page not exist
     */
    public function getPageAction($id)
    {
        $user = $this->getOr404($id);
        return $user;
    }

    protected function getOr404($id)
    {
        if (!($page = $this->container->get('acme_api.page.handler')->get($id))) {
            throw new NotFoundHttpException(sprintf('The resource \'%s\' was not found.',$id));
        }
        return $page;
    }

//    /**
//     * List all pages.
//     *
//     * @ApiDoc(
//     * resource = true,
//     * statusCodes = {
//     * 200 = "Returned when successful"
//     * }
//     * )
//     *
//     * @Annotations\QueryParam(name="offset", requirements="\d+", nullable=true, description="Offset from which to start listing pages.")
//     * @Annotations\QueryParam(name="limit", requirements="\d+", default="5", description="How many pages to return.")
//     *
//     * @Annotations\View(templateVar="pages")
//     *
//     * @param Request $request the request object
//     * @param ParamFetcherInterface $paramFetcher param fetcher service
//     *
//     * @return array
//     */
//    public function getPagesAction(Request $request, ParamFetcherInterface $paramFetcher)
//    {
//        return $this->container->get('acme_api.page.handler')->all();
//    }

//    /**
//     * Presents the form to use to create a new page.
//     *
//     * @ApiDoc(
//     * resource = true,
//     * statusCodes = {
//     * 200 = "Returned when successful"
//     * }
//     * )
//     *
//     * @Annotations\View(
//     * templateVar = "form"
//     * )
//     *
//     * @return FormTypeInterface
//     */
//    public function newPageAction()
//    {
//        return $this->createForm(new PageType());
//    }
//
//    /**
//     * Create a Page from the submitted data.
//     *
//     * @ApiDoc(
//     * resource = true,
//     * description = "Creates a new page from the submitted data.",
//     * input = "Acme\ApiBundle\Form\PageType",
//     * statusCodes = {
//     * 200 = "Returned when successful",
//     * 400 = "Returned when the form has errors"
//     * }
//     * )
//     *
//     * @Annotations\View(
//     * template = "AcmeApiBundle:Page:newPage.html.twig",
//     * statusCode = Codes::HTTP_BAD_REQUEST,
//     * templateVar = "form"
//     * )
//     *
//     * @param Request $request the request object
//     *
//     * @return FormTypeInterface|View
//     */
//    public function postPageAction(Request $request)
//    {
//        try {
//            // Hey Page handler create a new Page.
//            $form = new PageType();
//            $newPage = $this->container->get('acme_api.page.handler')->post(
//                $request->request->get($form->getName())
//            );
//            $routeOptions = array(
//                'id' => $newPage->getId(),
//                '_format' => $request->get('_format')
//            );
//            return $this->routeRedirectView('api_1_get_page', $routeOptions, Codes::HTTP_CREATED);
//        } catch (InvalidFormException $exception) {
//            return $exception->getForm();
//        }
//    }
}
