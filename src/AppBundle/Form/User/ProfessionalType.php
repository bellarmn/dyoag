<?php

namespace AppBundle\Form\User;

use Ben\UserBundle\Form\RegistrationType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use AppBundle\Entity\User\Professional;

class ProfessionalType extends RegistrationType {
//    public function __construct() {
//        $this->class = new Professional();
//    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        parent::buildForm($builder, $options);
        $builder
                ->add('nomEntreprise')
                ->add('adresse')
                ->add('ifu')
                ->add('rcc')
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\User\Professional'
        ));
    }

}
