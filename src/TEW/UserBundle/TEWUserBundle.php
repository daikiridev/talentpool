<?php

namespace TEW\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class TEWUserBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return 'SonataUserBundle';
    }
}