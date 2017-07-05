<?php

namespace Ignitho\AdminBundle\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Ignitho\AdminBundle\Entity\Page;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Page controller.
 *
 */
class PageController extends Controller
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var Request
     */
    private $request;

    /**
     * PageController constructor.
     *
     * @param EntityManagerInterface $em
     * @param Request $request
     */
    public function __construct(EntityManagerInterface $em, Request $request)
    {
        $this->em = $em;
        $this->request = $request;
    }

    /**
     * Lists all page entities.
     *
     */
    public function indexAction()
    {
        $pages = $this->em->getRepository('IgnithoAdminBundle:Page')->findAll();

        return $this->render('IgnithoAdminBundle:Page:index.html.twig', array(
            'pages' => $pages,
        ));
    }

    /**
     * To create new page
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function newAction()
    {
        $page = new Page();
        $form = $this->createForm('Ignitho\AdminBundle\Form\PageType', $page);
        $form->handleRequest($this->request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($page);
            $this->em->flush();

            return $this->redirectToRoute('ignitho.admin.page_show', array('id' => $page->getId()));
        }

        return $this->render('IgnithoAdminBundle:Page:new.html.twig', array(
            'page' => $page,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a page entity.
     *
     * @param Page $page
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction(Page $page)
    {
        $deleteForm = $this->createDeleteForm($page);

        return $this->render('IgnithoAdminBundle:Page:show.html.twig', array(
            'page' => $page,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing page entity.
     *
     * @param Page $page
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Page $page)
    {
        $deleteForm = $this->createDeleteForm($page);
        $editForm = $this->createForm('Ignitho\AdminBundle\Form\PageType', $page);
        $editForm->handleRequest($this->request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('ignitho.admin.page_edit', array('id' => $page->getId()));
        }

        return $this->render('IgnithoAdminBundle:Page:edit.html.twig', array(
            'page' => $page,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a page entity.
     *
     * @param Page $page
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(Page $page)
    {
        $form = $this->createDeleteForm($page);
        $form->handleRequest($this->request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($page);
            $em->flush();
        }

        return $this->redirectToRoute('ignitho.admin.page_index');
    }

    /**
     * Creates a form to delete a page entity.
     *
     * @param Page $page The page entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Page $page)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('ignitho.admin.page_delete', array('id' => $page->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
