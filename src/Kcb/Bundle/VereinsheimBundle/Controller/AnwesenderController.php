<?php

namespace Kcb\Bundle\VereinsheimBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Kcb\Bundle\VereinsheimBundle\Entity\Anwesender;
use Kcb\Bundle\VereinsheimBundle\Form\AnwesenderType;

/**
 * Anwesender controller.
 *
 * @Route("/anwesender")
 */
class AnwesenderController extends Controller
{
    /**
     * Lists all Anwesender entities.
     *
     * @Route("/", name="anwesender")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('KcbVereinsheimBundle:Anwesender')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Finds and displays a Anwesender entity.
     *
     * @Route("/{id}/show", name="anwesender_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('KcbVereinsheimBundle:Anwesender')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Anwesender entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to create a new Anwesender entity.
     *
     * @Route("/new", name="anwesender_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Anwesender();
        $form   = $this->createForm(new AnwesenderType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a new Anwesender entity.
     *
     * @Route("/create", name="anwesender_create")
     * @Method("POST")
     * @Template("KcbVereinsheimBundle:Anwesender:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity  = new Anwesender();
        $form = $this->createForm(new AnwesenderType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('anwesender_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Anwesender entity.
     *
     * @Route("/{id}/edit", name="anwesender_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('KcbVereinsheimBundle:Anwesender')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Anwesender entity.');
        }

        $editForm = $this->createForm(new AnwesenderType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Anwesender entity.
     *
     * @Route("/{id}/update", name="anwesender_update")
     * @Method("POST")
     * @Template("KcbVereinsheimBundle:Anwesender:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('KcbVereinsheimBundle:Anwesender')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Anwesender entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new AnwesenderType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('anwesender_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Anwesender entity.
     *
     * @Route("/{id}/delete", name="anwesender_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('KcbVereinsheimBundle:Anwesender')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Anwesender entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('anwesender'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
