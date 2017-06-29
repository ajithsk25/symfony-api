<?php

namespace Ignitho\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PageController extends Controller
{
    public function welcomeAction()
    {
        return $this->render('IgnithoAdminBundle:Page:welcome.html.twig', array(
            // ...
        ));
    }

}
