<?php

namespace Kcb\Bundle\VereinsheimBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class StartseiteController extends Controller {

    /**
     * @Route("/")
     * @Template()
     */
    public function startseiteAction() {
        return array();
    }

    /**
     * @Template()
     */
    public function startseiteAnwesendeAction() {
        return array('anwesende' => $this->getDoctrine()->getRepository('KcbVereinsheimBundle:Anwesender')->findAll());
    }

}