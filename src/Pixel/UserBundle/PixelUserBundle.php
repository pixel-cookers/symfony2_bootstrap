<?php

namespace Pixel\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class PixelUserBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
