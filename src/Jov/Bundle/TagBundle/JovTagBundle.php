<?php

namespace Jov\Bundle\TagBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class JovTagBundle extends Bundle
{
    public function getParent()
    {
        return 'OroTagBundle';
    }
}
