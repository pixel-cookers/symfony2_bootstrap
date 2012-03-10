<?php

namespace Pixel\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Mopa\BootstrapBundle\Form\Type\ExampleInputFormType;
use Mopa\BootstrapBundle\Form\Type\ExampleFormsType;
use Mopa\BootstrapBundle\Form\Type\ExampleChoiceFormType;
use Mopa\BootstrapBundle\Form\Type\ExampleInlineFormType;
use Mopa\BootstrapBundle\Form\Type\ExampleSearchFormType;
use Mopa\BootstrapBundle\Form\Type\ExampleHorizontalFormType;
use Mopa\BootstrapBundle\Form\Type\ExampleExtendedFormType;
use Mopa\BootstrapBundle\Form\Type\ExampleExtendedViewFormType;


class DefaultController extends Controller
{
    /**
     * @Route("/", name="core_home")
     * @Template()
     */
    public function indexAction()
    {
        $this->get('session')->setFlash('info', "Message info");
        $this->get('session')->setFlash('error', "Message error");
        $this->get('session')->setFlash('warning', "Message warning");
        $this->get('session')->setFlash('success', "Message success");

        return array();
    }

    /**
     * @Route("/css", name="core_css")
     * @Template()
     */
    public function cssAction()
    {
        return array();
    }

    /**
     * @Route("/forms", name="core_forms")
     * @Template()
     */
    public function formsAction()
    {
        return array();
    }


    /**
     * @Route("/js", name="core_js")
     * @Template()
     */
    public function jsAction()
    {
        return array();
    }
}
