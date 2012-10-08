<?php

namespace Kcb\Bundle\VereinsheimBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ProfilType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('vorname', 'text', array('label' => 'Dein Vorname'))
            ->add('nachname', 'text', array('label' => 'Dein Nachname'))
            ->add('handynummer', 'text', array('label' => 'Deine Handynummer'))
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
        return 'kcb_bundle_vereinsheimbundle_profiltype';
    }
}
