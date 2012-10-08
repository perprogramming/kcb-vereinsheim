<?php

namespace Kcb\Bundle\VereinsheimBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class MitgliedType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('vorname')
            ->add('nachname')
            ->add('email', 'email')
            ->add('handynummer')
            ->add('rollen', 'choice', array(
                'choices' => array(
                    'ROLE_MITGLIED' => 'Mitglied',
                    'ROLE_ADMIN' => 'Admin'
                ),
                'multiple' => true,
                'expanded' => true
            ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Kcb\Bundle\VereinsheimBundle\Entity\Mitglied'
        ));
    }

    public function getName()
    {
        return 'kcb_bundle_vereinsheimbundle_mitgliedtype';
    }
}
