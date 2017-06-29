<?php

namespace Ignitho\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdminController extends Controller
{
    public function homeAction()
    {
        return $this->render('IgnithoAdminBundle:Admin:home.html.twig', array(
            // ...
        ));
    }

}
