<?php

namespace Pixel\BootstrapBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Pixel\BootstrapBundle\Form\Type\ExampleFormsType;
use Pixel\BootstrapBundle\Form\Type\ExampleChoiceFormType;
use Pixel\BootstrapBundle\Form\Type\ExampleInlineFormType;
use Pixel\BootstrapBundle\Form\Type\ExampleSearchFormType;
use Pixel\BootstrapBundle\Form\Type\ExampleHorizontalFormType;
use Pixel\BootstrapBundle\Form\Type\ExampleExtendedFormType;
use Pixel\BootstrapBundle\Form\Type\ExampleExtendedViewFormType;


class BootstrapController extends Controller
{

    /**
     * @Route("/css", name="bootstrap_css")
     * @Template()
     */
    public function cssAction()
    {
        return array();
    }

    /**
     * @Route("/forms", name="bootstrap_forms")
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

        $request = $this->get('request');
        if ('POST' == $request->getMethod()) {
            $form1->bindRequest($request);
        }

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
     * @Route("/js", name="bootstrap_js")
     * @Template()
     */
    public function jsAction()
    {
        return array();
    }
}
