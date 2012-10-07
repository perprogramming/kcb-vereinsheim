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

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
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
            $plainPassword = substr(md5(date('r', rand(0, time()))), rand(0, 15), 5);

            $encoder = $this->get('security.encoder_factory')->getEncoder($entity);
            $password = $encoder->encodePassword($plainPassword, $entity->getSalt());
            $entity->setPasswort($password);


            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            $message = \Swift_Message::newInstance()
                ->setSubject('Deine Zugangsdaten')
                ->setFrom('vh@kickercrewbonn.de')
                ->setTo($entity->getEmail())
                ->setBody($this->renderView('KcbVereinsheimBundle:Email:mitglied-angelegt.txt.twig', array('entity' => $entity, 'passwort' => $plainPassword)))
            ;
            $this->get('mailer')->send($message);

            return $this->redirect($this->generateUrl('kcb_vereinsheim_mitglied_show', array('id' => $entity->getId())));
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

        $editForm = $this->createForm(new MitgliedType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
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

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new MitgliedType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('kcb_vereinsheim_mitglied_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * @Route("/{id}/delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, $id) {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('KcbVereinsheimBundle:Mitglied')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Mitglied entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('kcb_vereinsheim_mitglied_index'));
    }

    protected function createDeleteForm($id) {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }

}
