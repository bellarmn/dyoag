<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Vich\UploaderBundle\Form\Type\VichFileType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use EWZ\Bundle\RecaptchaBundle\Form\Type\EWZRecaptchaType;
use EWZ\Bundle\RecaptchaBundle\Validator\Constraints\IsTrue as RecaptchaTrue;

class DemandType extends AbstractType {

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        //$builder->add('lieu')->add('createAt')->add('quantite')->add('dateLimit')->add('dateLimitUpdate')->add('prixUnit')->add('description')->add('published')->add('canceledAt')->add('canceledReason')->add('available')->add('deleteAt')->add('deleted')->add('permanent')->add('canceled')->add('imageName')->add('updatedAt')->add('measure')->add('product')->add('user')->add('district')        ;
        $builder
                ->add('product', EntityType::class, array(
                    'class' => 'AppBundle:Product',
                    'group_by' => 'category.name',
                    'choice_name' => 'name',
                    'placeholder' => 'Choisissez votre produit',
                    'required' => true
                ))
                ->add('district', EntityType::class, array(
                    'class' => 'AppBundle:District',
                    'group_by' => 'ProvinceCitydata',
                    'choice_name' => 'name',
                    'placeholder' => 'Choisissez votre arrondissement',
                    'required' => true
                ))
                ->add('lieu')
                ->add('quantite')
                ->add('measure', EntityType::class, array(
                    'class' => 'AppBundle:Measure',
                    'label' => 'Unité de mesure',
                    'required' => true,
                    'placeholder' => 'Unités de mesures'
                ))

//            ->add('dateLimit', DateType::class, array(
//                'widget' => 'single_text',
//                'format' => 'dd/MM/yyyy',
//                'placeholder' => 'dd/MM/yyyy'
//            ))
                ->add('prixUnit')
                ->add('description')
                ->add('permanent')
//                ->add('imageFile', VichFileType::class, array(
//                    'required' => false,
//                    'allow_delete' => true, // not mandatory, default is true
//                    'download_link' => true, // not mandatory, default is true
//                ))
                ->add('recaptcha', EWZRecaptchaType::class, array(
                    'attr' => array(
                        'options' => array(
                            'theme' => 'light',
                            'type' => 'image',
                            'size' => 'normal',
                            'defer' => true,
                            'async' => true
                        )
                    ),
                    'mapped' => false,
                    'constraints' => array(
                        new RecaptchaTrue()
                    )
                ))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Demand'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix() {
        return 'appbundle_demand';
    }

}
