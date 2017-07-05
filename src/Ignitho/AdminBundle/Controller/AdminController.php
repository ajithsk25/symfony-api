<?php

namespace Ignitho\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdminController extends Controller
{
    /**
     * Displays the admin home.
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function homeAction()
    {
        return $this->render('IgnithoAdminBundle:Admin:home.html.twig', array(
            // ...
        ));
    }

}
