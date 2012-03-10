<?php

namespace Acme\DemoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class WelcomeController extends Controller
{
    public function indexAction()
    {
        $this->setFlashSuccess('Congratulation, your article has been saved.');

        return $this->render('AcmeDemoBundle:Welcome:index.html.twig');
    }

    protected function setFlashSuccess($message)
    {
        $this->get('session')->setFlash('alert-success', $message);
    }

    protected function setFlashError($message)
    {
        $this->get('session')->setFlash('alert-error', $message);
    }
}
