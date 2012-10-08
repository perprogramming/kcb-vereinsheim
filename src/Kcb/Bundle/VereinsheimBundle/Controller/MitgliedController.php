<?php

namespace Kcb\Bundle\VereinsheimBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Kcb\Bundle\VereinsheimBundle\Entity\Mitglied;
use Kcb\Bundle\VereinsheimBundle\Form\MitgliedType;

/**
 * @Route("/mitglieder")
 */
class MitgliedController extends Controller
{
    /**
     * @Route("/")
     * @Template()
     */
    public function indexAction() {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('KcbVereinsheimBundle:Mitglied')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * @Route("/{id}/show")
     * @Template()
     */
    public function showAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('KcbVereinsheimBundle:Mitglied')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Mitglied entity.');
        }

        return array(
            'entity'      => $entity
        );
    }

    /**
     * @Route("/new")
     * @Template()
     */
    public function newAction() {
        $entity = new Mitglied();
        $form   = $this->createForm(new MitgliedType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * @Route("/create")
     * @Method("POST")
     * @Template("KcbVereinsheimBundle:Mitglied:new.html.twig")
     */
    public function createAction(Request $request) {
        $entity  = new Mitglied();
        $form = $this->createForm(new MitgliedType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();

            $plainPassword = $this->get('password_generator')->generate();

            $password = $this->get('security.encoder_factory')->getEncoder($entity)->encodePassword($plainPassword, $entity->getSalt());
            $entity->setPasswort($password);

            $entityManager->persist($entity);
            $entityManager->flush();

            $message = \Swift_Message::newInstance()
                ->setSubject('Willkommen')
                ->setFrom('vh@kickercrewbonn.de', 'Vereinsheim Kicker Crew Bonn')
                ->setTo($entity->getEmail())
                ->setBody($this->renderView('KcbVereinsheimBundle:Email:neues-mitglied.txt.twig', array(
                    'mitglied' => $entity,
                    'passwort' => $plainPassword
                )));
            ;

            $this->get('mailer')->send($message);

            $this->get('session')->getFlashBag()->add('mitglied_angelegt', true);

            return $this->redirect($this->generateUrl('kcb_vereinsheim_mitglied_index', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * @Route("/{id}/edit")
     * @Template()
     */
    public function editAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('KcbVereinsheimBundle:Mitglied')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Mitglied entity.');
        }

        $form = $this->createForm(new MitgliedType(), $entity);

        return array(
            'entity'      => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * @Route("/{id}/update")
     * @Method("POST")
     * @Template("KcbVereinsheimBundle:Mitglied:edit.html.twig")
     */
    public function updateAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('KcbVereinsheimBundle:Mitglied')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Mitglied entity.');
        }

        $form = $this->createForm(new MitgliedType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('kcb_vereinsheim_mitglied_index'));
        }

        return array(
            'entity'      => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * @Route("/{id}/delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('KcbVereinsheimBundle:Mitglied')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Mitglied entity.');
        }

        $em->remove($entity);
        $em->flush();

        return $this->redirect($this->generateUrl('kcb_vereinsheim_mitglied_index'));
    }

}
