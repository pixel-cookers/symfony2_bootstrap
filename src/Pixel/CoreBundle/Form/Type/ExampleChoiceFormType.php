<?php
namespace Pixel\CoreBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;


class ExampleChoiceFormType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('Choice', 'choice', array(
                'label'        => 'Select list',
                'help_inline'  => 'Default settings',
                'choices'      => array('1' => 'one', '2' => 'two'),
            ))
            ->add('Choicemultiple', 'choice', array(
                'label'        => 'Multicon-select',
                'help_inline'  => 'Multiple',
                'multiple'     => true,
                'choices'      => array('1' => 'one', '2' => 'two'),
            ))
            ->add('RadioButtons', 'choice', array(
                'label'        => 'Radio buttons',
                'help_inline'  => 'Expanded',
                'expanded'	   => true,
                'choices'      => array('1' => 'one', '2' => 'two'),
            ))
            ->add('Checkboxes', 'choice', array(
                'label'        => 'Checkboxes',
                'help_inline'  => 'Expanded and multiple',
                'multiple'     => true,
                'expanded'	   => true,
                'choices'      => array('1' => 'one', '2' => 'two'),
            ))
            ->add('CheckboxesInline', 'choice', array(
                'label'        => 'Inline checkboxes',
                'help_inline'  => 'Expanded and multiple (inline)',
                'multiple'     => true,
                'expanded'	   => true,
                'choices'      => array('1' => 'one', '2' => 'two'),
                'widget_type'  => "inline"
            ))
        ;
    }
    public function getName(){
        return "MopaBootstraBundle_Choice_Possibilies";
    }
}

