<?php

namespace Ignitho\ApiBundle\Form;

use Symfony\Component\Form\FormBuilderInterface;

interface ApiFormInterface
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options);
}