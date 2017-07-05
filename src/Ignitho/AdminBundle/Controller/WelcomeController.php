<?php

namespace Ignitho\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class WelcomeController extends Controller
{
    public function frontPageAction()
    {
        return $this->render('IgnithoAdminBundle:Welcome:front_page.html.twig', array(
            // ...
        ));
    }

}
