<?php

namespace TEW\UserBundle\Controller;

use Sonata\AdminBundle\Controller\CRUDController;

class UserAdminController extends CRUDController
{
    /**
     * {@inheritdoc}
     */
    protected $baseRoutePattern = 'users';
}