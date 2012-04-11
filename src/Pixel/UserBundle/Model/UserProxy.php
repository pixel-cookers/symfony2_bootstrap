<?php

/*
 * This file is part of the FOSUserBundle package.
 *
 * (c) FriendsOfSymfony <http://friendsofsymfony.github.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pixel\UserBundle\Model;

use FOS\UserBundle\Model\User as FosUser;
use FOS\UserBundle\Model\GroupInterface;
use Symfony\Component\Security\Core\User\UserInterface as SecurityUserInterface;

use FOS\UserBundle\Propel\UserProxy as Base;

class UserProxy extends Base
{
    public function getLikeWaffles()
    {
        return $this->user->getLikeWaffles();
    }

    public function setLikeWaffles($value)
    {
        return $this->user->setLikeWaffles($value);
    }

    public function getBooks()
    {
        return $this->user->getBooks();
    }

    public function setBooks($value)
    {
        return $this->user->setBooks($value);
    }

    public function AddBook($value)
    {
        return $this->user->addBook($value);
    }
}
