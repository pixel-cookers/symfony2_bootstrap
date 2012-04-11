<?php

/*
 * This file is part of the FOSUserBundle package.
 *
 * (c) FriendsOfSymfony <http://friendsofsymfony.github.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pixel\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

use Symfony\Bridge\Propel1\Form\Type\ModelType;

use FOS\UserBundle\Form\Type\ProfileFormType as BaseType;

class ProfileFormType extends BaseType
{
    public function getName()
    {
        return 'pixel_user_profile';
    }

    protected function buildUserForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('username')
            ->add('email', 'email')
            ->add('books', 'model', array(
                'class' => 'Pixel\BootstrapBundle\Model\Book',
                'multiple' => true,
                'by_reference' => true,
                'required' => false,
            ))
            ->add('like_waffles', 'checkbox', array('required'  => false))
        ;
    }
}
