<?php

namespace Kcb\Bundle\VereinsheimBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Kcb\Bundle\VereinsheimBundle\Entity\Anwesender;

/**
 * @Route("/anwesende")
 */
class AnwesenderController extends Controller {

    /**
     * @Route("/show/{id}")
     * @Template()
     */
    public function showAction($id) {
        return array('anwesender' => $this->getAnwesenderRepository()->find($id));
    }

    /**
     * @Route("/toggle")
     * @Method("POST")
     */
    public function toggle() {
        $em = $this->getDoctrine()->getManager();
        $mitglied = $this->getUser();
        if ($anwesender = $this->getAnwesenderRepository()->findOneByMitglied($mitglied)) {
            $em->remove($anwesender);
        } else {
            $em->persist(new Anwesender($mitglied));
        }
        $em->flush();
        return $this->redirect($this->generateUrl('kcb_vereinsheim_startseite_startseite'));
    }

    protected function getAnwesenderRepository() {
        return $this->getDoctrine()->getRepository('KcbVereinsheimBundle:Anwesender');
    }

}