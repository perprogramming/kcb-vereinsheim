<?php

namespace Kcb\Bundle\VereinsheimBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Constraints\MinLength;
use Symfony\Component\Validator\Constraints\NotBlank;

class PasswortType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('passwort', 'repeated', array(
                'type' => 'password',
                'invalid_message' => 'Die Passwörter sind nicht identisch.',
                'required' => true,
                'first_options' => array('label' => 'Passwort'),
                'second_options' => array('label' => 'Passwort (Wiederholung)')
            ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'validation_constraint' => new Collection(array(
                'passwort' => array(
                    new NotBlank(array('message' => 'Bitte gib ein Passwort ein!')),
                    new MinLength(array('limit' => 6, 'message' => '|Das Passwort sollte aus mindestens %count% Zeichen bestehen!'))
                )
            ))
        ));
    }

    public function getName()
    {
        return 'kcb_bundle_vereinsheimbundle_passworttype';
    }
}
