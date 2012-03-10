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


class BootstrapController extends Controller
{

    /**
     * @Route("/bootstrap", name="bootstrap_index")
     * @Template()
     */
    public function indexAction()
    {
   /*     $this->get('session')->setFlash('info', "Message info");
        $this->get('session')->setFlash('error', "Message error");
        $this->get('session')->setFlash('warning', "Message warning");
        $this->get('session')->setFlash('success', "Message success");*/

        return array();
    }

    /**
     * @Route("/bootstrap/css", name="bootstrap_css")
     * @Template()
     */
    public function cssAction()
    {
        return array();
    }

    /**
     * @Route("/bootstrap/forms", name="bootstrap_forms")
     * @Template()
     */
    public function formsAction()
    {
        $form1 = $this->createForm(new ExampleExtendedFormType());

        $form2 = $this->createForm(new ExampleHorizontalFormType());

        $form3 = $this->createForm(new ExampleFormsType());
        $form4 = $this->createForm(new ExampleSearchFormType());
        $form5 = $this->createForm(new ExampleInlineFormType());

        $form6 = $this->createForm(new ExampleChoiceFormType());

        $form7 = $this->createForm(new ExampleExtendedViewFormType());

        return array(
            'form1' => $form1->createView(),
            'form2' => $form2->createView(),
            'form3' => $form3->createView(),
            'form4' => $form4->createView(),
            'form5' => $form5->createView(),
            'form6' => $form6->createView(),
            'form7' => $form7->createView(),
        );
    }

    /**
     * @Route("/bootstrap/js", name="bootstrap_js")
     * @Template()
     */
    public function jsAction()
    {
        return array();
    }
}
