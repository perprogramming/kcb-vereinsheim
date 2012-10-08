<?php

namespace Kcb\Bundle\VereinsheimBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Kcb\Bundle\VereinsheimBundle\Entity\Mitglied;

class CreateAdminCommand extends ContainerAwareCommand {

    protected function configure() {
        $this
            ->setName('kcb:vereinsheim:create-admin');
    }

    protected function execute(InputInterface $input, OutputInterface $output) {
        $em = $this->getContainer()->get('doctrine')->getManager();
        $dialog = $this->getHelperSet()->get('dialog');
        $validator = $this->getContainer()->get('validator');

        $admin = new Mitglied();
        $admin->addRolle('ROLE_ADMIN');

        $output->writeln('<info>Bitte gib die Daten des Administrators ein:</info>');
        foreach (array(
            'vorname' => 'Vorname',
            'nachname' => 'Nachname',
            'email' => 'E-Mail',
            'handynummer' => 'Handynummer'
        ) as $property => $label) {
            $dialog->askAndValidate($output, '<question>' . $label . ':</question> ', function($value) use ($translator, $validator, $property, $admin) {
                $setter = 'set' . ucfirst($property);
                $admin->$setter($value);
                if (($errors = $validator->validateProperty($admin, $property)) && count($errors)) {
                    throw new \Exception($errors[0]->getMessage());
                }
            });
        }

        $errors = $validator->validate($admin);
        if (count($errors)) {
            throw new \Exception($errors[0]->getMessage());
        }

        $plainPassword = $this->getContainer()->get('password_generator')->generate();

        $password = $this->getContainer()->get('security.encoder_factory')->getEncoder($admin)->encodePassword($plainPassword, $admin->getSalt());
        $admin->setPasswort($password);

        $em->persist($admin);
        $em->flush();

        $output->writeln("
<info>
    Der Admin-Zugang wurde angelegt. Das Passwort lautet

            $plainPassword
</info>
");
    }

}