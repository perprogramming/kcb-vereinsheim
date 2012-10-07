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
            ->setName('kcb:vereinsheim:create-admin')
            ->addArgument('login', InputArgument::REQUIRED)
            ->addArgument('password', InputArgument::REQUIRED);
    }

    protected function execute(InputInterface $input, OutputInterface $output) {
        $em = $this->getContainer()->get('doctrine')->getManager();

        $admin = new Mitglied();
        $admin->setBenutzername($input->getArgument('login'));

        $encoder = $this->getContainer()->get('security.encoder_factory')->getEncoder($admin);
        $admin->setPasswort(
            $encoder->encodePassword(
                $input->getArgument('password'),
                $admin->getSalt()
            )
        );

        $admin->addRole('ROLE_ADMIN');

        $em->persist($admin);
        $em->flush();
    }

}