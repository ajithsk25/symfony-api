<?php

namespace Ignitho\AdminBundle\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Ignitho\AdminBundle\Entity\User;
use Ignitho\AdminBundle\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegistrationController extends Controller
{
    public function registerAction(Request $request)
    {
        /**
         * $passwordEncoder UserPasswordEncoderInterface
         */
        $passwordEncoder = $this->get('security.password_encoder');
        /**
         * $em EntityManagerInterface
         */
        $em = $this->get('doctrine.orm.entity_manager');

        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);

            $em->persist($user);
            $em->flush();
        }
        return $this->render('IgnithoAdminBundle:Registration:register.html.twig', array(
            'form' => $form->createView()
        ));
    }

}
