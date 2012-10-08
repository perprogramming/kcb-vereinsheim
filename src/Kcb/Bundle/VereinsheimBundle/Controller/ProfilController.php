<?php

namespace Kcb\Bundle\VereinsheimBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Kcb\Bundle\VereinsheimBundle\Form\ProfilType;
use Kcb\Bundle\VereinsheimBundle\Form\EmailType;
use Kcb\Bundle\VereinsheimBundle\Form\PasswortType;
use Symfony\Component\HttpFoundation\Request;
use Kcb\Bundle\VereinsheimBundle\Entity\Mitglied;

/**
 * @Route("/profil")
 */
class ProfilController extends Controller {

    /**
     * @Route("/")
     * @Template()
     */
    public function profilAction() {
        return array();
    }

    /**
     * @Route("/edit")
     * @Template()
     */
    public function editAction() {
        $mitglied = $this->getUser();
        $form = $this->createForm(new ProfilType(), $mitglied);

        return array(
            'form' => $form->createView()
        );
    }

    /**
     * @Route("/update")
     * @Method("POST")
     * @Template("KcbVereinsheimBundle:Profil:edit.html.twig")
     */
    public function updateAction(Request $request) {
        $mitglied = $this->getUser();
        $form = $this->createForm(new ProfilType(), $mitglied);
        $form->bind($request);

        if ($form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            return $this->redirect($this->generateUrl('kcb_vereinsheim_profil_profil'));
        }

        return array(
            'form' => $form->createView()
        );
    }

    /**
     * @Route("/passwort")
     * @Template()
     */
    public function editPasswortAction() {
        $form = $this->createForm(new PasswortType());

        return array(
            'form' => $form->createView()
        );
    }

    /**
     * @Route("/passwort/update")
     * @Method("POST")
     * @Template("KcbVereinsheimBundle:Profil:editPasswort.html.twig")
     */
    public function updatePasswortAction(Request $request) {
        $form = $this->createForm(new PasswortType());
        $form->bind($request);

        if ($form->isValid()) {
            $mitglied = $this->getUser();
            $data = $form->getData();
            $plainPassword = $data['passwort'];

            $password = $this->get('security.encoder_factory')->getEncoder($mitglied)->encodePassword($plainPassword, $mitglied->getSalt());
            $mitglied->setPasswort($password);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirect($this->generateUrl('kcb_vereinsheim_profil_profil'));
        }

        return array(
            'form' => $form->createView()
        );
    }

    /**
     * @Route("/email")
     * @Template()
     */
    public function editEmailAction() {
        $mitglied = $this->getUser();
        $form = $this->createForm(new EmailType(), $mitglied);

        return array(
            'form' => $form->createView()
        );
    }

    /**
     * @Route("/email/update")
     * @Method("POST")
     * @Template("KcbVereinsheimBundle:Profil:editEmail.html.twig")
     */
    public function updateEmailAction(Request $request) {
        $mitglied = $this->getUser();
        $alteEmail = $mitglied->getEmail();
        $form = $this->createForm(new EmailType(), $mitglied);
        $form->bind($request);

        if ($form->isValid()) {
            $neueEmail = $mitglied->getEmail();

            if ($alteEmail != $neueEmail) {
                $message = \Swift_Message::newInstance()
                    ->setSubject('E-Mail-Adresse ändern')
                    ->setFrom('vh@kickercrewbonn.de', 'Vereinsheim Kicker Crew Bonn')
                    ->setTo($neueEmail)
                    ->setBody($this->renderView('KcbVereinsheimBundle:Email:email-adresse-aendern.txt.twig', array(
                        'mitglied' => $mitglied,
                        'alteEmail' => $alteEmail,
                        'neueEmail' => $neueEmail,
                        'activationLink' => $this->createActivationLink($mitglied->getId(), $neueEmail)
                    )));
                ;
                $this->get('mailer')->send($message);
            }

            return $this->redirect($this->generateUrl('kcb_vereinsheim_profil_profil'));
        }

        return array(
            'form' => $form->createView()
        );
    }

    /**
     * @Route("/activate/{hash}/{email}/{id}/{timestamp}")
     * @Template()
     */
    public function activateEmailAction($hash, $email, $id, $timestamp) {

        if ($activated = $this->checkActivation($id, $email, $hash, $timestamp)) {
            $mitglied = $this->getDoctrine()->getRepository('KcbVereinsheimBundle:Mitglied')->find($id);
            $mitglied->setEmail($email);
            $this->getDoctrine()->getManager()->flush();
        }

        return array(
            'activated' => $activated,
            'neueEmail' => $email
        );
    }


    protected function createActivationLink($id, $email) {
        $timestamp = time();
        return $this->generateUrl('kcb_vereinsheim_profil_activateemail', array(
            'hash' => $this->createHash($id, $timestamp, $email),
            'email' => $email,
            'id' => $id,
            'timestamp' => $timestamp
        ), true);
    }

    protected function checkActivation($id, $email, $hash, $timestamp) {
        if ($hash == $this->createHash($id, $timestamp, $email)) {
            if ((time() - intval($timestamp)) < 3600) {
                return true;
            }
        }
        return false;
    }

    protected function createHash($id, $timestamp, $email) {
        $secret = $this->container->getParameter('secret');
        return md5("$secret.$id.$timestamp.$email");
    }

}