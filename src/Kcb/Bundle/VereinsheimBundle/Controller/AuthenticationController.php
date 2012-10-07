<?php

namespace Kcb\Bundle\VereinsheimBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * @Route("/authentication")
 */
class AuthenticationController extends Controller {

    /**
     * @Route("/logout")
     */
    public function logout() {
        return array();
    }

}